<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Courier;
use App\Models\Agent;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard(){
        $total_shipments = \App\Models\Courier::count();
        $in_progress = \App\Models\Courier::where('status', 'in_transit')->count();
        $delivered = \App\Models\Courier::where('status', 'delivered')->count();
        $pending = \App\Models\Courier::where('status', 'pending')->count();
        $active_deployments = \App\Models\Courier::whereIn('status', ['in_transit', 'pending'])->orderBy('created_at', 'desc')->take(5)->get();
        
        $chart_labels = [];
        $chart_data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
            $chart_labels[] = \Carbon\Carbon::now()->subDays($i)->format('D');
            $chart_data[] = \App\Models\Courier::whereDate('created_at', $date)->count();
        }

        return view('admin.dashboard', compact('total_shipments', 'in_progress', 'delivered', 'pending', 'active_deployments', 'chart_labels', 'chart_data'));
    }

    public function customers(Request $request){
        $search = $request->input('search');
        $query = \App\Models\Customer::query();

        if ($search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
        }
        
        $customers = $query->paginate(20);

        if ($request->ajax()) {
            return view('admin.partials.customer_rows', compact('customers'))->render();
        }

        return view('admin.customers', compact('customers', 'search'));
    }

    public function edit_customer($id){
        $customer = \App\Models\Customer::findOrFail($id);
        return view('admin.edit_customer', compact('customer'));
    }

    public function update_customer(Request $request, $id){
        $customer = \App\Models\Customer::findOrFail($id);
        $customer->update($request->all());
        return redirect()->route('admin.customers')->with('success', 'Customer updated successfully');
    }

    public function delete_customer($id){
        \App\Models\Customer::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Customer deleted successfully');
    }

    public function agents(){
        return view('admin.agents');
    }

    public function couriers(){
        $couriers = Courier::all();
        return view('admin.couriers', compact('couriers'));
    }

    public function reports(){
        return view('admin.reports');
    }

    public function download_report(Request $request){
        $query = \App\Models\Courier::query();
        
        if($request->filled('start_date') && $request->filled('end_date')){
            $query->whereBetween('created_at', [$request->start_date." 00:00:00", $request->end_date." 23:59:59"]);
        }
        
        if($request->filled('city')){
            $query->where(function($q) use ($request) {
                $q->where('from_city', 'like', "%{$request->city}%")
                  ->orWhere('to_city', 'like', "%{$request->city}%");
            });
        }
        
        $shipments = $query->get();
        
        $filename = "shipment_report_" . date('Y-m-d_H-i') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        
        $columns = [
            'Tracking ID', 'Sender Name', 'Origin City', 
            'Receiver Name', 'Destination City', 'Current Status', 'Logged Timestamp'
        ];
        
        $callback = function() use($shipments, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            foreach ($shipments as $ship) {
                $row = [
                    $ship->tracking_number,
                    $ship->sender_name,
                    $ship->from_city,
                    $ship->receiver_name,
                    $ship->to_city,
                    str_replace("_", " ", strtoupper($ship->status)),
                    $ship->created_at->format('Y-m-d H:i:s')
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function login(){
        return view('admin.login');
    }

    public function login_submit(Request $request){
        $admin = \App\Models\Admin::where('email', $request->email)->first();
        
        $isValid = false;
        if ($admin) {
            if (preg_match('/^\$2[ayb]\$.{56}$/', $admin->password)) {
                $isValid = \Illuminate\Support\Facades\Hash::check($request->password, $admin->password);
            } else {
                $isValid = ($admin->password === $request->password);
            }
        }

        if ($admin && $isValid) {
            $request->session()->put('admin_logged_in', true);
            $request->session()->put('admin_id', $admin->id);
            $request->session()->put('admin_name', $admin->name);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Access Granted. Secure Session Initialized.',
                    'redirect' => route('admin.dashboard')
                ]);
            }
            return redirect('/admin/dashboard');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Credentials Denied. Access restricted.'
            ], 401);
        }

        return redirect()->back()->with('error', 'Invalid Credentials Denied.');
    }

    public function logout(Request $request){
        $request->session()->forget(['admin_logged_in', 'admin_id', 'admin_name']);
        return redirect('/admin/login');
    }

    public function sms(){
        $couriers = \App\Models\Courier::orderBy('created_at', 'desc')->get();
        return view('admin.sms', compact('couriers'));
    }

    public function send_sms(Request $request){
        $request->validate([
            'courier_id' => 'required|exists:courier,id',
            'sms_type' => 'required|in:dispatch,delivery'
        ]);

        $courier = \App\Models\Courier::find($request->courier_id);
        
        $message = "";
        if ($request->sms_type === 'dispatch') {
            $message = "Your package {$courier->tracking_number} has been dispatched from {$courier->from_city} to {$courier->to_city}.";
        } else {
            $message = "Your package {$courier->tracking_number} has been successfully delivered! Thank you for using our service.";
        }

        // Simulate SMS sending by logging it
        \Illuminate\Support\Facades\Log::info("[SMS SIMULATION] Sent to {$courier->receiver_phone}: {$message}");

        return back()->with('success', "Simulated SMS sent to {$courier->receiver_phone} successfully!");
    }

    public function status(){
        return view('admin.status');
    }

    public function profile(){
        $result = Admin::first() ?? new Admin(['name' => 'System Admin', 'email' => 'admin@courierpro.com', 'id' => 1]);
        return view('admin.profile', compact('result'));
    }

    public function edit_admin($id){
        $result = Admin::find($id);
        return view('admin.profile', compact('result'));
    }

    public function update_admin(Request $request,$id){
        $myobject = Admin::find($id);
        
        if($request->has('name')) $myobject->name = $request->name;
        if($request->has('email')) $myobject->email = $request->email;
        if($request->filled('password')) $myobject->password = $request->password;
        
        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $myobject->image = $filename;
        }
        
        $myobject->save();
        return redirect()->route('admin.profile');
    }

    public function add_new_courier(){
        $agents = Agent::where('is_active', 1)->get();
        return view('admin.add_new_courier', compact('agents'));
    }

    public function store_courier(Request $request){
        $myobject = new Courier();
        
        $myobject->tracking_number = 'CP-X-'.rand(1000, 9999);
        $myobject->agent_id = $request->agent_id;
        $myobject->delivery_time = $request->delivery_time;
        $myobject->sender_name = $request->sender_name;
        $myobject->sender_phone = $request->sender_phone;
        $myobject->sender_address = $request->sender_address;
        $myobject->receiver_name = $request->receiver_name;
        $myobject->receiver_phone = $request->receiver_phone;
        $myobject->receiver_address = $request->receiver_address;
        $myobject->from_city = $request->from_city;
        $myobject->to_city = $request->to_city;
        $myobject->parcel_type = $request->parcel_type;
        $myobject->weight = $request->weight;
        $myobject->price = $request->price;
        
        $myobject->save();

        // Sync Sender to Customer Registry
        \App\Models\Customer::updateOrCreate(
            ['phone' => $request->sender_phone],
            [
                'name' => $request->sender_name,
                'address' => $request->sender_address,
                'city' => $request->from_city,
            ]
        );

        // Sync Receiver to Customer Registry
        \App\Models\Customer::updateOrCreate(
            ['phone' => $request->receiver_phone],
            [
                'name' => $request->receiver_name,
                'address' => $request->receiver_address,
                'city' => $request->to_city,
            ]
        );

        return redirect()->route('admin.add_new_courier')->with('success', 'Courier added successfully!');
    }

    public function delete_courier($id){
        Courier::find($id)->delete();
        return redirect()->back();
    }

    public function update_courier($id){
        $ship = Courier::find($id);
        $agents = Agent::where('is_active', 1)->get();
        return view('admin.update_courier', compact('ship', 'agents'));
    }

    public function execute_update_courier(Request $request, $id){
        $myobject = Courier::find($id);
        $myobject->agent_id = $request->agent_id;
        $myobject->delivery_time = $request->delivery_time;
        $myobject->sender_name = $request->sender_name;
        $myobject->sender_phone = $request->sender_phone;
        $myobject->sender_address = $request->sender_address;
        $myobject->receiver_name = $request->receiver_name;
        $myobject->receiver_phone = $request->receiver_phone;
        $myobject->receiver_address = $request->receiver_address;
        $myobject->from_city = $request->from_city;
        $myobject->to_city = $request->to_city;
        $myobject->parcel_type = $request->parcel_type;
        $myobject->weight = $request->weight;
        $myobject->price = $request->price;
        $myobject->status = $request->status;
        
        $myobject->save();

        // Sync Sender to Customer Registry
        \App\Models\Customer::updateOrCreate(
            ['phone' => $request->sender_name ? $request->sender_phone : ''],
            [
                'name' => $request->sender_name,
                'address' => $request->sender_address,
                'city' => $request->from_city,
            ]
        );

        // Sync Receiver to Customer Registry
        \App\Models\Customer::updateOrCreate(
            ['phone' => $request->receiver_name ? $request->receiver_phone : ''],
            [
                'name' => $request->receiver_name,
                'address' => $request->receiver_address,
                'city' => $request->to_city,
            ]
        );

        return redirect('/admin/couriers')->with('success', 'Bill updated successfully');
    }

    public function print_shipment($id){
        $shipment = \App\Models\Courier::findOrFail($id);
        return view('admin.print_waybill', compact('shipment'));
    }

    public function create_agent(){
        $branches = Branch::where('is_active', 1)->get();
        return view('admin.create_agent', compact('branches'));
    }

    public function store_agent(Request $request){
        $request->validate([
            'email' => 'required|email|unique:agents,email',
            'username' => 'required|unique:agents,username',
        ]);

        $myobject = new Agent();
        
        $myobject->agent_code = 'AGT-'.rand(1000, 9999);
        $myobject->name = $request->name;
        $myobject->email = $request->email;
        $myobject->phone = $request->phone;
        $myobject->username = $request->username;
        $myobject->password = Hash::make($request->password);
        $myobject->branch_name = $request->branch_name;
        $myobject->city = $request->city;
        $myobject->from_city = $request->from_city;
        $myobject->to_city = $request->to_city;
        $myobject->is_active = 1;
        $myobject->address = $request->address;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $myobject->image = $filename;
        }
        
        $myobject->save();
        return redirect()->route('admin.add_new_agent')->with('success', 'Agent added successfully!');
    }

    public function show_agent(){
        $agents = Agent::all();
        return view('admin.show_agent', compact('agents'));
    }

    public function delete_agent($id){
        Agent::find($id)->delete();
        return redirect()->back()->with('success', 'Agent deleted successfully');
    }

    public function update_agent($id){
        $agent = Agent::find($id);
        $branches = Branch::where('is_active', 1)->get();
        return view('admin.update_agent', compact('agent', 'branches'));
    }

    public function execute_update_agent(Request $request, $id){
        $request->validate([
            'email' => 'required|email|unique:agents,email,'.$id,
            'username' => 'required|unique:agents,username,'.$id,
        ]);

        $myobject = Agent::find($id);
        $myobject->name = $request->name;
        $myobject->email = $request->email;
        $myobject->phone = $request->phone;
        $myobject->username = $request->username;
        if($request->filled('password')) {
            $myobject->password = Hash::make($request->password);
        }
        $myobject->branch_name = $request->branch_name;
        $myobject->city = $request->city;
        $myobject->from_city = $request->from_city;
        $myobject->to_city = $request->to_city;
        $myobject->is_active = $request->has('is_active') ? 1 : 0;
        $myobject->address = $request->address;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $myobject->image = $filename;
        }
        
        $myobject->save();
        return redirect()->back()->with('success', 'Agent updated successfully!');
    }
    
}
