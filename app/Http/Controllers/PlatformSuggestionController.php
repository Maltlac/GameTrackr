<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlatformSuggestion;

class PlatformSuggestionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|string',
            'link' => 'nullable|string',
            'id_game' => 'nullable|integer',
        ]);
        $validated['user_id'] = $request->user()?->id_user;
        $suggestion = PlatformSuggestion::create($validated);
        return response()->json($suggestion, 201);
    }

    public function approve(PlatformSuggestion $suggestion)
    {
        $suggestion->approved = true;
        $suggestion->save();
        return response()->json(['message' => 'Approved']);
    }
}
