<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    public function menu() {
        return view('menu');
    }

    public function login() {
        return view('login');
    }

    public function notloggedin() {
        return view('notloggedin');
    }
};
