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
                'positions' => isset($this['positions']['meta']['href'])
                    ? $client->get($this['positions']['meta']['href'])['rows']
                    : [],
            ];
    }
}
