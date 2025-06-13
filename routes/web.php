<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::view('/login', 'login')->name('login');
Route::view('/register', 'register')->name('register');

// Fallback : toute autre route renvoie vers la home
Route::fallback(function () {
    return redirect('/home');
});

