<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Platform;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        return response()->json(Game::all(), 200);
    }

    public function show($id_game)
    {
        $game = Game::find($id_game);
        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }
        return response()->json($game, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'cover_url' => 'nullable|string',
            'release_date' => 'nullable|date',
        ]);

        $game = Game::create($validated);

        // Récupération des genres (array d'IDs)
        $genres = $request->input('genres', []);
        if (!empty($genres) && is_array($genres)) {
            // S'assure que les genres existent et évite les doublons
            $genreIds = \App\Models\Genre::whereIn('id_genre', $genres)->pluck('id_genre')->toArray();
            $game->genres()->sync($genreIds);
        }

        // Récupération des plateformes (array d'objets {id_platform, url})
        $platforms = $request->input('platforms', []);
        if (!empty($platforms) && is_array($platforms)) {
            $pivotData = [];
            foreach ($platforms as $platform) {
                if (!empty($platform['id_platform']) && !empty($platform['url'])) {
                    $pivotData[$platform['id_platform']] = ['link' => $platform['url']];
                }
            }
            if (!empty($pivotData)) {
                // S'assure que les plateformes existent
                $validPlatformIds = \App\Models\Platform::whereIn('id_platform', array_keys($pivotData))->pluck('id_platform')->toArray();
                $filteredPivotData = array_intersect_key($pivotData, array_flip($validPlatformIds));
                $game->platforms()->sync($filteredPivotData);
            }
        }

        return response()->json(['id_game' => $game->id_game], 201);
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'nullable|string',
            'cover_url' => 'nullable|url',
            'release_date' => 'nullable|date',
            'genres' => 'sometimes|array',
            'genres.*' => 'integer|exists:genres,id_genre',
            'platform_links' => 'sometimes|array',
        ]);

        $genres = $validated['genres'] ?? null;
        $platformLinks = $validated['platform_links'] ?? null;
        unset($validated['genres'], $validated['platform_links']);

        $game->update($validated);

        if ($genres !== null) {
            $game->genres()->sync($genres);
        }

        if ($platformLinks !== null) {
            $syncData = [];
            foreach ($platformLinks as $platformId => $link) {
                $syncData[$platformId] = ['link' => $link];
            }
            $game->platforms()->sync($syncData);
        }

        return response()->json($game->load(['genres', 'platforms']));
    }

    public function destroy(Game $game)
    {
        $game->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function showDetail($id)
    {
        $game = Game::with(['genres', 'platforms'])->findOrFail($id);
        return view('game', compact('game'));
    }

    public function autocomplete(Request $request)
    {
        $q = $request->query('q');
        if (!$q) return response()->json([]);
        $games = \App\Models\Game::where('title', 'like', '%' . $q . '%')
            ->orderBy('title')
            ->limit(10)
            ->get(['id_game', 'title']);
        return response()->json($games);
    }

    public function searchPage(Request $request)
    {
        $q = $request->query('q');
        $games = [];
        if ($q) {
            $games = \App\Models\Game::where('title', 'like', '%' . $q . '%')
                ->orderBy('title')
                ->get();
        }
        return view('search_results', compact('games', 'q'));
    }
}


