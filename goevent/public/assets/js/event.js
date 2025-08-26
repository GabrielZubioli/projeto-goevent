import { showToast } from "./toast.js";

export function initEventsPage() {
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    const $ = (s, r = document) => r.querySelector(s);
    const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));

    const search = $("#search");
    const grid = $("#grid");
    const noEvents = $("#no-events");
    const sortRelevant = $("#sortRelevant");
    const sortRecent = $("#sortRecent");

    const modalCreate = $("#modalCreate");
    const openCreate = $("#openCreate");
    const closeCreate = $("#closeCreate");
    const cancelCreate = $("#cancelCreate");
    const formCreate = $("#formCreate");
    const errorCreate = $("#eventErrorCreate");
    const inputImage = $("#image");
    const preview = $("#preview");

    const modalEdit = $("#modalEdit");
    const closeEdit = $("#closeEdit");
    const cancelEdit = $("#cancelEdit");
    const formEdit = $("#formEdit");
    const errorEdit = $("#eventErrorEdit");
    const editTitle = $("#editTitle");
    const editDesc = $("#editDesc");
    const editImage = $("#editImage");
    const editPreview = $("#editPreview");

    const confirmModal = $("#confirmModal");
    const confirmMessage = $("#confirmMessage");
    const confirmYes = $("#confirmYes");
    const confirmNo = $("#confirmNo");

    let editingId = null;
    let eventsCache = [];

    if (!grid || !noEvents) return;

    function openModal(m) {
        m.classList.add("open");
    }
    function closeModal(m) {
        m.classList.remove("open");
    }

    function showConfirm(message) {
        return new Promise((resolve) => {
            confirmMessage.textContent = message;
            confirmModal.classList.add("open");

            const cleanup = () => {
                confirmModal.classList.remove("open");
                confirmYes.removeEventListener("click", onYes);
                confirmNo.removeEventListener("click", onNo);
            };

            const onYes = () => {
                cleanup();
                resolve(true);
            };
            const onNo = () => {
                cleanup();
                resolve(false);
            };

            confirmYes.addEventListener("click", onYes);
            confirmNo.addEventListener("click", onNo);
        });
    }

    function updateNoEvents() {
        const cards = grid.querySelectorAll(".card");
        noEvents.style.display = cards.length === 0 ? "flex" : "none";
        grid.classList.toggle("no-cards", cards.length === 0);
    }

    function renderEvents(events) {
        grid.innerHTML = "";

        if (!events.length) {
            noEvents.style.display = "flex";
            grid.classList.add("no-cards");
            return;
        } else {
            noEvents.style.display = "none";
            grid.classList.remove("no-cards");
        }

        events.forEach((event) => {
            const card = document.createElement("div");
            card.classList.add("card");
            card.dataset.created = event.created_at;
            card.dataset.interested = event.interested;

            card.innerHTML = `
            <img src="${event.image_url || "/assets/img/no-imagem.png"}" alt="${
                event.title
            }" />
            <div class="card-body">
                <div class="card-header">
                    <h3 class="card-title">${event.title}</h3>
                    ${
                        event.user_id == window.currentUserId
                            ? `
                        <div class="dropdown">
                            <button class="btn ghost menu-btn">⋮</button>
                            <div class="dropdown-content">
                                <button class="dropdown-item edit-btn" 
                                    data-id="${event.id}" 
                                    data-title="${event.title}" 
                                    data-desc="${event.description}">
                                    Editar
                                </button>
                                <button class="dropdown-item delete-btn" data-id="${event.id}">Excluir</button>
                            </div>
                        </div>`
                            : ""
                    }
                </div>
                <p class="card-desc">${event.description}</p>
                <div class="card-actions">
                    <button class="btn primary interest-btn ${
                        event.is_interested ? "active" : ""
                    }" data-id="${event.id}">
                        ${
                            event.is_interested
                                ? "Remover interesse"
                                : "Estou interessado"
                        }
                    </button>
                    <div class="interest">
                        <svg class="heart" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 21s-7.364-4.52-9.428-8.571C.46 9.857 2.4 6 6 6c2.057 0 3.374 1.143 4 2 0 0 1.943-2 4-2 3.6 0 5.54 3.857 3.428 6.429C19.364 16.48 12 21 12 21z"/>
                        </svg>
                        <span class="count">${event.interested}</span>
                    </div>
                </div>
            </div>`;
            grid.appendChild(card);
        });
    }

    async function loadEvents() {
        try {
            const res = await fetch("/events-data", {
                credentials: "same-origin",
            });
            eventsCache = await res.json();
            renderEvents(eventsCache);
        } catch (err) {
            showToast("Erro ao carregar eventos", "error");
        }
    }

    search?.addEventListener("input", () => {
        const term = search.value.toLowerCase();
        const filtered = eventsCache.filter(
            (e) =>
                e.title.toLowerCase().includes(term) ||
                e.description.toLowerCase().includes(term)
        );
        renderEvents(filtered);
    });

    sortRecent?.addEventListener("click", () => {
        renderEvents(
            [...eventsCache].sort(
                (a, b) => new Date(b.created_at) - new Date(a.created_at)
            )
        );
    });
    sortRelevant?.addEventListener("click", () => {
        renderEvents(
            [...eventsCache].sort((a, b) => b.interested - a.interested)
        );
    });

    grid.addEventListener("click", async (e) => {
        const btn = e.target.closest(".interest-btn");
        if (!btn) return;

        const id = btn.dataset.id;
        try {
            const res = await fetch(`/events/${id}/interested`, {
                method: "POST",
                headers: { "X-CSRF-TOKEN": csrf, Accept: "application/json" },
                credentials: "same-origin",
            });

            if (res.ok) {
                const data = await res.json();
                btn.closest(".card").querySelector(".count").textContent =
                    data.interested;
                btn.textContent = data.is_interested
                    ? "Remover interesse"
                    : "Estou interessado";
                btn.classList.toggle("active", data.is_interested);

                const idx = eventsCache.findIndex((ev) => ev.id == id);
                if (idx !== -1) {
                    eventsCache[idx].interested = data.interested;
                    eventsCache[idx].is_interested = data.is_interested;
                }

                showToast("Interesse atualizado!", "success");
            }
        } catch (err) {
            showToast("Erro ao marcar interesse", "error");
        }
    });

    grid.addEventListener("click", async (e) => {
        const btn = e.target.closest(".delete-btn");
        if (!btn) return;

        const confirmed = await showConfirm(
            "Tem certeza que deseja excluir este evento?"
        );
        if (!confirmed) return;
        const id = btn.dataset.id;

        try {
            const res = await fetch(`/events/${id}`, {
                method: "DELETE",
                headers: { "X-CSRF-TOKEN": csrf, Accept: "application/json" },
                credentials: "same-origin",
            });

            if (!res.ok) throw new Error(await res.text());

            showToast("Evento excluído com sucesso!", "success");
            await loadEvents();
        } catch (err) {
            console.error("Erro ao excluir:", err);
            showToast("Erro ao excluir evento", "error");
        }
    });

    openCreate?.addEventListener("click", () => openModal(modalCreate));
    closeCreate?.addEventListener("click", () => closeModal(modalCreate));
    cancelCreate?.addEventListener("click", () => closeModal(modalCreate));

    inputImage?.addEventListener("change", (e) => {
        const file = e.target.files?.[0];
        if (!file) {
            preview.style.display = "none";
            return;
        }
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
    });

    formCreate?.addEventListener("submit", async (e) => {
        e.preventDefault();
        errorCreate.style.display = "none";
        errorCreate.textContent = "";

        const formData = new FormData(formCreate);
        try {
            const res = await fetch(formCreate.action, {
                method: "POST",
                headers: { "X-CSRF-TOKEN": csrf, Accept: "application/json" },
                body: formData,
                credentials: "same-origin",
            });
            const data = await res.json();
            if (!res.ok) {
                errorCreate.textContent =
                    data.message || "Erro ao salvar evento.";
                errorCreate.style.display = "block";
                showToast("Erro ao salvar evento", "error");
                return;
            }
            closeModal(modalCreate);
            formCreate.reset();
            preview.style.display = "none";
            await loadEvents();
            showToast("Evento criado com sucesso!", "success");
        } catch (err) {
            errorCreate.textContent = "Erro inesperado ao salvar.";
            errorCreate.style.display = "block";
            showToast("Erro inesperado ao salvar evento", "error");
        }
    });

    grid.addEventListener("click", (e) => {
        const btn = e.target.closest(".edit-btn");
        if (!btn) return;
        editingId = btn.dataset.id;
        editTitle.value = btn.dataset.title;
        editDesc.value = btn.dataset.desc;
        editPreview.style.display = "none";
        modalEdit.classList.add("open");
        formEdit.action = `/events/${editingId}`;
    });

    closeEdit?.addEventListener("click", () => closeModal(modalEdit));
    cancelEdit?.addEventListener("click", () => closeModal(modalEdit));

    editImage?.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (file) {
            editPreview.src = URL.createObjectURL(file);
            editPreview.style.display = "block";
        }
    });

    formEdit?.addEventListener("submit", async (e) => {
        e.preventDefault();
        errorEdit.style.display = "none";
        errorEdit.textContent = "";

        const formData = new FormData(formEdit);
        formData.append("_method", "PUT");

        try {
            const res = await fetch(formEdit.action, {
                method: "POST",
                headers: { "X-CSRF-TOKEN": csrf, Accept: "application/json" },
                body: formData,
            });
            const data = await res.json();
            if (!res.ok) {
                errorEdit.textContent = data.message || "Erro ao editar.";
                errorEdit.style.display = "block";
                showToast("Erro ao editar evento", "error");
                return;
            }
            closeModal(modalEdit);
            formEdit.reset();
            editPreview.style.display = "none";
            await loadEvents();
            showToast("Evento atualizado com sucesso!", "success");
        } catch (err) {
            errorEdit.textContent = "Erro inesperado ao editar.";
            errorEdit.style.display = "block";
            showToast("Erro inesperado ao editar evento", "error");
        }
    });

    grid.addEventListener("click", (e) => {
        const btn = e.target.closest(".menu-btn");
        if (btn) {
            const dropdown = btn.parentElement;
            dropdown.classList.toggle("open");
        } else {
            $$(".dropdown").forEach((d) => d.classList.remove("open"));
        }
    });

    loadEvents();
}

document.addEventListener("DOMContentLoaded", () => {
    initEventsPage();
});
