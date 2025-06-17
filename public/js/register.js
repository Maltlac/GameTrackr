document.getElementById('togglePassword').addEventListener('click', function() {
    const pwd = document.getElementById('password');
    pwd.type = pwd.type === 'password' ? 'text' : 'password';
    this.querySelector('span').className = pwd.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
});
document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
    const pwd = document.getElementById('password_confirmation');
    pwd.type = pwd.type === 'password' ? 'text' : 'password';
    this.querySelector('span').className = pwd.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
});

document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const password_confirmation = document.getElementById('password_confirmation').value;
    const messageDiv = document.getElementById('message');
    messageDiv.innerHTML = '';

    if (password !== password_confirmation) {
        messageDiv.innerHTML = '<div class="alert alert-danger">Les mots de passe ne correspondent pas.</div>';
        return;
    }

    try {
        const response = await fetch('/api/register', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ name, email, password, password_confirmation })
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
            messageDiv.innerHTML = '<div class="alert alert-success">Inscription réussie !</div>';
            window.location.href = 'home';
        } else {
            let msg = data.message || (data.errors ? Object.values(data.errors).join('<br>') : 'Erreur inconnue');
            messageDiv.innerHTML = '<div class="alert alert-danger">' + msg + '</div>';
        }
    } catch (err) {
        messageDiv.innerHTML = '<div class="alert alert-danger">Erreur réseau</div>';
    }
});
