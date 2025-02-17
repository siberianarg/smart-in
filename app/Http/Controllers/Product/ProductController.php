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

    public function getProduct()
    {
        $products = $this->moySkladClient->get('entity/product?limit=20'); //?limit=20 - опставил лимит, необходимо ПОПРАИТЬ
        
        if (empty($products['rows'])) {
            return response()->json(['message' => 'Нет товаров в системе МойСклад'], 200);
        }
        return response()->json($products['rows']);
    }
}


