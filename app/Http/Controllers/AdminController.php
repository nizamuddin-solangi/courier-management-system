<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Courier;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function customers(){
        return view('admin.customers');
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

    public function login(){
        return view('admin.login');
    }

    public function sms(){
        return view('admin.sms');
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
        return view('admin.add_new_courier');
    }

    public function store_courier(Request $request){
        $myobject = new Courier();
        
        $myobject->tracking_number = $request->tracking_number;
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
        return redirect()->route('admin.add_new_courier')->with('success', 'Courier added successfully!');
    }
}
