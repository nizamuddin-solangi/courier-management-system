<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\Courier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AgentController extends Controller
{
    public function login()
    {
        return view('agent.login');
    }

    public function login_submit(Request $request)
    {
        $agent = Agent::where('username', $request->username)->first();
        
        $isValid = false;
        if ($agent) {
            // Support both hashed and plain (for legacy/demo)
            if (preg_match('/^\$2[ayb]\$.{56}$/', $agent->password)) {
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
        $agent_id = Session::get('agent_id');
        $total_shipments = Courier::where('agent_id', $agent_id)->count();
        $in_progress = Courier::where('agent_id', $agent_id)->where('status', 'in_transit')->count();
        $delivered = Courier::where('agent_id', $agent_id)->where('status', 'delivered')->count();
        $pending = Courier::where('agent_id', $agent_id)->where('status', 'pending')->count();
        
        $active_deployments = Courier::where('agent_id', $agent_id)
            ->orderBy('created_at', 'desc')->take(5)->get();

        return view('agent.dashboard', compact('total_shipments', 'in_progress', 'delivered', 'pending', 'active_deployments'));
    }

    public function new_courier()
    {
        return view('agent.new_courier');
    }

    public function store_courier(Request $request)
    {
        $myobject = new Courier();
        $myobject->tracking_number = 'CP-AGT-'.rand(10000, 99999);
        $myobject->agent_id = Session::get('agent_id');
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

        return redirect()->back()->with('success', 'Shipment Registered Successfully!');
    }

    public function view_couriers()
    {
        $agent_id = Session::get('agent_id');
        $couriers = Courier::where('agent_id', $agent_id)->get();
        return view('agent.view_couriers', compact('couriers'));
    }

    public function sms()
    {
        $agent_id = Session::get('agent_id');
        $couriers = Courier::where('agent_id', $agent_id)->orderBy('created_at', 'desc')->get();
        return view('agent.sms', compact('couriers'));
    }

    public function reports()
    {
        return view('agent.reports');
    }

    public function profile()
    {
        $agent_id = Session::get('agent_id');
        $agent = Agent::find($agent_id);
        return view('agent.profile', compact('agent'));
    }

    public function update_profile(Request $request)
    {
        $agent_id = Session::get('agent_id');
        $request->validate([
            'email' => 'required|email|unique:agents,email,'.$agent_id,
            'username' => 'required|unique:agents,username,'.$agent_id,
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
