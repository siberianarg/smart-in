<?php

namespace App\Http\Controllers\Product;

use App\Client\MoySkladProductClient;
use App\Client\MoySkladClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MainSettings;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    private MoySkladClient $moySkladClient;

    public function __construct()
    {
        $settings = MainSettings::first();
        // dd($settings);

        if (!$settings || !$settings->ms_token || !$settings->accountId) {
            throw new \Exception('Настройки МойСклад не найдены. Пожалуйста, установите токен и accountId.');
        }

        $this->moySkladClient = new MoySkladClient($settings->ms_token, $settings->accountId);
        // $this->moySkladClient = new MoySkladClient(null, $accountId); 
    }

    // Получение списка товаров
    public function index(Request $request, $accountId)
    {

        // Инициализируем MoySkladClient с использованием accountId
        $this->moySkladClient = new MoySkladClient(null, $accountId);

        // Получаем список продуктов
        $products = $this->moySkladClient->getProducts();

        // Проверка на наличие товаров
        $rows = $products['rows'] ?? [];

        if (empty($rows)) {
            return response()->json(['error' => 'No products found in MoySklad'], 400);
        }

        // Возвращаем данные в формате JSON
        return response()->json($rows);
    }

    // Создание нового товара
    public function store(Request $request)
    {
        $productData = $request->all();
        $createdProduct = $this->moySkladClient->createProduct($productData);
        return response()->json($createdProduct);
    }

    // Обновление товара
    public function update($id, Request $request)
    {
        $productData = $request->all();
        $updatedProduct = $this->moySkladClient->updateProduct($id, $productData);
        return response()->json($updatedProduct);
    }

    // Удаление товара
    public function destroy($id)
    {
        $deleted = $this->moySkladClient->deleteProduct($id);
        return response()->json(['success' => $deleted]);
    }

    // Получение товара по ID
    public function show($id)
    {
        $product = $this->moySkladClient->getProductById($id);
        return response()->json($product);
    }
}
