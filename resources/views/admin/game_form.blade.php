<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un jeu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container mt-5">
    <h1 class="mb-4">Ajouter un jeu</h1>
    <form id="addGameForm" class="mb-4">
        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" class="form-control" id="gameTitle" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" id="gameDescription" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">URL de couverture</label>
            <input type="text" class="form-control" id="gameCover">
        </div>
        <div class="mb-3">
            <label class="form-label">Date de sortie</label>
            <input type="date" class="form-control" id="gameRelease">
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <div id="platformMessage" class="mb-4"></div>

    <h2>Ajouter un genre</h2>
    <form id="addGenreForm" class="mb-3">
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" id="genreName" required>
            <label class="form-label">Genres</label>
            <select id="gameGenres" class="form-select" multiple>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id_genre }}">{{ $genre->name }}</option>
                @endforeach
            </select>
        </div>
        <h2 class="mt-4">Liens plateformes</h2>
        @foreach($platforms as $platform)
            <div class="mb-3">
                <label class="form-label">{{ $platform->name }}</label>
                <input type="text" class="form-control platform-link" data-platform-id="{{ $platform->id_platform }}" placeholder="Lien vers {{ $platform->name }}">
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <div id="genreMessage" class="mb-4"></div>

    <div id="gameMessage" class="mb-4"></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>