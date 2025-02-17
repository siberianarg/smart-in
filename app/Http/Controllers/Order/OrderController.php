<?php

namespace App\Http\Controllers\Order;

use App\Client\MSClient;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Models\MainSettings;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
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

    public function index(): JsonResponse
    {
        try {
            $orders = $this->msClient->get('entity/customerorder');
            if (empty($orders['rows'])) {
                return response()->json(['message' => 'Нет заказов в системе МойСклад'], 200);
            }

            return response()->json(OrderResource::collection($orders['rows']));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка получения данных из МойСклад', 'message' => $e->getMessage()], 500);
        }
    }
}
