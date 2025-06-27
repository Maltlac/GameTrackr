{{-- filepath: c:\Users\maltl\dev\GameTrackr\resources\views\search_results.blade.php --}}
<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Résultats de recherche</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>
<body>
@include('navbar.navbar')
<div style="height:70px"></div>
<div class="container mt-5">
    <h1>Résultats pour "{{ $q }}"</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center mt-4">
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
                <div class="alert alert-secondary text-center">Aucun jeu trouvé.</div>
            </div>
        @endforelse
    </div>
    <div class="mt-4 d-flex justify-content-center">
        {{ $games->links('pagination::bootstrap-5') }}
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>