<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <title>Login / Registro</title>
</head>
<body>
<div class="login">
    <div class="login__content">
        <div class="login__img">
            <img src="{{ asset('assets/img/img-login.svg') }}" alt="">
        </div>

        <div class="login__forms">

            <form method="POST" action="{{ route('login.store') }}" class="login__registre forgot-password" id="login-in">
                @csrf
                <h1 class="login__title">Alterar Senha</h1>

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

                <button type="submit" class="login__button">Confirmar</button>

                <div>
                    <span class="login__account">Já possui uma Conta ?</span>
                    <a href="{{ route('login') }}" class="login__signup">Entrar</a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
const signUp = document.getElementById('sign-up'),
      signIn = document.getElementById('sign-in'),
      loginIn = document.getElementById('login-in'),
      loginUp = document.getElementById('login-up');

signUp.addEventListener('click', ()=>{
    loginIn.classList.remove('block');
    loginUp.classList.remove('none');
    loginIn.classList.toggle('none');
    loginUp.classList.toggle('block');
});

signIn.addEventListener('click', ()=>{
    loginIn.classList.remove('none');
    loginUp.classList.remove('block');
    loginIn.classList.toggle('block');
    loginUp.classList.toggle('none');
});
</script>
</body>
</html>
