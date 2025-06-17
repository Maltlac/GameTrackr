<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>GameTrackr - Accueil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">GameTrackr</a>
        <form class="d-flex ms-3 me-auto" role="search" style="max-width:400px;">
            <input class="form-control me-2 search-bar" type="search" placeholder="Rechercher un jeu..." aria-label="Rechercher">
            <button class="btn btn-outline-light" type="submit">Rechercher</button>
        </form>
        <ul class="navbar-nav ms-auto align-items-center" id="navbar-right">
            {{-- Dynamique JS --}}
        </ul>
    </div>
</nav>

<div style="height:70px"></div> <!-- espace sous navbar -->

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="m-0">Jeux populaires</h1>
        <a href="{{ route('suggest.game') }}" class="btn btn-primary">Proposer un jeu</a>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
        @foreach($games as $game)
            <div class="col">
                <div class="card h-100">
                    <img src="{{ $game->cover_url ?: 'https://placehold.co/400x200/222/fff?text=' . urlencode($game->title) }}" class="card-img-top" alt="{{ $game->title }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $game->title }}</h5>
                        <p class="card-text flex-grow-1">{{ $game->description ?? 'Aucune description.' }}</p>
                        <a href="{{ route('suggest.platform', ['game' => $game->id_game]) }}" class="btn btn-outline-light mt-2">Proposer une plateforme</a>
                    </div>
                </div>
            </div>
        @endforeach
        @if($games->isEmpty())
            <div class="col">
                <div class="alert alert-secondary text-center">Aucun jeu à afficher.</div>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/home.js') }}"></script>
</body>
</html>