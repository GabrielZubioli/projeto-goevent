<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
public function showLoginForm() {
    return view('auth.login'); // login.blade.php
}

public function store(Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        return redirect()->intended('/home');
    }

    return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput();
}

}
