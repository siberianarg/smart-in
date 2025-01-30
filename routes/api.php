<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Person\StoreController;
use App\Http\Controllers\Person\IndexController;
use App\Http\Controllers\Person\UpdateController;
use App\Http\Controllers\Person\DeleteController;
use App\Http\Controllers\Person\ShowController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'people'], function () {
    Route::post('/', StoreController::class);
    Route::get('/', IndexController::class);
    Route::get('/{person}', ShowController::class);
    Route::patch('/{person}', UpdateController::class);
    Route::delete('/{person}', DeleteController::class);
});
