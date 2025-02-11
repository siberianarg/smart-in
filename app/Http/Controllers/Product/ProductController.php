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
        $products = $this->moySkladClient->getProducts();
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
}
