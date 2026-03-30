<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return view('admin.couriers');
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
        $result = Courier::first() ?? new Courier(['name' => 'System Admin', 'email' => 'admin@courierpro.com', 'id' => 1]);
        return view('admin.profile', compact('result'));
    }

    public function edit_admin($id){
        $result = Courier::find($id);
        return view('admin.profile', compact('result'));
    }

    public function update_admin(Request $request,$id){
        $myobject = Courier::find($id);
        
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
}
