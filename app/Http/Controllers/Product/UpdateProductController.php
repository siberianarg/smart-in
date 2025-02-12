<?php

namespace App\Http\Controllers\Product;

use App\Client\MoySkladClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateProductController extends Controller
{
    private MoySkladClient $moySkladClient;

    public function __construct(MoySkladClient $moySkladClient)
    {
        $this->moySkladClient = $moySkladClient;
    }

    // Метод для обновления товара
    public function updateProduct(Request $request, $id)
    {
        $url ="entity/product/{$id}";
        $product = $this->moySkladClient->getProductById($url);
        
        if (!$product) {
            return response()->json(['error' => 'Товар не найден'], 404); 
        }
        
        $priceTypeMeta = $this->moySkladClient->getRetailPriceTypeMeta(); // Получаем мета-данные о типе цены
        
        if (!$priceTypeMeta) {
            return response()->json(['error' => 'Ошибка: не удалось получить тип цены'], 500);
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

        $response = $this->moySkladClient->updateProduct($url, $data); 
        if (isset($response['id'])) {
            return response()->json($response, 200);
        } else {
            return response()->json(['error' => 'Ошибка при обновлении товара'], 500);
        }
    }
}
