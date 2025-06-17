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


    <h2 class="mt-5">Ajouter un jeu</h2>
    <form id="addGameForm">
        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" class="form-control" id="gameTitle" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" id="gameDescription"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Couverture (URL)</label>
            <input type="text" class="form-control" id="gameCover">
        </div>
        <div class="mb-3">
            <label class="form-label">Date de sortie</label>
            <input type="date" class="form-control" id="gameRelease">
        </div>
        <div class="mb-3">
            <label class="form-label">Genres</label>
            <select multiple class="form-select" id="gameGenres">
                @foreach($genres as $genre)
                    <option value="{{ $genre->id_genre }}">{{ $genre->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Plateformes</label>
            @foreach($platforms as $platform)
                <div class="input-group mb-2">
                    <span class="input-group-text">{{ $platform->name }}</span>
                    <input type="text" class="form-control platform-link" data-platform-id="{{ $platform->id_platform }}" placeholder="Lien optionnel">
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <div id="gameMessage" class="mt-3"></div>

    <hr class="my-5">

    <h2>Ajouter une plateforme</h2>
    <form id="addPlatformForm" class="mb-3">
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" id="platformName" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <div id="platformMessage" class="mb-4"></div>

    <h2>Ajouter un genre</h2>
    <form id="addGenreForm" class="mb-3">
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" id="genreName" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <div id="genreMessage" class="mb-4"></div>

    <h2 class="mt-5">Suggestions de jeux</h2>
    <ul class="list-group mb-4" id="gameSuggestions">
        @forelse($gameSuggestions as $suggestion)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $suggestion->title }}</span>
                <button class="btn btn-sm btn-success approve-game" data-id="{{ $suggestion->id }}">Valider</button>

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

    <ul class="list-group" id="platformSuggestions">
        @forelse($platformSuggestions as $suggestion)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $suggestion->platform }} - {{ $suggestion->link }}</span>
                <button class="btn btn-sm btn-success approve-platform" data-id="{{ $suggestion->id }}">Valider</button>

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
