document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.platform-link').forEach(link => {
        const url = link.getAttribute('href');
        const priceSpan = document.getElementById('price-' + link.dataset.platform);

        // Steam
        if (url && url.includes('store.steampowered.com/app/')) {
            if (priceSpan) {
                priceSpan.innerText = 'Chargement...';
                fetch('/api/scrap-price?url=' + encodeURIComponent(url))
                    .then(res => res.json())
                    .then(data => {
                        if (data && typeof data === 'object') {
                            if (data.is_free) {
                                priceSpan.innerText = ' : gratuit';
                            } else if (data.price_overview && data.price_overview.final_formatted) {
                                priceSpan.innerText = ' : ' + data.price_overview.final_formatted;
                            } else {
                                priceSpan.innerText = ' : Prix non trouvé';
                            }
                        } else {
                            priceSpan.innerText = ' : Prix non trouvé';
                        }
                    })
                    .catch(() => {
                        priceSpan.innerText = ' : Erreur';
                    });
            }
        }

        // Instant Gaming
        if (url && url.includes('instant-gaming.com/')) {
            if (priceSpan) {
                priceSpan.innerText = 'Chargement...';
                fetch('/api/scrap-price?url=' + encodeURIComponent(url))
                    .then(res => res.json())
                    .then(data => {
                        // On prend le dernier prix trouvé (le plus bas dans la page)
                        if (data && data.price) {
                            priceSpan.innerText = ' : ' + data.price;
                        } else if (data && data.debug) {
                            priceSpan.innerText =   JSON.stringify(data.debug);
                        } else {
                            priceSpan.innerText = ' : Prix non trouvé';
                        }
                    })
                    .catch(() => {
                        priceSpan.innerText = ' : Erreur';
                    });
            }
        }

        // Epic Games (debug uniquement, tu peux le retirer si tu ne veux plus Epic)
        if (url && url.includes('store.epicgames.com')) {
            if (priceSpan) {
                priceSpan.innerText = 'Chargement...';
                fetch('/api/scrap-price?url=' + encodeURIComponent(url))
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.price) {
                            priceSpan.innerText = ' : ' + data.price;
                        } else {
                            priceSpan.innerText = ' : Prix non trouvé';
                        }
                    })
                    .catch(() => {
                        priceSpan.innerText = ' : Erreur';
                    });
            }
        }
    });

    // Ajout à "mes jeux" + gestion du bouton selon possession
    const btn = document.getElementById('addToMyGamesBtn');
    const alreadyBtn = document.getElementById('alreadyOwnedBtn');
    const gameId = btn ? btn.getAttribute('data-game-id') : null;
    if (btn && gameId) {
        let token = localStorage.getItem('token');
        let headers = { 'Content-Type': 'application/json', 'Accept': 'application/json' };
        if (token) headers['Authorization'] = 'Bearer ' + token;
        fetch('/api/users/me/games/' + gameId + '/owned', { headers })
            .then(res => res.json())
            .then(data => {
                if (data.owned) {
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-secondary');
                    btn.disabled = true;
                    btn.innerHTML = '<i class="bi bi-check-circle"></i> Déjà dans votre bibliothèque';
                } else {
                    btn.classList.remove('btn-secondary');
                    btn.classList.add('btn-success');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-plus-circle"></i> Ajouter à mes jeux';
                }
            });

        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Ajout...';
            let res = await fetch('/api/users/me/games', {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({ id_game: gameId })
            });
            let msg = document.getElementById('addToMyGamesMsg');
            if (res.ok) {
                msg.innerHTML = '<span class="text-success">Jeu ajouté à votre collection !</span>';
                btn.classList.remove('btn-success');
                btn.classList.add('btn-secondary');
                btn.disabled = true;
                btn.innerHTML = '<i class="bi bi-check-circle"></i> Déjà dans votre bibliothèque';
            } else {
                let data = await res.json();
                msg.innerHTML = '<span class="text-danger">Erreur : ' + (data.message || "Impossible d'ajouter le jeu") + '</span>';
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-plus-circle"></i> Ajouter à mes jeux';
            }
        });
    }
});