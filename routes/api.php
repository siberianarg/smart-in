<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Task\StoreController;
use App\Http\Controllers\Task\IndexController;
use App\Http\Controllers\Task\UpdateController;
use App\Http\Controllers\Task\DeleteController;
use App\Http\Controllers\Task\ShowController;
use App\Http\Controllers\Product\ProductController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'tasks'], function () {
    Route::get('/', IndexController::class);         
    Route::get('/{task}', ShowController::class);    
    Route::post('/', StoreController::class);        
    Route::post('/{task}', UpdateController::class); // Обновление задачи (лучше использовать PUT)
    Route::delete('/{task}', DeleteController::class); 
});

Route::group(['prefix' => 'products'], function () {
    Route::get('/{accountId}', [ProductController::class, 'index']);         
    Route::post('/', [ProductController::class, 'store']);         
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']); 
    Route::get('/{id}', [ProductController::class, 'show']);       
});
