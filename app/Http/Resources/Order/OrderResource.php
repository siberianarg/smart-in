<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'externalCode' => $this['externalCode'] ?? null,
            'name' => $this['name'],
            'sum' => isset($this['sum']) ? $this['sum'] / 100 : 0,
            'createdAt' => $this['created'] ?? null,
            'updatedAt' => $this['updated'] ?? null,
            'applicable' => $this['applicable'] ?? false,
            'customer' => $this['agent']['name'] ?? '-',
            'salesChannel' => $this['salesChannel']['name'] ?? null,
            'project' => $this['project']['name'] ?? null,
            'positions' => collect($this['positions']['rows'] ?? [])->map(fn($pos) => [
                'id' => $pos['id'],
                'name' => $pos['assortment']['name'] ?? null,
                'quantity' => $pos['quantity'] ?? 1,
                'price' => isset($pos['price']) ? $pos['price'] / 100 : 0,
            ])->toArray(),
        ];
    }
}
