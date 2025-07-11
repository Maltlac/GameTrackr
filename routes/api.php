<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameSuggestionController;
use App\Http\Controllers\PlatformSuggestionController;

use App\Http\Controllers\PlatformController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ScrapController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/games/autocomplete', [\App\Http\Controllers\GameController::class, 'autocomplete']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/users/me/games', [\App\Http\Controllers\UserGameController::class, 'addToMyGames']);
    Route::get('/users/me/games/{id_game}/owned', [\App\Http\Controllers\UserGameController::class, 'isOwned']);
    Route::get('/users/me/games/{id_game}/pivot', [\App\Http\Controllers\UserGameController::class, 'getPivot']);
    Route::put('/users/me/games/{id_game}/pivot', [\App\Http\Controllers\UserGameController::class, 'updatePivot']);
});

Route::get('/games', [GameController::class, 'index']);

Route::get('/games/{id_game}', [GameController::class, 'show']);




Route::middleware(['auth:sanctum', 'admin'])->group(function () {


    Route::post('/games', [GameController::class, 'store']);
    Route::put('/games/{game}', [GameController::class, 'update']);
    Route::delete('/games/{game}', [GameController::class, 'destroy']);

    Route::post('/platforms', [PlatformController::class, 'store']);
    Route::put('/platforms/{platform}', [PlatformController::class, 'update']);
    Route::delete('/platforms/{platform}', [PlatformController::class, 'destroy']);

    Route::post('/genres', [GenreController::class, 'store']);
    Route::put('/genres/{genre}', [GenreController::class, 'update']);
    Route::delete('/genres/{genre}', [GenreController::class, 'destroy']);

});

Route::get('/scrap-price', [ScrapController::class, 'steamPrice']);
