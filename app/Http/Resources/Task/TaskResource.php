<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            // атрибутивный состав
            'id' => $this->id,
            'description' => $this->description,
            'is_completed' => $this->is_completed,
            'created_at' => $this->created_at, 
        ];
    }
}