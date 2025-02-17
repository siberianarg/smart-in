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
            'customer' => $agentData['name'] ?? 'Розничный покупатель',
            'positions' => isset($this['positions']['meta']['href'])
                ? $client->get($this['positions']['meta']['href'])['rows']
                : [],
        ];
    }
}
