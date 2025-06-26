<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un jeu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .genre-btn {
            margin: 0.2rem;
            cursor: pointer;
        }
        .genre-btn.selected {
            background-color: #0d6efd;
            color: #fff;
        }
    </style>
</head>
<body class="bg-dark text-light">
    @include('navbar.navbar')
    <div style="height:70px"></div> <!-- espace sous navbar -->
    <div class="container mt-5">
        <h1 class="mb-4">{{ isset($game) ? 'Modifier' : 'Ajouter' }} un jeu</h1>
        <form id="addGameForm" class="mb-4">
            @if(isset($game))
                <input type="hidden" id="gameId" value="{{ $game->id_game }}">
            @endif
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" class="form-control" id="gameTitle" name="title" required value="{{ old('title', $game->title ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" id="gameDescription" name="description" rows="3" required>{{ old('description', $game->description ?? '') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">URL de couverture</label>
                <input type="text" class="form-control" id="gameCover" name="cover_url" value="{{ old('cover_url', $game->cover_url ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Date de sortie</label>
                <input type="date" class="form-control" id="gameRelease" name="release_date" value="{{ old('release_date', isset($game->release_date) ? $game->release_date : '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Genres</label>
                <div id="genresList" class="d-flex flex-wrap">
                    @php
                        $selectedGenres = isset($game) ? $game->genres->pluck('id_genre')->toArray() : [];
                    @endphp
                    @foreach($genres as $genre)
                        <button type="button"
                            class="btn btn-outline-primary genre-btn{{ in_array($genre->id_genre, $selectedGenres) ? ' selected' : '' }}"
                            data-genre-id="{{ $genre->id_genre }}">
                            {{ $genre->name }}
                        </button>
                    @endforeach
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Plateformes</label>
                <table class="table table-dark table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>URL (optionnel)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $platformLinks = [];
                            if(isset($game)) {
                                foreach($game->platforms as $p) {
                                    $platformLinks[$p->id_platform] = $p->pivot->link;
                                }
                            }
                        @endphp
                        @foreach($platforms as $platform)
                        <tr>
                            <td>{{ $platform->name }}</td>
                            <td>
                                <input type="text" class="form-control platform-link"
                                    data-platform-id="{{ $platform->id_platform }}"
                                    placeholder="Lien vers {{ $platform->name }}"
                                    value="{{ old('platform_'.$platform->id_platform, $platformLinks[$platform->id_platform] ?? '') }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary">{{ isset($game) ? 'Modifier' : 'Ajouter' }}</button>
        </form>
    </div>

    <!-- Modal de confirmation -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmModalLabel">Jeu ajouté</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body" id="confirmModalBody">
            <!-- Message JS -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/adminAjoutJeu.js') }}"></script>
    <script>
    // Indique au JS si on est en mode édition
    window.isEdit = {{ isset($game) ? 'true' : 'false' }};
    </script>
</body>
</html>