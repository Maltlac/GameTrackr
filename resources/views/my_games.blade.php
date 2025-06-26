<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Ma bibliothèque de jeux</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
@include('navbar.navbar')
<div style="height:70px"></div>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="m-0">Ma bibliothèque</h1>
        <span class="badge bg-secondary fs-5">Total heures jouées : {{ $totalPlaytime ?? 0 }}</span>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
        @forelse($games as $game)
            <div class="col">
                <div class="card h-75">
                    <a href="{{ url('/games/' . $game->id_game) }}">
                        <img src="{{ $game->cover_url ?: 'https://placehold.co/400x220/222/fff?text=' . urlencode($game->title) }}" class="card-img-top game-img" alt="{{ $game->title }}">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $game->title }}</h5>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <div class="alert alert-secondary text-center">Aucun jeu dans votre bibliothèque.</div>
            </div>
        @endforelse
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
