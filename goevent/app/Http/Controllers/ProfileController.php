<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'new_password' => [
                'nullable',
                'string',
                'min:6',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
            ],
        ], [
            'new_password.min'   => 'A senha deve ter pelo menos 6 caracteres.',
            'new_password.regex' => 'A senha deve conter pelo menos uma letra maiúscula e uma minúscula.',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Perfil atualizado com sucesso!',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]);
        }

        return redirect()
            ->route('profile')
            ->with('success', 'Perfil atualizado com sucesso!');
    }


    public function updatePassword(Request $request)
    {
        $rules = [
            'current_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:6',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'confirmed'
            ],
        ];

        $messages = [
            'new_password.min'       => 'A nova senha deve ter no mínimo 6 caracteres.',
            'new_password.regex'     => 'A senha deve conter pelo menos uma letra maiúscula e uma minúscula.',
            'new_password.confirmed' => 'A confirmação da senha não confere.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'errors' => ['current_password' => ['A senha atual está incorreta.']]
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => 'Senha atualizada com sucesso!']);
    }
}
