<?php

namespace App\Http\Controllers\Order;

use App\Client\MSClient;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderDetailsResource;
use Illuminate\Http\Request;

class UpdateOrderController extends Controller
{
    private MSClient $msClient;

    public function __construct(MSClient $msClient)
    {
        $this->msClient = $msClient;
    }

    // Обновление заказа (изменение товаров)
    public function update(Request $request, $id)
    {
        $url = "entity/customerorder/{$id}?expand=positions.assortment";

        // Формируем массив позиций (товаров) в заказе
        $positions = array_map(function ($item) {
            return [
                'quantity' => $item['quantity'],
                'price' => $item['price'] * 100, // Цена в копейках
                'assortment' => [
                    'meta' => [
                        'href' => $item['assortmentHref'],
                        'type' => 'product',
                        'mediaType' => 'application/json'
                    ]
                ]
            ];
        }, $request->input('positions', []));

        // Формируем данные для обновления
        $data = [
            'name' => $request->input('name'),
            // 'sum' => $request->input('sum') * 100, // Переводим в копейки
            // 'agent' => [
            //     'meta' => [
            //         'href' => $request->input('customerHref'),
            //         'type' => 'counterparty',
            //         'mediaType' => 'application/json'
            //     ]
            // ],
            // 'positions' => [
            //     'rows' => $positions
            // ]
        ];
        // dd($data);

        $response = $this->msClient->update($url, $data);

        if (isset($response['id'])) {
            return response()->json(new OrderDetailsResource($response), 200);
        } else {
            return response()->json(['error' => 'Ошибка при обновлении заказа'], 500);
        }
    }
}

