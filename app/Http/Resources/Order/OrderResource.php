<?php

namespace App\Http\Resources\Order;

use App\Client\MSClient;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        $client = app(MSClient::class);

        // Кэшируем имя контрагента (10 минут)
        $agentName = Cache::remember("agent_{$this['agent']['meta']['href']}", 600, function () use ($client) {
            $agentData = $client->get($this['agent']['meta']['href']);
            return $agentData['name'] ?? '-';
        }); {
            return [
                'id' => $this['id'],
                'externalCode' => $this['externalCode'] ?? null,
                'name' => $this['name'],
                'sum' => isset($this['sum']) ? $this['sum'] / 100 : 0,
                'createdAt' => $this['created'] ?? null,
                'updatedAt' => $this['updated'] ?? null,
                'applicable' => $this['applicable'] ?? false,
                'customer' => $agentName,
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
}
