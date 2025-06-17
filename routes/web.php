<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::view('/login', 'login')->name('login');
Route::view('/register', 'register')->name('register');
Route::view('/suggest-game', 'suggest_game')->name('suggest.game');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.panel');

// Fallback : toute autre route renvoie vers la home
Route::fallback(function () {
    return redirect('/home');
});

