<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une plateforme</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    @include('navbar.navbar')
<div style="height:70px"></div> <!-- espace sous navbar -->
<div class="container mt-5">
    <h1 class="mb-4">Ajouter une plateforme</h1>
    <form id="addPlatformForm" class="mb-3">
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" id="platformName" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <div id="platformMessage" class="mb-4"></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
