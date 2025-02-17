<?php

namespace App\Http\Controllers\Product;

use App\Client\MoySkladClient;
use App\Http\Controllers\Controller;
use App\Models\MainSettings;
use Illuminate\Http\Request;

class ShowProductController extends Controller
{
    private MoySkladClient $moySkladClient;

    public function __construct(MoySkladClient $moySkladClient)
    {
        $this->moySkladClient = $moySkladClient;
    }

    public function getProductById($id)
    {
        $url = "entity/product/{$id}";
        $product = $this->moySkladClient->get($url);
        return response()->json($product);
    }
}
