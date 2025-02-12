<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Client\MoySkladClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class DeleteProductController extends Controller
{
    private MoySkladClient $msClient;

    public function __construct(MoySkladClient $msClient)
    {
        $this->msClient = $msClient;
    }

    public function deleteProduct($id)
    {
        $deleted = $this->msClient->deleteProduct($id);
        // dd($deleted);
        if (!$deleted) {
            return response()->json(['error' => 'Failed to delete task in MoySklad'], 500);
        }

        return response()->json(null, 204);
    }
}
