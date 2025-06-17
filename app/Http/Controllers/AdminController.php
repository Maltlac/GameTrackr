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

    public function suggestions()
    {
        $gameSuggestions = GameSuggestion::where('approved', false)->get();
        $platformSuggestions = PlatformSuggestion::where('approved', false)->get();
        return view('admin.suggestions', compact('gameSuggestions', 'platformSuggestions'));
    }
}
