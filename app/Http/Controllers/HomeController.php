<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class HomeController extends Controller
{
    public function index()
    {
        $games = Game::orderByDesc('created_at')->take(5)->get();
        return view('home', compact('games'));
    }
}
