document.getElementById('suggestPlatformForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const platform = document.getElementById('platform').value;
    const link = document.getElementById('link').value;
    const id_game = document.getElementById('id_game').value || null;
    const token = localStorage.getItem('token');
    const res = await fetch('/api/suggestions/platforms', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            ...(token ? { 'Authorization': 'Bearer ' + token } : {})
        },
        body: JSON.stringify({ platform, link, id_game })
    });
    const msg = document.getElementById('message');
    if(res.ok) {
        msg.innerHTML = '<div class="alert alert-success">Suggestion envoyée</div>';
    } else {
        msg.innerHTML = '<div class="alert alert-danger">Erreur</div>';
    }
});
