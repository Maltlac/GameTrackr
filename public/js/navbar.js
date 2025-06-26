function logout() {
    localStorage.removeItem('token');
    localStorage.removeItem('name');
    localStorage.removeItem('is_admin');
    window.location.reload();
}



function renderNavbar() {
    const navbarRight = document.getElementById('navbar-right');
    navbarRight.innerHTML = '';
    const token = localStorage.getItem('token');
    const name = localStorage.getItem('name') || 'Utilisateur';
    const isAdmin = localStorage.getItem('is_admin');
    if (!token) {
        navbarRight.innerHTML = `
            <li class="nav-item">
                <a class="btn btn-outline-light me-2" href="login">Connexion</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-primary" href="register">Inscription</a>
            </li>
        `;
    } else {
        navbarRight.innerHTML = `
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i> ${name}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    ${isAdmin === '1' || isAdmin === 'true' ? '<li><a class="dropdown-item" href="/admin">Administration</a></li><li><hr class="dropdown-divider"></li>' : ''}
                    <li><a class="dropdown-item" href="#">Ma wishlist</a></li>
                    <li><a class="dropdown-item" href="#">Mes jeux</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#" onclick="logout()">Déconnexion</a></li>
                </ul>
            </li>
        `;
    }
}
document.addEventListener('DOMContentLoaded', renderNavbar);
