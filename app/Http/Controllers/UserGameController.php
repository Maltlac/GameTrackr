<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserGameController extends Controller
{
    public function addToMyGames(Request $request)
    {
        $user = $request->user();
        $gameId = $request->input('id_game');
        if (!$gameId) {
            return response()->json(['message' => 'ID jeu manquant'], 400);
        }
        // Vérifie si déjà possédé
        if ($user->games()->where('games.id_game', $gameId)->exists()) {
            return response()->json(['message' => 'Jeu déjà dans votre bibliothèque'], 409);
        }
        $user->games()->attach($gameId);
        return response()->json(['success' => true]);
    }

    public function isOwned(Request $request, $id_game)
    {
        $user = $request->user();
        $owned = $user->games()->where('games.id_game', $id_game)->exists();
        return response()->json(['owned' => $owned]);
    }

    public function myGames(Request $request)
    {
        $user = $request->user();
        $games = $user->games()->withPivot('status', 'playtime', 'progress')->get();
        $totalPlaytime = $games->sum(function($g) { return $g->pivot->playtime ?? 0; });
        return view('my_games', compact('games', 'totalPlaytime'));
    }

    public function getPivot(Request $request, $id_game)
    {
        $user = $request->user();
        $pivot = $user->games()->where('games.id_game', $id_game)->first()?->pivot;
        return response()->json($pivot);
    }

    public function updatePivot(Request $request, $id_game)
    {
        $user = $request->user();
        $data = $request->only(['playtime', 'progress']);
        $user->games()->updateExistingPivot($id_game, $data);
        return response()->json(['success' => true]);
    }
}
