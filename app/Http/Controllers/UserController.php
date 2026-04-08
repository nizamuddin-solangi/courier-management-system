<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view("user.index");
    }

    public function track(){
        return view('user.track');
    }

    public function login(){
        return view('user.login');
    }

    public function register(){
        return view('user.register');
    }
}

