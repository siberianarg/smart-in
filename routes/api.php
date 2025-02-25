<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Order\DataController;
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
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\ShowOrderController;
use App\Http\Controllers\Order\StoreOrderController;
use App\Http\Controllers\Order\UpdateOrderController;
use App\Http\Controllers\Order\DeleteOrderController;


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
    Route::get('/', [ProductController::class, 'indexProduct']);  
    Route::get('/{id}', [ShowProductController::class, 'showProduct']);     
    Route::post('/', [StoreProductController::class, 'storeProduct']);       
    Route::put('/{id}', [UpdateProductController::class, 'updateProduct']);
    Route::delete('/{id}', [DeleteProductController::class, 'deleteProduct']);
});

Route::prefix('orders/')->group(function () {
    Route::get('/', [OrderController::class, 'index']);  
    Route::get('/{id}', [ShowOrderController::class, 'show']); 
    Route::post('/', [StoreOrderController::class, 'store']); 
    Route::put('/{id}', [UpdateOrderController::class, 'update']); 
    Route::delete('/{id}', [DeleteOrderController::class, 'delete']); 
});

Route::get('/organizations', [DataController::class, 'getOrganizations']);
Route::get('/sales-channels', [DataController::class, 'getSalesChannels']);
Route::get('/projects', [DataController::class, 'getProjects']);
Route::get('/сounterparties', [DataController::class, 'getCounterparties']);

// // Маршрут для получения текущего accountId
// Route::get('/current-account', [ProductController::class, 'getCurrentAccountId']);