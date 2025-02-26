<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Client\MSClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class DeleteOrderController extends Controller
{
    private MSClient $msClient;

    public function __construct(MSClient $msClient)
    {
        $this->msClient = $msClient;
    }

    public function delete($id)
    {
        $url ="entity/customerorder/{$id}";
        $deleted = $this->msClient->delete($url);
        
        if (!$deleted) {
            return response()->json(['error' => 'Failed to delete order in MoySklad'], 500);
        }

        return response()->json(null, 204);
    }
}
