<link href="{{ asset('css/navbar.css') }}" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="home">GameTrackr</a>
        <form class="d-flex ms-3 me-auto" role="search" style="max-width:400px;">
            <input class="form-control me-2 search-bar" type="search" placeholder="Rechercher un jeu..." aria-label="Rechercher">
            <button class="btn btn-outline-light" type="submit">Rechercher</button>
        </form>
        <ul class="navbar-nav ms-auto align-items-center" id="navbar-right">
            {{-- Dynamique JS --}}
        </ul>
    </div>
</nav>


<script src="{{ asset('js/navbar.js') }}"></script>