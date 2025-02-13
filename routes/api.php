<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Task\StoreController;
use App\Http\Controllers\Task\IndexController;
use App\Http\Controllers\Task\UpdateController;
use App\Http\Controllers\Task\DeleteController;
use App\Http\Controllers\Task\ShowController;
use App\Http\Controllers\Task\TaskController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'tasks'], function () {
    Route::get('/', IndexController::class);
    Route::get('/{id}', ShowController::class);
    Route::post('/', StoreController::class);
    Route::put('/{id}', UpdateController::class);
    Route::delete('/{id}', DeleteController::class);
});
