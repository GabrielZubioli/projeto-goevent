<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    <!-- ===== BOX ICONS ===== -->
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

            <!-- REGISTER FORM -->
            <form method="POST" action="{{ route('register.store') }}" class="login__create {{ session('show_register')}}" id="login-up">
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
