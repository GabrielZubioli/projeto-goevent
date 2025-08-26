import { showToast } from "./toast.js";

export function initProfilePage() {
    const modalEdit = document.querySelector("#modalEdit");
    const openEdit = document.querySelector("#openEdit");
    const closeEdit = document.querySelector("#closeEdit");
    const cancelEdit = document.querySelector("#cancelEdit");
    const form = document.querySelector("#formProfile");
    const errorBox = document.querySelector("#profileError");

    if (!modalEdit || !form) return;

    function openModal() {
        modalEdit.classList.add("open");
    }
    function closeModal() {
        modalEdit.classList.remove("open");
    }

    openEdit?.addEventListener("click", openModal);
    closeEdit?.addEventListener("click", closeModal);
    cancelEdit?.addEventListener("click", closeModal);

    // fecha se clicar fora
    modalEdit.addEventListener("mousedown", (e) => {
        if (e.target === modalEdit) {
            modalEdit.addEventListener("mouseup", function handler(ev) {
                if (ev.target === modalEdit) closeModal();
                modalEdit.removeEventListener("mouseup", handler);
            });
        }
    });

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        errorBox.style.display = "none";
        errorBox.textContent = "";

        const formData = new FormData(form);
        const password = formData.get("new_password");

        if (password) {
            const regex = /^(?=.*[a-z])(?=.*[A-Z]).{6,}$/;
            if (!regex.test(password)) {
                errorBox.textContent =
                    "A senha deve ter pelo menos 6 caracteres, uma letra minúscula e uma maiúscula.";
                errorBox.style.display = "block";
                return;
            }
        }

        try {
            const res = await fetch(form.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
                body: formData,
            });

            const data = await res.json();

            if (!res.ok) {
                errorBox.textContent = data.message || "Erro ao salvar perfil.";
                errorBox.style.display = "block";
                return;
            }

            document.querySelector("#profileName").textContent = data.user.name;
            document.querySelector("#profileEmail").textContent =
                data.user.email;

            closeModal();
            showToast("Perfil atualizado com sucesso!", "success");
        } catch (err) {
            console.error(err);
            errorBox.textContent = "Erro inesperado ao atualizar perfil.";
            errorBox.style.display = "block";
        }
    });
}

document.addEventListener("DOMContentLoaded", () => {
    initProfilePage();
});
