<?php

namespace App\Http\Controllers\Product;

use App\Client\MoySkladProductClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    private MoySkladProductClient $moySkladProductClient;

    public function __construct()
    {
        $this->moySkladProductClient = new MoySkladProductClient(null, 1); // Заменить '1' на актуальный ID настроек
    }

    // Получение списка товаров
    public function index()
    {

        $products = $this->moySkladProductClient->getProducts();
        // dd($products);
        // Проверим, что массив rows существует и не пустой
        if (isset($products['rows']) && count($products['rows']) > 0) {
            return response()->json($products['rows']);
        }

        return response()->json(['message' => 'Нет товаров в системе МойСклад'], 200);
    }

    // Создание нового товара
    public function store(Request $request)
    {
        $productData = $request->all();
        $createdProduct = $this->moySkladProductClient->createProduct($productData);
        return response()->json($createdProduct);
    }

    // Обновление товара
    public function update($id, Request $request)
    {
        $productData = $request->all();
        $updatedProduct = $this->moySkladProductClient->updateProduct($id, $productData);
        return response()->json($updatedProduct);
    }

    // Удаление товара
    public function destroy($id)
    {
        $deleted = $this->moySkladProductClient->deleteProduct($id);
        return response()->json(['success' => $deleted]);
    }

    // Получение товара по ID
    public function show($id)
    {
        $product = $this->moySkladProductClient->getProductById($id);
        return response()->json($product);
    }
}
