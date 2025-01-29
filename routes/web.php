<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'i']);

// Auth::routes();
Route::get("/{is_vue_pade}", [HomeController::class, 'index'])->name('home')->where('is_vue_pade', '.*');
