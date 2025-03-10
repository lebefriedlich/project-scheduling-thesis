<?php

use App\Http\Controllers\Admin\LectureController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::resource('locations', LocationController::class);
Route::resource('lecture', LectureController::class);

// Redirect user ke Google untuk login
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');

// Handle callback dari Google setelah login
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

