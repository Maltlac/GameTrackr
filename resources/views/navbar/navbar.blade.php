<link href="{{ asset('css/navbar.css') }}" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/home">GameTrackr</a>
        <form class="d-flex position-relative" role="search" id="searchForm" action="{{ route('search.page') }}" method="get" autocomplete="off">
            <input class="form-control me-2" type="search" placeholder="Rechercher un jeu..." aria-label="Search" id="searchInput" name="q" value="{{ request('q') }}">
            <button class="btn btn-outline-success" type="submit">Rechercher</button>
            <ul class="list-group position-absolute w-100" id="searchSuggestions" style="z-index: 1000; top: 100%; left: 0; display: none;"></ul>
        </form>
        <ul class="navbar-nav ms-auto align-items-center" id="navbar-right">
            {{-- Dynamique JS --}}
        </ul>
    </div>
</nav>


<script src="{{ asset('js/navbar.js') }}"></script>
<script src="{{ asset('js/searchbar.js') }}"></script>