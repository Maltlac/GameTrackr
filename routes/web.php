<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::view('/login', 'login')->name('login');
Route::view('/register', 'register')->name('register');

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
});

// Page détail jeu
Route::get('/games/{id}', [\App\Http\Controllers\GameController::class, 'showDetail'])->name('games.detail');

// Routes pour les utilisateurs connectés
Route::middleware(['auth'])->group(function () {
    Route::get('/my-games', [\App\Http\Controllers\UserGameController::class, 'myGames'])->name('my.games');
});

Route::get('/search', [\App\Http\Controllers\GameController::class, 'searchPage'])->name('search.page');

// Fallback : toute autre route renvoie vers la home
Route::fallback(function () {
    return redirect('/home');
});

