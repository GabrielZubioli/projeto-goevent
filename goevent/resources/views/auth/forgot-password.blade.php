@extends('layouts.auth')

@section('title', 'Alterar Senha')

@section('content')
<form method="POST" action="{{ route('password.update') }}" class="login__registre forgot-password" id="login-in">
    @csrf
    <h1 class="login__title">Alterar Senha</h1>

    <div class="login__box">
        <i class='bx bx-at login__icon'></i>
        <input type="email" name="email" placeholder="Email" class="login__input" value="{{ old('email') }}">
    </div>

    <div class="login__box">
        <i class='bx bx-lock-alt login__icon'></i>
        <input type="password" name="password" placeholder="Nova Senha" class="login__input">
    </div>

    <div class="login__box">
        <i class='bx bx-lock-alt login__icon'></i>
        <input type="password" name="password_confirmation" placeholder="Confirmar Nova Senha" class="login__input">
    </div>

    <button type="submit" class="login__button">Confirmar</button>

    <div>
        <span class="login__account">Já possui uma Conta?</span>
        <a href="{{ route('login') }}" class="login__signup">Entrar</a>
    </div>
</form>
@endsection
