<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>{{ $game->title }} - Détail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .game-cover {
            width: 100%;
            max-width: 400px;
            height: 220px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .platform-link {
            text-decoration: underline;
            color: #0d6efd;
            cursor: pointer;
        }
        .platform-link:hover {
            color: #0a58ca;
        }
    </style>
</head>
<body class="bg-dark text-light">
    @include('navbar.navbar')
    <div style="height:70px"></div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card bg-dark text-light shadow">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row align-items-md-start">
                            <img src="{{ $game->cover_url ?: 'https://placehold.co/400x220/222/fff?text=' . urlencode($game->title) }}"
                                 alt="{{ $game->title }}" class="game-cover me-md-4 mb-3 mb-md-0">
                            <div>
                                <h2 class="card-title">{{ $game->title }}</h2>
                                <p class="mb-2"><strong>Date de sortie :</strong> {{ $game->release_date ? \Carbon\Carbon::parse($game->release_date)->format('d/m/Y') : 'Non renseignée' }}</p>
                                <p class="mb-2"><strong>Genres :</strong>
                                    @if($game->genres && count($game->genres))
                                        @foreach($game->genres as $genre)
                                            <span class="badge bg-primary me-1">{{ $genre->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-secondary">Aucun</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <hr>
                        <h5>Description</h5>
                        <p class="card-text">{{ $game->description ?? 'Aucune description.' }}</p>
                        <hr>
                        <h5>Plateformes</h5>
                        <ul class="list-group list-group-flush">
                            @if($game->platforms && $game->platforms->count())
                                @foreach($game->platforms as $platform)
                                    @if($platform->pivot && $platform->pivot->link)
                                    <li class="list-group-item bg-dark text-light d-flex align-items-center">
                                        <span class="me-2"><i class="bi bi-controller"></i></span>
                                        <a href="{{ $platform->pivot->link }}" class="platform-link" target="_blank" data-platform="{{ $platform->id_platform }}" data-url="{{ $platform->pivot->link }}">
                                            {{ $platform->name }}
                                        </a>
                                        <span class="ms-2 text-info" id="price-{{ $platform->id_platform }}"></span>
                                    </li>
                                    @endif
                                @endforeach
                                @if($game->platforms->filter(fn($p) => $p->pivot && $p->pivot->link)->isEmpty())
                                    <li class="list-group-item bg-dark text-secondary">Aucune plateforme renseignée</li>
                                @endif
                            @else
                                <li class="list-group-item bg-dark text-secondary">Aucune plateforme renseignée</li>
                            @endif
                        </ul>
                        <div class="mt-4">
                            @auth
                                <button id="addToMyGamesBtn" class="btn btn-success w-100" data-game-id="{{ $game->id_game }}">
                                    <i class="bi bi-plus-circle"></i> Ajouter à mes jeux
                                </button>
                                <div id="addToMyGamesMsg" class="mt-2"></div>
                                <div id="userGameFormContainer" class="mt-3 d-none">
                                    <form id="userGameForm">
                                        <div class="mb-2">
                                            <label for="playtime" class="form-label">Temps de jeu (heures)</label>
                                            <input type="number" min="0" step="0.1" class="form-control" id="playtime" name="playtime">
                                        </div>
                                        <div class="mb-2">
                                            <label for="progress" class="form-label">Progression (%)</label>
                                            <input type="number" min="0" max="100" step="1" class="form-control" id="progress" name="progress">
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
                                        <div id="userGameFormMsg" class="mt-2"></div>
                                    </form>
                                    <div id="userGameStats" class="mt-2"></div>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/gamesShow.js') }}"></script>
    @auth
    <script src="{{ asset('js/gameUserPivot.js') }}"></script>
    @endauth
</body>
</html>
      