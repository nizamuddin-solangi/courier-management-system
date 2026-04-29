<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Courier;
use App\Models\Agent;
use App\Models\Branch;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Support\Exports\XlsxExport;

class AdminController extends Controller
{
    public function dashboard(){
        if (session('admin_is_demo')) {
            return view('admin.dashboard', [
                'total_shipments' => 0, 'in_progress' => 0, 'delivered' => 0, 'pending' => 0,
                'active_deployments' => collect(), 'chart_labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], 
                'chart_data' => [0,0,0,0,0,0,0], 'agent_capacity' => 0, 'delivery_throughput' => 0, 
                'recent_telemetry' => ['Sandbox mode active', 'No production data visible', 'System isolated']
            ]);
        }

        $total_shipments = \App\Models\Courier::count();
        $in_progress = \App\Models\Courier::where('status', 'in_transit')->count();
        $delivered = \App\Models\Courier::where('status', 'delivered')->count();
        $pending = \App\Models\Courier::where('status', 'pending')->count();
        $active_deployments = \App\Models\Courier::whereIn('status', ['in_transit', 'pending'])->orderBy('created_at', 'desc')->take(5)->get();
        
        // Agent Stats for Pulse
        $active_agents_count = \App\Models\Agent::where('is_active', 1)->count();
        $total_agents_count = \App\Models\Agent::count();
        $agent_capacity = $total_agents_count > 0 ? round(($active_agents_count / $total_agents_count) * 100) : 0;

        // Delivery Throughput for Pulse
        $delivery_throughput = $total_shipments > 0 ? round(($delivered / $total_shipments) * 100) : 0;

        // Recent Telemetry logs
        $latest_shipments = \App\Models\Courier::orderBy('updated_at', 'desc')->take(3)->get();
        $recent_telemetry = [];
        foreach($latest_shipments as $ship) {
            $status = str_replace('_', ' ', strtoupper($ship->status));
            $recent_telemetry[] = "Shipment #{$ship->tracking_number} {$status} in {$ship->to_city}";
        }
        if(empty($recent_telemetry)) $recent_telemetry = ['No recent telemetry recorded', 'Waiting for system handshake...', 'Network throughput optimal'];

        $chart_labels = [];
        $chart_data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
            $chart_labels[] = \Carbon\Carbon::now()->subDays($i)->format('D');
            $chart_data[] = \App\Models\Courier::whereDate('created_at', $date)->count();
        }

