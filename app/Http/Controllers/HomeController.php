<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $games = \App\Models\Game::orderBy('title')->paginate(12);
        return view('home', compact('games'));
    }
}
