document.getElementById('suggestGameForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const title = document.getElementById('title').value;
    const description = document.getElementById('description').value;
    const link = document.getElementById('link').value;
    const token = localStorage.getItem('token');
    const res = await fetch('/api/suggestions/games', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            ...(token ? { 'Authorization': 'Bearer ' + token } : {})
        },
        body: JSON.stringify({ title, description, link })
    });
    const data = await res.json();
    const msg = document.getElementById('message');
    if(res.ok) {
        msg.innerHTML = '<div class="alert alert-success">Suggestion envoyée</div>';
    } else {
        msg.innerHTML = '<div class="alert alert-danger">Erreur</div>';
    }
});
