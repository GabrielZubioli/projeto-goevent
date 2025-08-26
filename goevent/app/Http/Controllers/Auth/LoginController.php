<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // 🔹 Valida os dados antes de tentar login
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        // 🔹 Tentativa de login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenera a sessão para evitar fixation attacks
            $request->session()->regenerate();

            return redirect()->route('events')
                ->with('success', 'Login realizado com sucesso!');
        }

        // 🔹 Se falhar
        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Você saiu da sua conta.');
    }
}
