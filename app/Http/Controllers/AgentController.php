<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\Courier;
use App\Models\Notification;
use App\Models\User;
use App\Support\Exports\XlsxExport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AgentController extends Controller
{
    private function agentAllowedCities(): array
    {
        $agentId = Session::get('agent_id');
        $agent = Agent::find($agentId);
        $cities = [];
        if ($agent?->from_city) $cities[] = (string) $agent->from_city;
        if ($agent?->to_city) $cities[] = (string) $agent->to_city;
        if (empty($cities) && $agent?->city) $cities[] = (string) $agent->city; // fallback
        return array_values(array_unique(array_filter($cities)));
    }

    private function branchCourierQuery()
    {
        $cities = $this->agentAllowedCities();
        return Courier::query()->when(!empty($cities), function ($q) use ($cities) {
            $q->where(function ($qq) use ($cities) {
                foreach ($cities as $city) {
                    $qq->orWhere('from_city', $city)->orWhere('to_city', $city);
                }
            });
        });
    }

    public function login()
    {
        return view('agent.login');
    }

    public function login_submit(Request $request)
    {
        // Demo Login Check
        if ($request->username === 'agent_demo' && $request->password === 'password123') {
            $agent = Agent::first(); // Use first available agent for demo
        } else {
            $agent = Agent::where('username', $request->username)->first();
        }
        
        $isValid = false;
        if ($agent) {
            // Handle Demo Bypass
            if ($request->username === 'agent_demo' && $request->password === 'password123') {
                $isValid = true;
            } 
            // Support both hashed and plain (for legacy/demo)
            elseif (preg_match('/^\$2[ayb]\$.{56}$/', $agent->password)) {
                $isValid = Hash::check($request->password, $agent->password);
            } else {
                $isValid = ($agent->password === $request->password);
            }
        }

        if ($agent && $isValid && $agent->is_active) {
            Session::put('agent_logged_in', true);
            Session::put('agent_id', $agent->id);
            Session::put('agent_name', $agent->name);
            Session::put('agent_branch', $agent->branch_name);

            // Set Demo Mode Flag
            if ($request->username === 'agent_demo') {
                Session::put('agent_is_demo', true);
                Session::put('agent_name', 'Demo Agent');
                Session::put('agent_branch', 'Demo Branch (Sandbox)');
            } else {
                Session::put('agent_is_demo', false);
            }
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Branch Access Granted.',
                    'redirect' => route('agent.dashboard')
                ]);
            }
            return redirect()->route('agent.dashboard');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Branch Credentials or Inactive Account.'
            ], 401);
        }

        return redirect()->back()->with('error', 'Invalid Credentials.');
    }

    public function logout()
    {
        Session::forget(['agent_logged_in', 'agent_id', 'agent_name', 'agent_branch']);
        return redirect()->route('agent.login');
    }

    public function dashboard()
    {
        if (Session::get('agent_is_demo')) {
            return view('agent.dashboard', [
                'total_shipments' => 0, 'in_progress' => 0, 'delivered' => 0, 'pending' => 0,
                'active_deployments' => collect(), 'recent_logs' => ['Sandbox session active', 'Local data only']
            ]);
        }

        $total_shipments = $this->branchCourierQuery()->count();
        $in_progress = $this->branchCourierQuery()->where('status', 'in_transit')->count();
        $delivered = $this->branchCourierQuery()->where('status', 'delivered')->count();
        $pending = $this->branchCourierQuery()->where('status', 'pending')->count();

        $active_deployments = $this->branchCourierQuery()
            ->orderBy('created_at', 'desc')->take(5)->get();

        return view('agent.dashboard', compact('total_shipments', 'in_progress', 'delivered', 'pending', 'active_deployments'));
    }

    public function new_courier()
    {
        return view('agent.new_courier');
    }

    public function store_courier(Request $request)
    {
        if (Session::get('agent_is_demo')) {
            return redirect()->back()->with('error', 'Shipment registration restricted in Sandbox Mode.');
        }
        $request->validate([
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
            'sender_name.regex' => 'Sender name must contain only letters and spaces.',
            'receiver_name.regex' => 'Receiver name must contain only letters and spaces.',
            'delivery_date.after_or_equal' => 'The delivery date cannot be in the past.',
            'sender_phone.regex' => 'Sender phone must only contain digits and +.',
            'receiver_phone.regex' => 'Receiver phone must only contain digits and +.',
        ]);

        $myobject = new Courier();
        $myobject->tracking_number = 'CP-AGT-'.rand(10000, 99999);
        $myobject->agent_id = Session::get('agent_id');
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
        $myobject->status = 'pending';
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
                'sent_by_type' => 'agent',
                'sent_by_id' => Session::get('agent_id'),
            ]);
        }

        return redirect()->back()->with('success', 'Shipment Registered Successfully!');
    }

    public function view_couriers()
    {
        if (Session::get('agent_is_demo')) {
            $couriers = collect();
            return view('agent.view_couriers', compact('couriers'));
        }
        $couriers = $this->branchCourierQuery()->orderBy('created_at', 'desc')->get();
        return view('agent.view_couriers', compact('couriers'));
    }

    public function sms()
    {
        if (Session::get('agent_is_demo')) {
            $couriers = collect();
            return view('agent.sms', compact('couriers'));
        }
        $couriers = $this->branchCourierQuery()->orderBy('created_at', 'desc')->get();
        return view('agent.sms', compact('couriers'));
    }

    public function send_sms(Request $request)
    {
        if (Session::get('agent_is_demo')) {
            return back()->with('error', 'SMS transmission restricted in Sandbox Mode.');
        }
        $request->validate([
            'courier_id' => 'required|exists:courier,id',
            'sms_type' => 'required|in:dispatch,delivery',
        ]);

        $courier = Courier::find($request->courier_id);

        // Restrict agent to configured lanes (from_city/to_city)
        $cities = $this->agentAllowedCities();
        if (!empty($cities) && !in_array($courier->from_city, $cities, true) && !in_array($courier->to_city, $cities, true)) {
            return back()->with('error', 'Unauthorized: shipment is outside your assigned route.');
        }

        $message = $request->sms_type === 'dispatch'
            ? "Your package {$courier->tracking_number} has been dispatched from {$courier->from_city} to {$courier->to_city}."
            : "Your package {$courier->tracking_number} has been successfully delivered! Thank you for using our service.";

        Log::info("[SMS SIMULATION][AGENT] Sent to {$courier->receiver_phone}: {$message}");

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
                'sent_by_type' => 'agent',
                'sent_by_id' => Session::get('agent_id'),
            ]);
        }

        return back()->with('success', "Simulated SMS sent successfully!");
    }

    public function reports()
    {
        $current_agent = Agent::find(Session::get('agent_id'));
        return view('agent.reports', compact('current_agent'));
    }

    public function download_report(Request $request)
    {
        if (Session::get('agent_is_demo')) {
            return back()->with('error', 'Report generation restricted in Sandbox Mode.');
        }
        $query = $this->branchCourierQuery();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
        }

        if ($request->filled('city')) {
            $query->where(function ($q) use ($request) {
                $q->where('from_city', 'like', "%{$request->city}%")
                  ->orWhere('to_city', 'like', "%{$request->city}%");
            });
        }

        $shipments = $query->orderBy('created_at', 'desc')->get();

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

        $filename = "branch_report_" . date('Y-m-d_H-i') . ".xlsx";
        return XlsxExport::download($filename, $columns, $rows);
    }

    public function profile()
    {
        if (Session::get('agent_is_demo')) {
            $agent = new Agent([
                'name' => 'Demo Agent',
                'email' => 'agent@demo.com',
                'username' => 'agent_demo',
                'branch_name' => 'Demo Branch',
                'id' => 999
            ]);
            return view('agent.profile', compact('agent'));
        }
        $agent_id = Session::get('agent_id');
        $agent = Agent::find($agent_id);
        return view('agent.profile', compact('agent'));
    }

    public function update_profile(Request $request)
    {
        if (Session::get('agent_is_demo')) {
            return back()->with('error', 'Profile modification restricted in Sandbox Mode.');
        }
        $agent_id = Session::get('agent_id');
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => 'required|email|unique:agents,email,'.$agent_id,
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+]+$/'],
            'username' => 'required|unique:agents,username,'.$agent_id,
            'address' => 'required|string|max:500',
            'password' => 'nullable|min:6',
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.regex' => 'Name must only contain letters and spaces.',
            'phone.regex' => 'Phone must only contain digits and +.',
            'image.image' => 'The file must be an image.',
        ]);

        $agent = Agent::find($agent_id);
        $agent->name = $request->name;
        $agent->email = $request->email;
        $agent->phone = $request->phone;
        $agent->username = $request->username;
        $agent->address = $request->address;

        if ($request->filled('password')) {
            $agent->password = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $agent->image = $filename;
        }

        $agent->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
