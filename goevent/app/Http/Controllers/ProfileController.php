<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
public function showContent()
{
    return view('home.profile', ['user' => auth()->user()]);
}

public function update(Request $request)
{
    $user = auth()->user();
    $user->update($request->only(['name', 'email']));

    // retorna só o conteúdo (sem layout)
    return view('layouts.home', ['user' => $user]);
}


}
