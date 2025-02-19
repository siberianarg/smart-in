<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Client\MSClient;
use Illuminate\Http\Request;

class StoreOrderController extends Controller
{
    private MSClient $msClient;

    public function __construct(MSClient $msClient)
    {
        $this->msClient = $msClient;
    }

    public function addOrder(Request $request){}
}