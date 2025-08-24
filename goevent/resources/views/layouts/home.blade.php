<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <title>@yield('title', 'Home')</title>
  </head>
  <body class="login-body">
    <div class="wrapper">
    
      <header>
        <div class="container nav">
          <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="logo-header">
          <nav>
                <a href="#" data-nav="events">Eventos</a>
                <a href="#" data-nav="profile">Meu Perfil</a>
          </nav>
        </div>
      </header>
        
      <main class="container content" id="main-content">
      </main>
        
      <footer class="container">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
          <small>© 2025 GoEvent — Todos os direitos reservados</small>
          <div class="footer-links">
            <a href="#" style="color:var(--muted); text-decoration:none">Sobre</a>
            <a href="#" style="color:var(--muted); text-decoration:none">Contato</a>
          </div>
        </div>
      </footer>

    </div>

    <script type="module" src="{{ asset('assets/js/home.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/profile.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/event.js') }}"></script>
  </body>
</html>
