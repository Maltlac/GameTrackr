<?php

namespace App\Http\Controllers;

use App\Models\Game;
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
            'percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $game = Game::create($validated);

        return response()->json($game, 201);
    }
}
