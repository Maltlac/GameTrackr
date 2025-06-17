<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\GameSuggestion;
use App\Models\PlatformSuggestion;

class AdminController extends Controller
{
    public function index()
    {
        $games = Game::all();
        $genres = Genre::all();
        $platforms = Platform::all();
        $gameSuggestions = GameSuggestion::where('approved', false)->get();
        $platformSuggestions = PlatformSuggestion::where('approved', false)->get();
        return view('admin.panel', compact('games', 'genres', 'platforms', 'gameSuggestions', 'platformSuggestions'));
    }
}
