<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'i']); 

// Auth::routes();
Route::get("/home/{is_vue_pade}", [HomeController::class, 'index'])->name('home')->where( 'is_vue_pade', '.*');

// Route::get("/persons", PersonController::class); 