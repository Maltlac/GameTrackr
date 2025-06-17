<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container mt-5">
    <h1 class="mb-4">Administration</h1>
    <p>Gestion des jeux, plateformes et catégories.</p>

    <h2 class="mt-5">Suggestions de jeux</h2>
    <ul class="list-group mb-4">
        @forelse($gameSuggestions as $suggestion)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $suggestion->title }}</span>
            </li>
        @empty
            <li class="list-group-item">Aucune suggestion.</li>
        @endforelse
    </ul>

    <h2>Suggestions de plateformes</h2>
    <ul class="list-group">
        @forelse($platformSuggestions as $suggestion)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $suggestion->platform }} - {{ $suggestion->link }}</span>
            </li>
        @empty
            <li class="list-group-item">Aucune suggestion.</li>
        @endforelse
    </ul>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
