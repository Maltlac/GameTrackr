<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::view('/login', 'login')->name('login');
Route::view('/register', 'register')->name('register');
Route::view('/suggest-game', 'suggest_game')->name('suggest.game');
Route::get('/suggest-platform/{game?}', function ($game = null) {
    return view('suggest_platform', ['game' => $game]);
})->name('suggest.platform');

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/admin/games', [AdminController::class, 'gererJeux'])->name('games.show');
    Route::get('/games/create', [AdminController::class, 'createGame'])->name('games.create');
    Route::delete('/games/{game}', [AdminController::class, 'destroyGame'])->name('games.destroy');
    Route::post('/gamesuptate/{game}', [AdminController::class, 'updateGame'])->name('games.edit');
    Route::get('/games/{game}/edit', [AdminController::class, 'editGame'])->name('games.edit');


    Route::get('/platforms/create', [AdminController::class, 'createPlatform'])->name('platforms.create');
    Route::get('/genres/create', [AdminController::class, 'createGenre'])->name('genres.create');
    Route::get('/suggestions', [AdminController::class, 'suggestions'])->name('suggestions');
});

// Page détail jeu
Route::get('/games/{id}', [\App\Http\Controllers\GameController::class, 'showDetail'])->name('games.detail');

// Fallback : toute autre route renvoie vers la home
Route::fallback(function () {
    return redirect('/home');
});

