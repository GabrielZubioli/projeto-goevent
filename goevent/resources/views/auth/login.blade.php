@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<form method="POST" action="{{ route('login.store') }}" class="login__registre" id="login-in">
    @csrf
    <h1 class="login__title">Login</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="login__box">
        <i class='bx bx-user login__icon'></i>
        <input type="email" name="email" placeholder="Email" class="login__input" value="{{ old('email') }}">
    </div>

    <div class="login__box">
        <i class='bx bx-lock-alt login__icon'></i>
        <input type="password" name="password" placeholder="Password" class="login__input">
    </div>

    <a href="{{ route('password.request') }}" class="login__forgot">Esqueceu a senha?</a>

    <button type="submit" class="login__button">Entrar</button>

    <div>
        <span class="login__account">Não tem uma Conta ?</span>
        <a href="{{ route('register') }}" class="login__signin">Criar Conta</a>
    </div>
</form>
@endsection