        return view('admin.dashboard', compact(
            'total_shipments', 'in_progress', 'delivered', 'pending', 
            'active_deployments', 'chart_labels', 'chart_data', 
            'agent_capacity', 'delivery_throughput', 'recent_telemetry'
        ));
    }

    public function customers(Request $request){
        if (session('admin_is_demo')) {
            $customers = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
            return view('admin.customers', compact('customers'))->with('search', '');
        }
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
        if (session('admin_is_demo')) {
            return redirect()->back()->with('error', 'Data mutation restricted in Sandbox Mode.');
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+]+$/'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:500'],
        ], [
            'name.regex' => 'The name must only contain letters and spaces (e.g., John Doe).',
            'phone.regex' => 'The phone number must only contain digits and the plus symbol (e.g., +923001234567).',
        ]);

        $customer = \App\Models\Customer::findOrFail($id);
        $customer->update($request->all());
        return redirect()->route('admin.customers')->with('success', 'Customer updated successfully');
    }

    public function delete_customer($id){
        if (session('admin_is_demo')) {
            return redirect()->back()->with('error', 'Data deletion restricted in Sandbox Mode.');
        }
        \App\Models\Customer::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Customer deleted successfully');
    }

    public function agents(){
        if (session('admin_is_demo')) {
            return view('admin.agents');
        }
        return view('admin.agents');
    }

    public function couriers(){
        if (session('admin_is_demo')) {
            $couriers = collect();
            return view('admin.couriers', compact('couriers'));
        }
        $couriers = Courier::all();
        return view('admin.couriers', compact('couriers'));
    }

    public function reports(){
        return view('admin.reports');
    }

    public function download_report(Request $request){
        if (session('admin_is_demo')) {
            return back()->with('error', 'Report generation restricted in Sandbox Mode.');
        }
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

        $columns = [
            'Tracking ID',
            'Sender Name',
            'Origin City',
            'Receiver Name',
            'Destination City',
            'Current Status',
            'Logged Timestamp',
        ];

        $rows = [];
        foreach ($shipments as $ship) {
            $rows[] = [
                $ship->tracking_number,
                $ship->sender_name,
                $ship->from_city,
                $ship->receiver_name,
                $ship->to_city,
                str_replace("_", " ", strtoupper($ship->status)),
                optional($ship->created_at)->format('Y-m-d H:i:s'),
            ];
        }

        $filename = "shipment_report_" . date('Y-m-d_H-i') . ".xlsx";
        return XlsxExport::download($filename, $columns, $rows);
    }

    public function login(){
        return view('admin.login');
    }

    public function login_submit(Request $request){
        // Demo Login Check
        if ($request->email === 'admin@demo.com' && $request->password === 'password123') {
            $admin = \App\Models\Admin::first(); // Use first available admin for demo
        } else {
            $admin = \App\Models\Admin::where('email', $request->email)->first();
        }
        
        $isValid = false;
        if ($admin) {
            // Handle Demo Bypass
            if ($request->email === 'admin@demo.com' && $request->password === 'password123') {
                $isValid = true;
            } 
            // Support both hashed and plain
            elseif (preg_match('/^\$2[ayb]\$.{56}$/', $admin->password)) {
                $isValid = \Illuminate\Support\Facades\Hash::check($request->password, $admin->password);
            } else {
                $isValid = ($admin->password === $request->password);
            }
        }

        if ($admin && $isValid) {
            $request->session()->put('admin_logged_in', true);
            $request->session()->put('admin_id', $admin->id);
            $request->session()->put('admin_name', $admin->name);
            
            // Set Demo Mode Flag
            if ($request->email === 'admin@demo.com') {
                $request->session()->put('admin_is_demo', true);
                $request->session()->put('admin_name', 'Demo Administrator');
            } else {
                $request->session()->put('admin_is_demo', false);
            }
            
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
        if (session('admin_is_demo')) {
            return back()->with('error', 'SMS transmission restricted in Sandbox Mode.');
        }
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

        // Store notifications for registered users using robust phone matching (last 10 digits)
        $p1 = $courier->sender_phone;
        $p2 = $courier->receiver_phone;

        $recipientUsers = User::query()
            ->where(function($q) use ($p1, $p2) {
                if ($p1 && strlen($p1) >= 10) $q->where('phone', 'like', '%' . substr($p1, -10));
                if ($p2 && strlen($p2) >= 10) $q->orWhere('phone', 'like', '%' . substr($p2, -10));
            })
            ->get();

        foreach ($recipientUsers as $u) {
            Notification::create([
                'user_id' => $u->id,
                'courier_id' => $courier->id,
                'type' => 'sms',
                'title' => $request->sms_type === 'dispatch' ? 'Shipment Dispatched' : 'Shipment Delivered',
                'message' => $message,
                'sent_by_type' => 'admin',
                'sent_by_id' => $request->session()->get('admin_id'),
            ]);
        }

        return back()->with('success', "Simulated SMS sent successfully!");
    }

    public function status(){
        return view('admin.status');
    }

    public function profile(){
        if (session('admin_is_demo')) {
            $result = new Admin([
                'name' => 'Demo Administrator',
                'email' => 'admin@demo.com',
                'id' => 999
            ]);
            return view('admin.profile', compact('result'));
        }
        $result = Admin::first() ?? new Admin(['name' => 'System Admin', 'email' => 'admin@rapidroute.com', 'id' => 1]);
        return view('admin.profile', compact('result'));
    }

    public function edit_admin($id){
        if (session('admin_is_demo')) {
            return redirect()->route('admin.profile');
        }
        $result = Admin::findOrFail($id);
        return view('admin.profile', compact('result'));
    }

    public function update_admin(Request $request,$id){
        if (session('admin_is_demo')) {
            return back()->with('error', 'Profile modification restricted in Sandbox Mode.');
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'unique:admin,email,'.$id],
            'password' => ['nullable', 'min:6'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.regex' => 'The name must only contain letters and spaces.',
            'image.image' => 'The file must be an image (JPG, PNG, WebP).',
        ]);

        $myobject = Admin::find($id);
        
        if($request->has('name')) $myobject->name = $request->name;
        if($request->has('email')) $myobject->email = $request->email;
        if($request->filled('password')) $myobject->password = \Illuminate\Support\Facades\Hash::make($request->password);
        
        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $myobject->image = $filename;
        }
        
        $myobject->save();
        return redirect()->route('admin.profile')->with('success', 'Admin profile updated successfully');
    }

    public function add_new_courier(){
        $agents = Agent::where('is_active', 1)->get();
        return view('admin.add_new_courier', compact('agents'));
    }

    public function store_courier(Request $request){
        if (session('admin_is_demo')) {
            return redirect()->back()->with('error', 'Shipment creation restricted in Sandbox Mode.');
        }
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'delivery_date' => 'required|date|after_or_equal:today',
            'delivery_time' => 'required',
            'sender_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'sender_phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+]+$/'],
            'sender_address' => 'required|string|max:500',
            'receiver_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'receiver_phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+]+$/'],
            'receiver_address' => 'required|string|max:500',
            'from_city' => 'required|string',
            'to_city' => 'required|string',
            'parcel_type' => 'required|string',
            'weight' => 'required|numeric|min:0.1',
            'price' => 'required|numeric|min:0',
        ], [
            'sender_name.regex' => 'Sender name must contain only letters and spaces (e.g., Jane Smith).',
            'receiver_name.regex' => 'Receiver name must contain only letters and spaces (e.g., Bob Johnson).',
            'delivery_date.after_or_equal' => 'The delivery date cannot be in the past.',
            'sender_phone.regex' => 'Sender phone must only contain digits and +.',
            'receiver_phone.regex' => 'Receiver phone must only contain digits and +.',
        ]);

        $myobject = new Courier();
        
        $myobject->tracking_number = 'CP-X-'.rand(1000, 9999);
        $myobject->agent_id = $request->agent_id;
        $myobject->delivery_date = $request->delivery_date;
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
        
        // --- Automated Notifications using robust phone matching ---
        $p1 = $request->sender_phone;
        $p2 = $request->receiver_phone;
        
        $recipients = User::query()
            ->where(function($q) use ($p1, $p2) {
                if ($p1 && strlen($p1) >= 10) $q->where('phone', 'like', '%' . substr($p1, -10));
                if ($p2 && strlen($p2) >= 10) $q->orWhere('phone', 'like', '%' . substr($p2, -10));
            })
            ->get();

        foreach ($recipients as $u) {
            Notification::create([
                'user_id' => $u->id,
                'courier_id' => $myobject->id,
                'type' => 'system',
                'title' => 'New Shipment Booked',
                'message' => "A new shipment #{$myobject->tracking_number} has been booked from {$myobject->from_city} to {$myobject->to_city} for you.",
                'sent_by_type' => 'admin',
                'sent_by_id' => $request->session()->get('admin_id'),
            ]);
        }

        return redirect()->route('admin.add_new_courier')->with('success', 'Courier added successfully!');
    }

    public function delete_courier($id){
        if (session('admin_is_demo')) {
            return redirect()->back()->with('error', 'Shipment deletion restricted in Sandbox Mode.');
        }
        Courier::find($id)->delete();
        return redirect()->back();
    }

    public function update_courier($id){
        $ship = Courier::find($id);
        $agents = Agent::where('is_active', 1)->get();
        return view('admin.update_courier', compact('ship', 'agents'));
    }

    public function execute_update_courier(Request $request, $id){
        if (session('admin_is_demo')) {
            return redirect()->back()->with('error', 'Shipment update restricted in Sandbox Mode.');
        }
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'delivery_date' => 'required|date', // Allowing past dates on edit for already existing records if needed, but usually it should be valid date
            'delivery_time' => 'required',
            'sender_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'sender_phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+]+$/'],
            'sender_address' => 'required|string|max:500',
            'receiver_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'receiver_phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+]+$/'],
            'receiver_address' => 'required|string|max:500',
            'from_city' => 'required|string',
            'to_city' => 'required|string',
            'parcel_type' => 'required|string',
            'weight' => 'required|numeric|min:0.1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string',
        ], [
            'sender_name.regex' => 'Sender name must contain only letters and spaces.',
            'receiver_name.regex' => 'Receiver name must contain only letters and spaces.',
            'sender_phone.regex' => 'Sender phone must only contain digits and +.',
            'receiver_phone.regex' => 'Receiver phone must only contain digits and +.',
        ]);

        $myobject = Courier::find($id);
        $oldStatus = $myobject->status;
        $myobject->agent_id = $request->agent_id;
        $myobject->delivery_date = $request->delivery_date;
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

        // --- Automated Notifications for Status Change using robust phone matching ---
        if ($oldStatus !== $myobject->status) {
            $formattedStatus = str_replace('_', ' ', ucwords($myobject->status));
            $p1 = $myobject->sender_phone;
            $p2 = $myobject->receiver_phone;

            $recipients = User::query()
                ->where(function($q) use ($p1, $p2) {
                    if ($p1 && strlen($p1) >= 10) $q->where('phone', 'like', '%' . substr($p1, -10));
                    if ($p2 && strlen($p2) >= 10) $q->orWhere('phone', 'like', '%' . substr($p2, -10));
                })
                ->get();

            foreach ($recipients as $u) {
                Notification::create([
                    'user_id' => $u->id,
                    'courier_id' => $myobject->id,
                    'type' => 'system',
                    'title' => 'Shipment Status Updated',
                    'message' => "Your shipment #{$myobject->tracking_number} status has been updated to: {$formattedStatus}.",
                    'sent_by_type' => 'admin',
                    'sent_by_id' => $request->session()->get('admin_id'),
                ]);
            }
        }

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
        if (session('admin_is_demo')) {
            return redirect()->back()->with('error', 'Personnel enlistment restricted in Sandbox Mode.');
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => 'required|email|unique:agents,email',
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+]+$/'],
            'username' => 'required|unique:agents,username',
            'password' => 'required|min:6',
            'branch_name' => 'required|string',
            'city' => 'required|string',
            'from_city' => 'required|string',
            'to_city' => 'required|string',
            'address' => 'required|string|max:500',
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.regex' => 'Agent name must only contain letters and spaces (e.g., Alan Walker).',
            'phone.regex' => 'Phone number must only contain digits and +.',
            'image.image' => 'The profile picture must be an image file.',
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
        if (session('admin_is_demo')) {
            $agents = collect();
            return view('admin.show_agent', compact('agents'));
        }
        $agents = Agent::all();
        return view('admin.show_agent', compact('agents'));
    }

    public function delete_agent($id){
        if (session('admin_is_demo')) {
            return redirect()->back()->with('error', 'Personnel decommission restricted in Sandbox Mode.');
        }
        Agent::find($id)->delete();
        return redirect()->back()->with('success', 'Agent deleted successfully');
    }

    public function update_agent($id){
        $agent = Agent::find($id);
        $branches = Branch::where('is_active', 1)->get();
        return view('admin.update_agent', compact('agent', 'branches'));
    }

    public function execute_update_agent(Request $request, $id){
        if (session('admin_is_demo')) {
            return redirect()->back()->with('error', 'Personnel dossier update restricted in Sandbox Mode.');
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => 'required|email|unique:agents,email,'.$id,
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+]+$/'],
            'username' => 'required|unique:agents,username,'.$id,
            'password' => 'nullable|min:6',
            'branch_name' => 'required|string',
            'city' => 'required|string',
            'from_city' => 'required|string',
            'to_city' => 'required|string',
            'address' => 'required|string|max:500',
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.regex' => 'Agent name must only contain letters and spaces.',
            'phone.regex' => 'Phone number must only contain digits and +.',
            'image.image' => 'The profile picture must be an image file.',
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
