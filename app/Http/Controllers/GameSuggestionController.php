<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameSuggestion;

class GameSuggestionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'link' => 'nullable|string',
        ]);
        $validated['user_id'] = $request->user()?->id_user;
        $suggestion = GameSuggestion::create($validated);
        return response()->json($suggestion, 201);
    }

    public function approve(GameSuggestion $suggestion)
    {
        $suggestion->approved = true;
        $suggestion->save();
        return response()->json(['message' => 'Approved']);
    }
}
