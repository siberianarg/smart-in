<?php

namespace App\Http\Controllers\Product;

use App\Client\MSClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateProductController extends Controller
{
    private MSClient $msClient;

    public function __construct(MSClient $msClient)
    {
        $this->msClient = $msClient;
    }

    // Метод для обновления товара
    public function updateProduct(Request $request, $id)
    {

        // dd($request);
        $url ="entity/product/{$id}";
        $product = $this->msClient->get($url);
        
        if (!$product) {
            return response()->json(['error' => 'Товар не найден'], 404); 
        }
        // dd($product);
        
        $priceTypeMeta = $this->msClient->getRetailPriceTypeMeta(); // Получаем мета-данные о типе цены
        
        if (!$priceTypeMeta) {
            return response()->json(['error' => 'Ошибка: не удалось получить тип цены'], 500);
        }
        // dd($priceTypeMeta);
        
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
        // dd($data['name']);

        $response = $this->msClient->update($url, $data); 
        if (isset($response['id'])) {
            return response()->json($response, 200);
        } else {
            return response()->json(['error' => 'Ошибка при обновлении товара'], 500);
        }
    }
}
