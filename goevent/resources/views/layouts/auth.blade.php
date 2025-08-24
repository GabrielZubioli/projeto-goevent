<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <title>@yield('title')</title>
</head>
<body class="login-body">

    <div class="login">
        <div class="login__content">

            <div class="login__img">
                <img src="{{ asset('assets/img/logo.png') }}" alt="">
                <img src="{{ asset('assets/img/img-login.png') }}" alt="">
            </div>

            <div class="login__forms">
                @yield('content')
            </div>

        </div>
    </div>

    @stack('scripts')
</body>
</html>
