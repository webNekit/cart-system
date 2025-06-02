<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::get('/register', [\App\Http\Controllers\RegisterController::class, 'show'])->name('register');
Route::post('/register', [\App\Http\Controllers\RegisterController::class, 'store']);
