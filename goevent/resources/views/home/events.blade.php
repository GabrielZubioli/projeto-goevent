
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

<section id="grid" class="grid">
    <div id="no-events">
        <img src="{{ asset('assets/img/no-events.png') }}" alt="Sem eventos">
        <p>Não há eventos disponíveis</p>
    </div>
</section>
    
<div class="modal" id="modalCreate" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-card">
        <div class="modal-header">
            <h3 id="modalTitle">Criar Evento</h3>
            <button class="btn" id="closeCreate" aria-label="Fechar">Fechar</button>
        </div>
        <div class="form-grid">
            <div class="field">
                <label for="title">Título</label>
                <input id="title" type="text" placeholder="Dê um título ao evento" />
            </div>
            <div class="field">
                <label for="desc">Descrição</label>
                <textarea id="desc" placeholder="Conte um pouco sobre o evento"></textarea>
            </div>
            <div class="field">
                <label for="image">Imagem (upload)</label>
                <div class="upload">
                    <input id="image" type="file" accept="image/*" />
                </div>
                <img id="preview" class="preview" alt="Pré-visualização" />
            </div>
            <div class="row">
                <button class="btn ghost" id="cancelCreate">Cancelar</button>
                <button class="btn primary" id="saveCreate">Publicar</button>
            </div>
        </div>
    </div>
</div>
