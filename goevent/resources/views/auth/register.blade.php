@extends('layouts.auth')

@section('title', 'Registro')

@section('content')

<form method="POST" action="{{ route('register.store') }}" class="login__create" id="login-up">
    @csrf
    <h1 class="login__title">Criar Conta</h1>

    <div class="login__box">
        <i class='bx bx-user login__icon'></i>
        <input type="text" name="name" placeholder="Username" class="login__input" value="{{ old('name') }}">
    </div>

    <div class="login__box">
        <i class='bx bx-at login__icon'></i>
        <input type="email" name="email" placeholder="Email" class="login__input" value="{{ old('email') }}">
    </div>

    <div class="login__box">
        <i class='bx bx-lock-alt login__icon'></i>
        <input type="password" name="password" placeholder="Password" class="login__input">
    </div>

    <div class="login__box">
        <i class='bx bx-lock-alt login__icon'></i>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" class="login__input">
    </div>

    <button type="submit" class="login__button">Cadastrar</button>

    <div>
        <span class="login__account">Já possui uma Conta ?</span>
        <a href="{{ route('login') }}" class="login__signup">Entrar</a>
    </div>
</form>

@endsection
