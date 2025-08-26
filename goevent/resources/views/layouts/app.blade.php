<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Minha App')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
</head>

<body>
    
    <header>
        <div class="container nav">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="logo-header">
            <nav>
                <a href="{{ route('events') }}">Eventos</a>
                <a href="{{ route('profile') }}">Meu Perfil</a>
            </nav>
        </div>
    </header>
    
    <div id="confirmModal" class="modal">
        <div class="modal-card">
            <h3 id="confirmMessage">Tem certeza?</h3>
            <div class="row">
            <button id="confirmYes" class="btn primary">Sim</button>
            <button id="confirmNo" class="btn ghost">Cancelar</button>
            </div>
        </div>
    </div>
    
    @yield('content')

    @yield('scripts')

    <div id="toast-container" class="toast-container"></div>
</body>
</html>
