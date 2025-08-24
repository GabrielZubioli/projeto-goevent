<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
public function showLoginForm() {
    return view('auth.login');
}

public function store(Request $request)
{
    // Validação e tentativa de login
    $credentials = $request->only('email', 'password');

    if (auth()->attempt($credentials)) {
        return redirect()->route('home');
    }

    return back()->withErrors(['email' => 'Credenciais inválidas']);
}

}
