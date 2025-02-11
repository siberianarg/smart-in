<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Task\StoreController;
use App\Http\Controllers\Task\IndexController;
use App\Http\Controllers\Task\UpdateController;
use App\Http\Controllers\Task\DeleteController;
use App\Http\Controllers\Task\ShowController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\DeleteProductController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'tasks'], function () {
    Route::get('/', IndexController::class);         
    Route::get('/id}', ShowController::class);    
    Route::post('/', StoreController::class);        
    Route::post('/{id}', UpdateController::class); // Обновление задачи (лучше использовать PUT)
    Route::delete('/{id}', DeleteController::class); 
});

Route::prefix('products/')->group(function () {
    Route::get('/', [ProductController::class, 'index']);  
    Route::get('/{id}', [ProductController::class, 'getProductById']);     
    Route::post('/', [ProductController::class, 'createProduct']);        
    Route::put('/{id}', [ProductController::class, 'updateProduct']);
    Route::delete('/{id}', DeleteProductController::class);
});

// // Маршрут для получения текущего accountId
// Route::get('/current-account', [ProductController::class, 'getCurrentAccountId']);