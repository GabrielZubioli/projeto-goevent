<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

public function store(Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => [
            'required',
            'string',
            'min:6',
            'regex:/[a-z]/',
            'regex:/[A-Z]/',
            'confirmed'
        ],
    ], [
        'password.min'   => 'A senha deve ter pelo menos 6 caracteres.',
        'password.regex' => 'A senha deve conter pelo menos uma letra maiúscula e uma minúscula.',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    return redirect()
        ->route('login')
        ->with('success', 'Conta criada com sucesso! Agora faça login.');
}

}
