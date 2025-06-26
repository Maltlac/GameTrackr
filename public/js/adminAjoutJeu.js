document.addEventListener('DOMContentLoaded', function() {
    const selectedGenres = new Set();
    document.querySelectorAll('.genre-btn').forEach(btn => {
        if (btn.classList.contains('selected')) {
            selectedGenres.add(btn.getAttribute('data-genre-id'));
        }
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-genre-id');
            if (selectedGenres.has(id)) {
                selectedGenres.delete(id);
                this.classList.remove('selected');
            } else {
                selectedGenres.add(id);
                this.classList.add('selected');
            }
        });
    });

    document.getElementById('addGameForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const title = document.getElementById('gameTitle').value;
        const description = document.getElementById('gameDescription').value;
        const cover_url = document.getElementById('gameCover').value;
        const release_date = document.getElementById('gameRelease').value;
        const genres = Array.from(selectedGenres).map(Number);
        const platforms = [];
        document.querySelectorAll('.platform-link').forEach(input => {
            const url = input.value.trim();
            const id_platform = input.getAttribute('data-platform-id');
            if (url && id_platform) {
                platforms.push({
                    id_platform: Number(id_platform),
                    url: url
                });
            }
        });

        let token = localStorage.getItem('token');
        let headers = { 'Content-Type': 'application/json', 'Accept': 'application/json' };
        if (token) headers['Authorization'] = 'Bearer ' + token;

        let urlApi = '/api/games';
        let method = 'POST';
        let gameId = null;
        if (window.isEdit) {
            gameId = document.getElementById('gameId').value;
            urlApi = `/api/games/${gameId}`;
            method = 'PUT';
        }

        let response = await fetch(urlApi, {
            method: method,
            headers: headers,
            body: JSON.stringify({ title, description, cover_url, release_date, genres, platforms })
        });
        let data;
        try {
            data = await response.json();
        } catch (err) {
            showModal('Erreur lors de la sauvegarde du jeu (réponse invalide).');
            return;
        }
        if (!response.ok || (!window.isEdit && !data.id_game)) {
            showModal('Erreur lors de la sauvegarde du jeu.<br>' + (data && data.message ? data.message : ''));
            return;
        }
        if (window.isEdit) {
            showModal('Le jeu a bien été modifié.');
            setTimeout(() => {
                window.history.back();
            }, 1200);
        } else {
            showModal(`Le jeu a bien été ajouté avec l'ID <b>${data.id_game}</b>.`);
        }
        // Ne reset pas le formulaire en édition
        if (!window.isEdit) {
            this.reset();
            document.querySelectorAll('.genre-btn.selected').forEach(btn => btn.classList.remove('selected'));
            selectedGenres.clear();
        }
    });

    function showModal(message) {
        document.getElementById('confirmModalBody').innerHTML = message;
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        modal.show();
    }
});