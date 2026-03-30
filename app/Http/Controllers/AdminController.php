<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('admin.profile');
    }
}
