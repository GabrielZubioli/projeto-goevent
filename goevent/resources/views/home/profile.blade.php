<h1 class="page-title">Meu Perfil</h1>

<section class="profile-card">
    <img src="{{ asset('assets/img/avatar.jpg') }}" alt="Avatar" class="avatar">
    <div class="profile-info">
        <h2>{{ Auth::user()->name }}</h2>
        <p>Email: {{ Auth::user()->email }}</p>
        <button class="btn ghost editProfile" id="openEdit">Editar Perfil</button>
    </div>
</section>

<div class="modal" id="modalEdit" role="dialog" aria-modal="true" aria-labelledby="modalEditTitle">
    <div class="modal-card">
        <div class="modal-header">
            <h3 id="modalEditTitle">Editar Informações</h3>
            <button class="btn" id="closeEdit" aria-label="Fechar">Fechar</button>
        </div>
        <form method="POST" action="{{ route('profile.update') }}">
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
                <div class="row">
                    <button type="button" class="btn ghost" id="cancelEdit">Cancelar</button>
                    <button type="submit" class="btn primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>