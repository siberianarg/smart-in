<?php

namespace App\Http\Controllers\Product;

use App\Client\MSClient;
use App\Http\Controllers\Controller;
use App\Models\MainSettings;
use Illuminate\Http\Request;

class ShowProductController extends Controller
{
    private MSClient $msClient;

    public function __construct(MSClient $msClient)
    {
        $this->msClient = $msClient;
    }

    public function getProductById($id)
    {
        $url = "entity/product/{$id}";
        $product = $this->msClient->get($url);
        return response()->json($product);
    }
}
