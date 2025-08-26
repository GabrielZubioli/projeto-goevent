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

    
    <div id="toast-container" class="toast-container"></div>


    @stack('scripts')

    <script type="module">
        import { showToast, showConfirm } from "{{ asset('assets/js/toast.js') }}";
        window.showToast = showToast;
        window.showConfirm = showConfirm;
    </script>

    <script type="module">
    import { showToast } from "{{ asset('assets/js/toast.js') }}";

    @if(session('success'))
        showToast("{{ session('success') }}", "success");
    @endif

    @if(session('error'))
        showToast("{{ session('error') }}", "error");
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            showToast("{{ $error }}", "error");
        @endforeach
    @endif
</script>
</body>
</html>
