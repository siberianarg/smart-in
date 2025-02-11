<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => isset($this->salePrices[0]['value']) ? $this->salePrices[0]['value'] / 100 : 0, // Цена в рублях
            'barcode' => $this->barcodes[0]['ean13'] ?? null,
            'updated_at' => $this->updated,
        ];
    }
}
