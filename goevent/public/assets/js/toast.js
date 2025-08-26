// public/assets/js/toast.js
export function showToast(message, type = "success") {
    const containerId = "toast-container";
    let container = document.getElementById(containerId);

    if (!container) {
        container = document.createElement("div");
        container.id = containerId;
        container.className = "toast-container";
        document.body.appendChild(container);
    }

    const toast = document.createElement("div");
    toast.classList.add("toast", type);
    toast.textContent = message;

    container.appendChild(toast);

    toast.addEventListener("animationend", () => {
        if (toast.style.animation.includes("fadeOut")) {
            toast.remove();
        }
    });
}

export function showConfirm(message) {
  return new Promise((resolve) => {
    const modal = document.querySelector("#confirmModal");
    const msg = document.querySelector("#confirmMessage");
    const yes = document.querySelector("#confirmYes");
    const no = document.querySelector("#confirmNo");

    msg.textContent = message;
    modal.classList.add("open");

    function cleanup(result) {
      modal.classList.remove("open");
      yes.removeEventListener("click", onYes);
      no.removeEventListener("click", onNo);
      resolve(result);
    }

    function onYes() { cleanup(true); }
    function onNo() { cleanup(false); }

    yes.addEventListener("click", onYes);
    no.addEventListener("click", onNo);
  });
}
