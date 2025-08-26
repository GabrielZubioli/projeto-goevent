@extends('layouts.app')

@section('title', 'Eventos')

@section('content')

    <main class="container content" id="main-content">
        <h1 class="page-title">Eventos</h1>

        <section class="controls">
            <div class="input" style="flex:1">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M10 2a8 8 0 105.293 14.293l4.207 4.207 1.414-1.414-4.207-4.207A8 8 0 0010 2zm0 2a6 6 0 110 12A6 6 0 0110 4z"/>
                </svg>
                <input id="search" type="text" placeholder="Buscar" />
            </div>
            <button class="btn ghost" id="sortRelevant">Mais Relevantes</button>
            <button class="btn ghost" id="sortRecent">Mais Recentes</button>
            <button class="btn ghost create" id="openCreate">Criar Evento</button>
        </section>

        <section id="grid" class="grid"></section>

        <div id="no-events" style="display:none">
            <img src="{{ asset('assets/img/no-events.png') }}" alt="Sem eventos">
            <p>Não há eventos disponíveis</p>
        </div>

        <div class="modal" id="modalCreate" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <div class="modal-card">
                <div class="modal-header">
                    <h3 id="modalTitle">Criar Evento</h3>
                    <button class="btn" id="closeCreate" aria-label="Fechar">Fechar</button>
                </div>

                <div id="eventErrorCreate" class="error-box" style="display:none;"></div>

                <form id="formCreate" method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-grid">
                        <div class="field">
                            <label for="title">Título</label>
                            <input id="title" name="title" type="text" placeholder="Dê um título ao evento" required />
                        </div>
                        <div class="field">
                            <label for="desc">Descrição</label>
                            <textarea id="desc" name="description" placeholder="Conte um pouco sobre o evento" required></textarea>
                        </div>
                        <div class="field">
                            <label for="image">Imagem (upload)</label>
                            <div class="upload">
                                <input id="image" name="image" type="file" accept="image/*" />
                            </div>
                            <img id="preview" class="preview" alt="Pré-visualização" style="display:none;" />
                        </div>
                        <div class="row">
                            <button type="button" class="btn ghost" id="cancelCreate">Cancelar</button>
                            <button type="submit" class="btn primary">Publicar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal" id="modalEdit">
            <div class="modal-card">
                <div class="modal-header">
                    <h3>Editar Evento</h3>
                    <button class="btn" id="closeEdit">Fechar</button>
                </div>

                <div id="eventErrorEdit" class="error-box" style="display:none;"></div>

                <form id="formEdit" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-grid">
                        <div class="field">
                            <label for="editTitle">Título</label>
                            <input id="editTitle" name="title" type="text" required />
                        </div>
                        <div class="field">
                            <label for="editDesc">Descrição</label>
                            <textarea id="editDesc" name="description" required></textarea>
                        </div>
                        <div class="field upload">
                            <label for="editImage">Imagem</label>
                            <input id="editImage" name="image" type="file" accept="image/*" />
                        </div>
                        <img id="editPreview" class="preview" style="display:none;" />
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
    <script type="module" src="{{ asset('assets/js/event.js') }}"></script>
    <script>window.currentUserId = {{ auth()->id() ?? 'null' }};</script>
@endsection
