<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Inscription GameTrackr</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h2 class="mb-4 text-center">Inscription GameTrackr</h2>
                <form id="registerForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="name" required autocomplete="username">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email</label>
                        <input type="email" class="form-control" id="email" required autocomplete="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" required autocomplete="new-password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1">
                                <span id="eyePassword" class="bi bi-eye"></span>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation" required autocomplete="new-password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm" tabindex="-1">
                                <span id="eyePasswordConfirm" class="bi bi-eye"></span>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                </form>
                <div id="message" class="mt-3"></div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>