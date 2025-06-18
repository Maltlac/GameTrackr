(function(){
    const isAdmin = localStorage.getItem('is_admin');
    if(isAdmin !== '1' && isAdmin !== 'true') {
        window.location.href = '/home';

        return;
    }

    const token = localStorage.getItem('token');
    const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...(token ? { 'Authorization': 'Bearer ' + token } : {})
    };

    const gameForm = document.getElementById('addGameForm');
    if (gameForm) {
        gameForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const platforms = {};
            document.querySelectorAll('.platform-link').forEach(input => {
                platforms[input.dataset.platformId] = input.value;
            });
            const res = await fetch('/api/games', {
                method: 'POST',
                headers,
                body: JSON.stringify({
                    title: document.getElementById('gameTitle').value,
                    description: document.getElementById('gameDescription').value,
                    cover_url: document.getElementById('gameCover').value,
                    release_date: document.getElementById('gameRelease').value,
                    genres: Array.from(document.getElementById('gameGenres').selectedOptions).map(o => o.value),
                    platform_links: platforms
                })
            });
            document.getElementById('gameMessage').textContent = res.ok ? 'Jeu ajouté' : 'Erreur';
        });
    }

    const platformForm = document.getElementById('addPlatformForm');
    if (platformForm) {
        platformForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const res = await fetch('/api/platforms', {
                method: 'POST',
                headers,
                body: JSON.stringify({ name: document.getElementById('platformName').value })
            });
            document.getElementById('platformMessage').textContent = res.ok ? 'Plateforme ajoutée' : 'Erreur';
        });
    }

    const genreForm = document.getElementById('addGenreForm');
    if (genreForm) {
        genreForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const res = await fetch('/api/genres', {
                method: 'POST',
                headers,
                body: JSON.stringify({ name: document.getElementById('genreName').value })
            });
            document.getElementById('genreMessage').textContent = res.ok ? 'Genre ajouté' : 'Erreur';
        });
    }

    document.querySelectorAll('.approve-game').forEach(btn => {
        btn.addEventListener('click', async () => {
            const res = await fetch(`/api/suggestions/games/${btn.dataset.id}/approve`, { method: 'POST', headers });
            if (res.ok) btn.parentElement.remove();
        });
    });

    document.querySelectorAll('.approve-platform').forEach(btn => {
        btn.addEventListener('click', async () => {
            const res = await fetch(`/api/suggestions/platforms/${btn.dataset.id}/approve`, { method: 'POST', headers });
            if (res.ok) btn.parentElement.remove();
        });
    });

    }

);
