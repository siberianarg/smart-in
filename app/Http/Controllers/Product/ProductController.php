<?php

namespace App\Http\Controllers\Product;

use App\Client\MSClient;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\MainSettings;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $msClient;

    public function __construct()
    {
        $settings = MainSettings::first();

        if (!$settings) {
            abort(404, 'Настройки для указанного accountId не найдены.');
        }

        $this->msClient = new MSClient($settings->ms_token, $settings->accountId);
    }

    public function indexProduct()
    {
        $products = $this->msClient->get('entity/product?limit=100'); //?limit100 - опставил лимит, необходимо ПОПРАИТЬ
        
        if (empty($products['rows'])) {
            return response()->json(['message' => 'Нет товаров в системе МойСклад'], 200);
        }
        return response()->json($products['rows']);
    }
}


