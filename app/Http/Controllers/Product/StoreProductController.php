<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Client\MSClient;
use Illuminate\Http\Request;

class StoreProductController extends Controller
{
    private MSClient $msClient;

    public function __construct(MSClient $msClient)
    {
        $this->msClient = $msClient;
    }

    public function addProduct(Request $request)
    {
        $uniqueCode = $this->generateUniqueProductCode();
        $priceTypeMeta = $this->msClient->getRetailPriceTypeMeta();


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

        $response = $this->msClient->create($data, 'entity/product');
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