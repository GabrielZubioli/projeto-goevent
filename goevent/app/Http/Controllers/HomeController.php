<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('layouts.home');
    }

    public function events()
    {
        return view('home.events');
    }

    public function profile()
    {
        return view('home.profile');
    }
}
