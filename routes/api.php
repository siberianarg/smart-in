<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Task\StoreController;
use App\Http\Controllers\Task\IndexController;
use App\Http\Controllers\Task\UpdateController;
use App\Http\Controllers\Task\DeleteController;
use App\Http\Controllers\Task\ShowController;
use App\Http\Controllers\Task\ProductController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'tasks'], function () {
    Route::get('/', IndexController::class);         // Получение списка задач
    Route::get('/{task}', ShowController::class);    // Получение задачи по ID
    Route::post('/', StoreController::class);        // Создание новой задачи
    Route::post('/{task}', UpdateController::class); // Обновление задачи (лучше использовать PUT)
    Route::delete('/{task}', DeleteController::class); // Удаление задачи
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);          // Список товаров
    Route::post('/', [ProductController::class, 'store']);         // Создание товара
    Route::put('/{id}', [ProductController::class, 'update']);     // Обновление товара
    Route::delete('/{id}', [ProductController::class, 'destroy']); // Удаление товара
    Route::get('/{id}', [ProductController::class, 'show']);       // Получение товара по ID
});
