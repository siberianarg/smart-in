<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Task\StoreController;
use App\Http\Controllers\Task\IndexController;
use App\Http\Controllers\Task\UpdateController;
use App\Http\Controllers\Task\DeleteController;
use App\Http\Controllers\Task\ShowController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'tasks'], function () {
    Route::post('/', StoreController::class);
    Route::get('/', IndexController::class);
    Route::get('/{task}', ShowController::class);
    Route::patch('/{task}', UpdateController::class);
    Route::delete('/{task}', DeleteController::class);
});
