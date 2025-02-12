<?php

namespace App\Http\Controllers\Product;

use App\Client\MoySkladClient;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\MainSettings;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $moySkladClient;

    public function __construct()
    {
        $settings = MainSettings::first();

        if (!$settings) {
            abort(404, 'Настройки для указанного accountId не найдены.');
        }

        $this->moySkladClient = new MoySkladClient($settings->ms_token, $settings->accountId);
    }

    public function index()
    {
        $products = $this->moySkladClient->getProducts('entity/product');
        if (empty($products)) {
            return response()->json(['message' => 'Нет товаров в системе МойСклад'], 200);
        }
        return response()->json($products);
    }

    public function getProductById($id)
    {
        $product = $this->moySkladClient->getProductById($id);
        return response()->json($product);
    }

    // Метод для обновления товара
    public function updateProduct(Request $request, $id)
    {
        $product = $this->moySkladClient->getProductById($id); // Получаем текущие данные о товаре

        if (!$product) {
            return response()->json(['error' => 'Товар не найден'], 404); // Если товар не найден, возвращаем ошибку
        }

        $priceTypeMeta = $this->moySkladClient->getRetailPriceTypeMeta(); // Получаем мета-данные о типе цены

        if (!$priceTypeMeta) {
            return response()->json(['error' => 'Ошибка: не удалось получить тип цены'], 500); // Возвращаем ошибку, если не удалось
        }

        // Обновляем данные товара
        $data = [
            'name' => $request->name ?? $product['name'], // Если имя не передано, оставляем старое
            'salePrices' => [
                [
                    'value' => ($request->price ?? ($product['salePrices'][0]['value'] / 100)) * 100, // Если цена не передана, оставляем старую
                    'priceType' => [
                        'meta' => [
                            'href' => $priceTypeMeta['href'], //'https://api.moysklad.ru/api/remap/1.2/entity/product/'.$id, - не срабатывало
                            'type' => 'pricetype',
                            'mediaType' => 'application/json'
                        ]
                    ]
                ]
            ],
        ];

        $response = $this->moySkladClient->updateProduct($id, $data); // Отправляем запрос на обновление товара

        if (isset($response['id'])) {
            return response()->json($response, 200); // Возвращаем обновленные данные о товаре
        } else {
            return response()->json(['error' => 'Ошибка при обновлении товара'], 500); // Возвращаем ошибку, если обновление не удалось
        }
    }
}
