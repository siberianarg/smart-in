<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Client\MSClient;
use App\Http\Requests\Order\OrderRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StoreOrderController extends Controller
{
    private MSClient $msClient;

    public function __construct(MSClient $msClient)
    {
        $this->msClient = $msClient;
    }

    public function getProducts(): JsonResponse
    {
        $products = Cache::remember('ms_products', 600, function () {
            return $this->msClient->get('entity/product')['rows'] ?? [];
        });

        return response()->json($products);
    }

    //список каналов продаж
    public function getSalesChannels(): JsonResponse
    {
        $salesChannels = Cache::remember('ms_sales_channels', 600, function () {
            return $this->msClient->get('entity/saleschannel')['rows'] ?? [];
        });

        return response()->json($salesChannels);
    }

    public function getProjects(): JsonResponse
    {
        $projects = Cache::remember('ms_projects', 600, function () {
            return $this->msClient->get('entity/project')['rows'] ?? [];
        });

        return response()->json($projects);
    }
    
    public function store(OrderRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            // получаем ID розничного покупателя
            // $counterpartyId = $this->msClient->getRetailCustomerId();
            // if (!$counterpartyId) {
            //     return response()->json(['error' => 'Не удалось получить ID розничного покупателя'], 500);
            // }

            // формируем данные заказа
            $orderData = [
                'name' => $validated['name'] ?? 'Заказ №' . time(),
                'moment' => !empty($validated['moment'])
                    ? date('Y-m-d H:i:s', strtotime($validated['moment']))
                    : now()->format('Y-m-d H:i:s'),

                'organization' => [
                    'meta' => [
                        'href' => $validated['organization']['meta']['href'], //$counterpartyId
                        'type' => 'organization',
                        'mediaType' => 'application/json',
                    ]
                ],

                'agent' => [
                    'meta' => [
                        'href' => $validated['agent']['meta']['href'],
                        'type' => 'counterparty',
                        'mediaType' => 'application/json',
                    ]
                ],

                'positions' => array_map(fn($item) => [
                    'quantity' => $item['quantity'],
                    'price' => intval($item['price'] * 100),
                    'assortment' => [
                        'meta' => [
                            'href' => $item['assortment']['meta']['href'],
                            'type' => 'product',
                            'mediaType' => 'application/json',
                        ]
                    ]
                ], $validated['positions']),
            ];

            $response = $this->msClient->create($orderData, 'entity/customerorder');
            return response()->json($response, 201);
        } catch (\Exception $e) {
            dd('Ошибка при создании заказа:', $e->getMessage());
        }
    }
}
