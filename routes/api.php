<?php

use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\ShowOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Task\StoreController;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\Task\UpdateController;
use App\Http\Controllers\Task\DeleteController;
use App\Http\Controllers\Task\ShowController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\DeleteProductController;
use App\Http\Controllers\Product\ShowProductController;
use App\Http\Controllers\Product\StoreProductController;
use App\Http\Controllers\Product\UpdateProductController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'tasks'], function () {
    Route::get('/', TaskController::class);
    Route::get('/{id}', ShowController::class);
    Route::post('/', StoreController::class);
    Route::put('/{id}', UpdateController::class);
    Route::delete('/{id}', DeleteController::class);
});

Route::prefix('products/')->group(function () {
    Route::get('/', [ProductController::class, 'getProduct']);  
    Route::get('/{id}', [ShowProductController::class, 'getProductById']);     
    Route::post('/', [StoreProductController::class, 'addProduct']);       
    Route::put('/{id}', [UpdateProductController::class, 'updateProduct']);
    Route::delete('/{id}', [DeleteProductController::class, 'deleteProduct']);
});

Route::prefix('orders/')->group(function () {
    Route::get('/', [OrderController::class, 'index']);  
    Route::get('/{id}', [ShowOrderController::class, 'show']);  
});

// // Маршрут для получения текущего accountId
// Route::get('/current-account', [ProductController::class, 'getCurrentAccountId']);