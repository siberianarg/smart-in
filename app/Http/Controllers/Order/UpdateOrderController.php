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
        // dd($id);
        $url = "entity/customerorder/{$id}?expand=positions.assortment";

        
        // Проверяем, что в запросе переданы товары
        if (!$request->has('positions')) {
            return response()->json(['error' => 'Отсутствуют товары в заказе'], 400);
        }

        // aормируем массив позиций (товаров) в заказе
        $positionsArray = $request->input('positions.rows', []); // Берем `rows`, а не `positions`
        $positions = array_map(function ($item) {
            return [
                'quantity' => $item['quantity'] ?? 0, // Добавляем `?? 0`, чтобы избежать ошибки
                'price' => ($item['price'] ?? 0), // Если `price` нет, ставим `0`
                'assortment' => [
                    'meta' => [
                        'href' => $item['assortment']['meta']['href'] ?? '', // Проверяем `meta.href`
                        'type' => 'product',
                        'mediaType' => 'application/json'
                    ]
                ]
            ];
        }, $positionsArray);

        // dd($positions);
        // dd($request->input('positions'));

        // Формируем данные для обновления
        $data = [
            'name' => $request->input('name'),
            'positions' => [
                'rows' => $positions // ✅ Передаем `rows`, а не `positions`
            ]
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
