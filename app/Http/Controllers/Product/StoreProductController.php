<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Client\MoySkladClient;
use Illuminate\Http\Request;

class StoreProductController extends Controller
{
    private MoySkladClient $moySkladClient;

    public function __construct(MoySkladClient $moySkladClient)
    {
        $this->moySkladClient = $moySkladClient;
    }

    public function addProduct(Request $request)
    {
        $uniqueCode = $this->generateUniqueProductCode();
        $priceTypeMeta = $this->moySkladClient->getRetailPriceTypeMeta();


        if (!$priceTypeMeta) {
            return response()->json(['error' => 'Ошибка: не удалось получить тип цены'], 500);
        }

        $data = [
            'code' => $uniqueCode,
            'name' => $request->name,
            'salePrices' => [
                [
                    'value' => $request->price * 100,
                    'priceType' => [
                        'meta' => [
                            'href' => $priceTypeMeta['href'],
                            'type' => 'pricetype',
                            'mediaType' => 'application/json'
                        ]
                    ]
                ]
            ],
        ];

        $response = $this->moySkladClient->create($data, 'entity/product');
        if (isset($response['id'])) {
            return response()->json($response, 201);
        } else {
            return response()->json(['error' => 'Ошибка при создании товара'], 500);
        }
    }

    private function generateUniqueProductCode()
    {
        return 'PRD-' . strtoupper(uniqid());
    }
}