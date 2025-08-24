// public/assets/js/event.js
export function initEventsPage() {
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    // ===== Utilitários de DOM =====
    const $  = (s, r=document) => r.querySelector(s);
    const $$ = (s, r=document) => Array.from(r.querySelectorAll(s));

    // ===== Elementos principais =====
    const search       = $('#search');
    const grid         = $('#grid');
    const noEvents     = $('#no-events');

    const sortRelevant = $('#sortRelevant');
    const sortRecent   = $('#sortRecent');

    const openCreate   = $('#openCreate');
    const closeCreate  = $('#closeCreate');
    const cancelCreate = $('#cancelCreate');
    const saveCreate   = $('#saveCreate');
    const modal        = $('#modalCreate');

    const inputTitle   = $('#title');
    const inputDesc    = $('#desc');
    const inputImage   = $('#image');
    const preview      = $('#preview');

    if (!grid || !noEvents) return; // se não for a página de eventos, sai

    // ===== Atualizar "sem eventos" =====
    function updateNoEvents() {
        const cards = grid.querySelectorAll('.card');
        if(cards.length === 0) {
            noEvents.style.display = 'flex';
            grid.classList.add('no-cards');
        } else {
            noEvents.style.display = 'none';
            grid.classList.remove('no-cards');
        }
    }

    // ===== Busca =====
    search?.addEventListener('input', () => {
        const term = search.value.trim().toLowerCase();
        $$('.card', grid).forEach(card => {
            const txt = card.textContent.toLowerCase();
            card.style.display = txt.includes(term) ? '' : 'none';
        });
    });

    // ===== Ordenação =====
    function sortCards(by) {
        const cards = $$('.card', grid);
        cards.sort((a,b) => {
            if(by==='relevant') {
                return (+b.dataset.interested) - (+a.dataset.interested);
            } else {
                return new Date(b.dataset.created) - new Date(a.dataset.created);
            }
        }).forEach(c => grid.appendChild(c));
    }

    sortRelevant?.addEventListener('click', () => sortCards('relevant'));
    sortRecent?.addEventListener('click', () => sortCards('recent'));

    // ===== Carregar eventos do backend =====
    async function loadEvents() {
        grid.innerHTML = '';
        try {
            const res = await fetch('/events-data', { credentials: 'same-origin' });
            const events = await res.json();

            if (!events.length) {
                updateNoEvents();
                return;
            }

            events.forEach(event => {
                const card = document.createElement('div');
                card.classList.add('card');
                card.dataset.created = event.created_at;
                card.dataset.interested = event.interested;

                card.innerHTML = `
                    <img src="${event.image_url || '/assets/img/no-imagem.png'}" alt="${event.title}" />
                    <div class="card-body">
                        <h3 class="card-title">${event.title}</h3>
                        <p class="card-desc">${event.description}</p>
                        <div class="card-actions">
                            <button class="btn primary interest-btn" data-id="${event.id}">Estou interessado</button>
                            <div class="interest" aria-label="Interessados">
                                <svg class="heart" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 21s-7.364-4.52-9.428-8.571C.46 9.857 2.4 6 6 6c2.057 0 3.374 1.143 4 2 0 0 1.943-2 4-2 3.6 0 5.54 3.857 3.428 6.429C19.364 16.48 12 21 12 21z"/>
                                </svg>
                                <span class="count">${event.interested}</span>
                            </div>
                        </div>
                    </div>
                `;
                grid.appendChild(card);
            });

            updateNoEvents();
        } catch (err) {
            console.error('Erro ao carregar eventos:', err);
        }
    }

    // ===== Botão "Estou interessado" =====
    grid.addEventListener('click', async (e) => {
        const btn = e.target.closest('.interest-btn');
        if (!btn) return;

        const id = btn.dataset.id;
        try {
            const res = await fetch(`/events/${id}/interested`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });
            if (res.ok) {
                const data = await res.json();
                btn.closest('.card').querySelector('.count').textContent = data.interested;
            }
        } catch (err) {
            console.error('Erro ao marcar interesse:', err);
        }
    });

    // ===== Modal de criação =====
    function openModal() { modal?.classList.add('open'); }
    function closeModal(){ modal?.classList.remove('open'); }

    openCreate?.addEventListener('click', openModal);
    closeCreate?.addEventListener('click', closeModal);
    cancelCreate?.addEventListener('click', closeModal);
    modal?.addEventListener('click', (e) => { if(e.target === modal) closeModal(); });

    // ===== Preview de imagem =====
    inputImage?.addEventListener('change', (e) => {
        const file = e.target.files?.[0];
        if(!file) { 
            preview.style.display = 'none'; 
            return; 
        }
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    });

    // ===== Criar novo evento =====
    saveCreate?.addEventListener('click', async () => {
        const title = inputTitle.value.trim();
        const desc  = inputDesc.value.trim();
        const file  = inputImage.files[0];

        if(!title || !desc){
            alert('Preencha título e descrição.');
            return;
        }

        const formData = new FormData();
        formData.append('title', title);
        formData.append('description', desc);
        if (file) formData.append('image', file);

        try {
            const res = await fetch('/events', {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                credentials: 'same-origin'
            });

            if (!res.ok) {
                console.error('Erro ao salvar evento', await res.text());
                alert('Erro ao salvar evento.');
                return;
            }

            closeModal();
            inputTitle.value = '';
            inputDesc.value = '';
            inputImage.value = '';
            preview.src = '';
            preview.style.display = 'none';

            await loadEvents();
        } catch (err) {
            console.error('Erro ao salvar evento:', err);
        }
    });

    // ===== Inicialização =====
    loadEvents();
}
