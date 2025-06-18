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
            'cover_url' => 'nullable|url',
            'release_date' => 'nullable|date',
            'genres' => 'sometimes|array',
            'genres.*' => 'integer|exists:genres,id_genre',
            'platform_links' => 'sometimes|array',
        ]);

        $genres = $validated['genres'] ?? [];
        $platformLinks = $validated['platform_links'] ?? [];
        unset($validated['genres'], $validated['platform_links']);

        $game = Game::create($validated);

        if (!empty($genres)) {
            $game->genres()->attach($genres);
        }

        if (!empty($platformLinks)) {
            foreach ($platformLinks as $platformId => $link) {
                if ($link !== null && $link !== '') {
                    $game->platforms()->attach($platformId, ['link' => $link]);
                }
            }
        }

        return response()->json($game->load(['genres', 'platforms']), 201);
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
}
