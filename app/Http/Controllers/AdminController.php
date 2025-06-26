<?php
namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Platform;
use App\Models\GameSuggestion;
use App\Models\PlatformSuggestion;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function createGame()
    {
        $genres = Genre::all();
        $platforms = Platform::all();
        return view('admin.game_form', compact('genres', 'platforms'));
    }

    public function createPlatform()
    {
        return view('admin.platform_form');
    }

    public function createGenre()
    {
        return view('admin.genre_form');
    }

    public function gererJeux(Request $request)
    {
        $items = $request->input('pagination', 10);
        $query = \App\Models\Game::query();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%$search%");
        }

        $games = $query->orderByDesc('created_at')->paginate($items);

        return view('admin.gererJeux', compact('games', 'items'));
    }

    public function destroyGame($id)
    {
        $game = \App\Models\Game::findOrFail($id);
        $game->delete();

        return redirect()->route('admin.games.show')->with('success', 'Jeu supprimé avec succès.');
    }

    public function editGame($id)
    {
        $game = \App\Models\Game::with(['genres', 'platforms'])->findOrFail($id);
        $genres = \App\Models\Genre::all();
        $platforms = \App\Models\Platform::all();
        return view('admin.game_form', compact('game', 'genres', 'platforms'));
    }
}
