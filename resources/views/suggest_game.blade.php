<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Proposer un jeu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    @include('navbar.navbar')
<div style="height:70px"></div> <!-- espace sous navbar -->
<div class="container mt-5">
    <h1 class="mb-4">Proposer un jeu</h1>
    <form id="suggestGameForm">
        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" id="description"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Lien</label>
            <input type="text" class="form-control" id="link">
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
    <div id="message" class="mt-3"></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/suggest_game.js') }}"></script>
</body>
</html>
