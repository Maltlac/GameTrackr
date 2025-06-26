document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('addToMyGamesBtn');
    const gameId = btn ? btn.getAttribute('data-game-id') : null;
    const userGameFormContainer = document.getElementById('userGameFormContainer');
    const playtimeInput = document.getElementById('playtime');
    const progressInput = document.getElementById('progress');
    const userGameForm = document.getElementById('userGameForm');
    const userGameFormMsg = document.getElementById('userGameFormMsg');
    const userGameStats = document.getElementById('userGameStats');
    let token = localStorage.getItem('token');
    let headers = { 'Content-Type': 'application/json', 'Accept': 'application/json' };
    if (token) headers['Authorization'] = 'Bearer ' + token;

    if (btn && gameId) {
        btn.addEventListener('click', function(e) {
            // Vérifie la connexion AVANT toute requête
            let token = localStorage.getItem('token');
            if (!token) {
                e.preventDefault();
                showLoginModal();
                return;
            }
        }, { once: true }); // Ajoute ce listener avant le fetch normal

        fetch('/api/users/me/games/' + gameId + '/owned', { headers })
            .then(res => res.json())
            .then(data => {
                if (data.owned) {
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-secondary');
                    btn.disabled = true;
                    btn.innerHTML = '<i class="bi bi-check-circle"></i> Déjà dans votre bibliothèque';
                    // Affiche le formulaire de progression/temps de jeu
                    if (userGameFormContainer) userGameFormContainer.classList.remove('d-none');
                    // Pré-remplir et afficher les stats si données existantes
                    fetch('/api/users/me/games/' + gameId + '/pivot', { headers })
                        .then(res => res.json())
                        .then(pivot => {
                            if (pivot && pivot.playtime !== undefined) {
                                playtimeInput.value = pivot.playtime;
                                userGameStats.innerHTML = '<span class="badge bg-secondary">Temps de jeu : ' + pivot.playtime + ' h</span>';
                            }
                            if (pivot && pivot.progress !== undefined) {
                                progressInput.value = pivot.progress;
                                userGameStats.innerHTML += ' <span class="badge bg-info">Progression : ' + pivot.progress + ' %</span>';
                            }
                        });
                }
            });

        if (userGameForm) {
            userGameForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                userGameFormMsg.innerHTML = '';
                const playtime = playtimeInput.value;
                const progress = progressInput.value;
                let res = await fetch('/api/users/me/games/' + gameId + '/pivot', {
                    method: 'PUT',
                    headers: headers,
                    body: JSON.stringify({ playtime, progress })
                });
                if (res.ok) {
                    userGameFormMsg.innerHTML = '<span class="text-success">Données enregistrées !</span>';
                    userGameStats.innerHTML = '<span class="badge bg-secondary">Temps de jeu : ' + playtime + ' h</span> <span class="badge bg-info">Progression : ' + progress + ' %</span>';
                } else {
                    let data = await res.json();
                    userGameFormMsg.innerHTML = '<span class="text-danger">Erreur : ' + (data.message || "Impossible d'enregistrer") + '</span>';
                }
            });
        }
    }

    // Modale Bootstrap pour inviter à se connecter
    function showLoginModal() {
        let modalHtml = `
        <div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-labelledby="loginRequiredModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light">
              <div class="modal-header">
                <h5 class="modal-title" id="loginRequiredModalLabel">Connexion requise</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
              </div>
              <div class="modal-body">
                Vous devez être connecté pour ajouter un jeu dans votre bibliothèque.
              </div>
              <div class="modal-footer">
                <a href="/login" class="btn btn-primary">Se connecter</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
              </div>
            </div>
          </div>
        </div>
        `;
        if (!document.getElementById('loginRequiredModal')) {
            document.body.insertAdjacentHTML('beforeend', modalHtml);
        }
        let modal = new bootstrap.Modal(document.getElementById('loginRequiredModal'));
        modal.show();
    }
});
