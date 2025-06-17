<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameSuggestionController;
use App\Http\Controllers\PlatformSuggestionController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/games', [GameController::class, 'index']);
Route::post('/games', [GameController::class, 'store']);
Route::get('/games/{id_game}', [GameController::class, 'show']);

Route::post('/suggestions/games', [GameSuggestionController::class, 'store']);
Route::post('/suggestions/platforms', [PlatformSuggestionController::class, 'store']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/suggestions/games/{suggestion}/approve', [GameSuggestionController::class, 'approve']);
    Route::post('/suggestions/platforms/{suggestion}/approve', [PlatformSuggestionController::class, 'approve']);
});
