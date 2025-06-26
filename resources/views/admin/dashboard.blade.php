<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Administration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

    @include('navbar.navbar')
    <div style="height:70px"></div> <!-- espace sous navbar -->

<div class="container mt-5">
    <h1 class="mb-4">Panel Administration</h1>
    <table class="table table-dark table-striped">
        <thead>
        <tr>
            <th>Action</th>
            <th>Description</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Voir les jeux</td>
            <td>Gérer les jeux, modification, création et suppression possible</td>
            <td><a class="btn btn-primary" href="{{ route('admin.games.show') }}">Ouvrir</a></td>
        </tr>
        <tr>
            <td>Ajouter une plateforme</td>
            <td>Créer une nouvelle plateforme disponible</td>
            <td><a class="btn btn-primary" href="{{ route('admin.platforms.create') }}">Ouvrir</a></td>
        </tr>
        <tr>
            <td>Ajouter un genre</td>
            <td>Créer une nouvelle catégorie de jeu</td>
            <td><a class="btn btn-primary" href="{{ route('admin.genres.create') }}">Ouvrir</a></td>
        </tr>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
