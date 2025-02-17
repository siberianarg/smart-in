<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Client\MSClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class DeleteProductController extends Controller
{
    private MSClient $msClient;

    public function __construct(MSClient $msClient)
    {
        $this->msClient = $msClient;
    }

    public function deleteProduct($id)
    {
        $url ="entity/product/{$id}";
        $deleted = $this->msClient->delete($url);
        
        if (!$deleted) {
            return response()->json(['error' => 'Failed to delete task in MoySklad'], 500);
        }

        return response()->json(null, 204);
    }
}
