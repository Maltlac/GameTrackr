<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Gérer les jeux</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-dark text-light">
    @include('navbar.navbar')
    <div style="height:70px"></div> <!-- espace sous navbar -->
    <div class="container">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">
                            @if ($errors->any())
                                <div id="hideDiv" class="alert alert-info">{{$errors->first() }}</div>
                            @endif
                            <div class="col-sm-12 col-xs-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <form class="form-horizontal needs-validation d-flex" method="GET" action="{{ route('admin.games.show') }}">
                                        <input type="search" name="search" value="{{ request()->input('search') }}" class="form-control w-auto me-2" placeholder="Recherche par titre..." required>
                                        <button class="btn btn-primary me-3" type="submit">Rechercher</button>
                                        <label class="me-2">Afficher :</label>
                                        <select id="pagination" name="pagination" class="form-select w-auto" onchange="this.form.submit()">
                                            <option value="5" @if($items == 5) selected @endif >5</option>
                                            <option value="10" @if($items == 10) selected @endif >10</option>
                                            <option value="15" @if($items == 15) selected @endif >15</option>
                                            <option value="20" @if($items == 20) selected @endif >20</option>
                                            <option value="25" @if($items == 25) selected @endif >25</option>
                                        </select>
                                    </form>
                                    <a href="{{ route('admin.games.create') }}" class="btn btn-success">Ajouter un jeu</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>#</th>
                                    <th>Titre</th>
                                    <th>Description</th>
                                    <th>Date de sortie</th>
                                    <th>Voir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($games as $game)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.games.edit', $game->id_game) }}" class="btn btn-primary d-inline" title="Éditer">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.games.destroy', $game->id_game) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce jeu ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>{{ $game->id_game }}</td>
                                    <td>{{ $game->title }}</td>
                                    <td>{{ Str::limit($game->description, 60) }}</td>
                                    <td>{{ $game->release_date }}</td>
                                    <td>
                                        <a href="{{ route('admin.games.show', $game->id_game) }}" class="btn btn-sm btn-success" title="Voir">
                                            <i class="bi bi-search"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer" style="margin-top:-16px">
                        <div class="row">
                            @if ($games->hasPages())
                            <ul class="pagination hidden-xs pull-right">
                                {!! $games->appends(Request::except('page'))->render() !!}
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


