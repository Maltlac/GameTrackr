document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const messageDiv = document.getElementById('message');
    messageDiv.innerHTML = '';
    try {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ email, password })
        });
        const data = await response.json();
        if (response.ok && data.token) {
            localStorage.setItem('token', data.token);
            if (data.user && data.user.name) {
                localStorage.setItem('name', data.user.name);
            }
            if (data.user && data.user.is_admin !== undefined) {
                localStorage.setItem('is_admin', data.user.is_admin ? '1' : '0');
            }
            messageDiv.innerHTML = '<div class="alert alert-success">Connexion réussie !</div>';
            window.location.href = 'home';
        } else {
            let msg = data.message || (data.errors ? Object.values(data.errors).join('<br>') : 'Erreur inconnue');
            messageDiv.innerHTML = '<div class="alert alert-danger">' + msg + '</div>';
        }
    } catch (err) {
        messageDiv.innerHTML = '<div class="alert alert-danger">Erreur réseau</div>';
    }
});
