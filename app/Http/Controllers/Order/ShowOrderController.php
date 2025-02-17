<?php

namespace App\Http\Controllers\Order;

use App\Client\MSClient;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderDetailsResource;
use App\Models\MainSettings;
use Illuminate\Http\Request;

class ShowOrderController extends Controller
{
    private MSClient $msClient;

    public function __construct(MSClient $msClient)
    {
        $this->msClient = $msClient;
    }

    public function show($id)
    {
        $url = "entity/customerorder/{$id}";
        $order = $this->msClient->get($url);
        return response()->json(new OrderDetailsResource($order));
    }
}
