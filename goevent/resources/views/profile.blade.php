@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
    <main class="container content" id="main-content">
        <h1 class="page-title">Meu Perfil</h1>

        <section class="profile-card">
            <img src="{{ asset('assets/img/avatar.jpg') }}" alt="Avatar" class="avatar">

            <div class="profile-info">
                <h2 id="profileName">{{ auth()->user()->name }}</h2>
                <p id="profileEmail">{{ auth()->user()->email }}</p>
                <button class="btn ghost editProfile" id="openEdit">Editar Perfil</button>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="submit-btn">
                @csrf
                <button type="submit" class="btn danger logout-btn">Sair</button>
            </form>
        </section>

        <div class="modal" id="modalEdit" role="dialog" aria-modal="true" aria-labelledby="modalEditTitle">
            <div class="modal-card">
                <div class="modal-header">
                    <h3 id="modalEditTitle">Editar Informações</h3>
                    <button class="btn" id="closeEdit" aria-label="Fechar">Fechar</button>
                </div>

                <div id="profileError" class="alert danger" style="display:none;"></div>

                <form id="formProfile" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="field">
                            <label for="name">Nome</label>
                            <input id="name" name="name" type="text" value="{{ Auth::user()->name }}" required />
                        </div>
                        <div class="field">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" value="{{ Auth::user()->email }}" required />
                        </div>
                        <div class="field">
                            <label for="new_password">Nova senha</label>
                            <input type="password" name="new_password">
                        </div>
                        <div class="field">
                            <label for="new_password_confirmation">Confirmar nova senha</label>
                            <input type="password" name="new_password_confirmation">
                        </div>
                        <div class="row">
                            <button type="button" class="btn ghost" id="cancelEdit">Cancelar</button>
                            <button type="submit" class="btn primary">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script type="module" src="{{ asset('assets/js/profile.js') }}"></script>
    <script>window.currentUserId = {{ auth()->id() ?? 'null' }};</script>
@endsection
