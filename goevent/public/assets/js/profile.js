export function initProfilePage() {
    const modalEdit  = document.querySelector('#modalEdit');
    const openEdit   = document.querySelector('#openEdit');
    const closeEdit  = document.querySelector('#closeEdit');
    const cancelEdit = document.querySelector('#cancelEdit');

    if (!modalEdit) return;

    function openModal() { modalEdit.classList.add('open'); }
    function closeModal(){ modalEdit.classList.remove('open'); }

    openEdit?.addEventListener('click', openModal);
    closeEdit?.addEventListener('click', closeModal);
    cancelEdit?.addEventListener('click', closeModal);

    modalEdit.addEventListener('click', (e) => {
        if(e.target === modalEdit) closeModal();
    });
}
