<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;

Route::get('/', function () {
    return view('app');
}); 

// Auth::routes();
Route::get("/home", [App\Http\Controllers\HomeController::class, 'index']) -> name('home');

// Route::get("/persons", PersonController::class); 