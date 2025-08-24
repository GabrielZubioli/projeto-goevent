import { initEventsPage } from "./event.js";
import { initProfilePage } from "./profile.js";

document.addEventListener('DOMContentLoaded', () => {
    const mainContent = document.getElementById('main-content');
    const links = document.querySelectorAll('nav a[data-nav]');

    links.forEach(link => {
        link.addEventListener('click', async (e) => {
            e.preventDefault();
            const page = link.getAttribute('data-nav');

            try {
                const res = await fetch(`/${page}`);
                const html = await res.text();
                mainContent.innerHTML = html;

                if (page === 'events') {
                    initEventsPage();
                }
                if (page === 'profile') {
                    initProfilePage();
                }

            } catch (err) {
                console.error('Erro ao carregar a página:', err);
                mainContent.innerHTML = '<p>Erro ao carregar conteúdo.</p>';
            }
        });
    });

    (async () => {
        try {
            const res = await fetch(`/events`);
            const html = await res.text();
            mainContent.innerHTML = html;
            initEventsPage();
        } catch (err) {
            console.error('Erro ao carregar eventos iniciais:', err);
        }
    })();
});
