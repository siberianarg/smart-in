<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Client\MSClient;

class OrderDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        $client = app(MSClient::class);
        $agentData = isset($this['agent']['meta']['href'])
            ? $client->get($this['agent']['meta']['href'])
            : null;

        // // Получаем позиции (товары)
        $positions = isset($this['positions']['meta']['href'])
            ? $client->get($this['positions']['meta']['href'])['rows']
            : [];

        $positions = array_map(function ($position) use ($client) {
            $productData = isset($position['assortment']['meta']['href'])
                ? $client->get($position['assortment']['meta']['href']) // Запрос к API
                : null;

            return [
                'id' => $position['id'],
                'name' => $productData['name'] ?? 'Без названия',
                'quantity' => $position['quantity'],
                'price' => $position['price'],
                // НЕ БЫЛО assortmentHref
                'assortmentHref' => $position['assortment']['meta']['href'] ?? null, // Чтобы не ломался фронт
            ];
        }, $positions);

        return [
            'id' => $this['id'],
            'externalCode' => $this['externalCode'] ?? null,
            'name' => $this['name'],
            'sum' => isset($this['sum']) ? $this['sum'] / 100 : 0,
            'createdAt' => $this['created'] ?? null,
            'updatedAt' => $this['updated'] ?? null,
            'applicable' => $this['applicable'] ?? false,
            //rонтрагент (agent)
            'customer' => $agentData['name'] ?? 'Розничный покупатель',
            'organization' => isset($this['organization']['meta']['href'])
                ? $client->get($this['organization']['meta']['href'])['name'] ?? null
                : null,
            'currency' => isset($this['rate']['currency']['meta']['href'])
                ? $client->get($this['rate']['currency']['meta']['href'])['name'] ?? 'Не указана'
                : 'Не указана',
            'deliveryAddress' => $this['deliveryAddress'] ?? 'Адрес не указан',
            //позиции (товары в заказе)
            'positions' => $positions
        ];
    }
}