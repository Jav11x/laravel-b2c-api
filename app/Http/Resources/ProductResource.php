<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
            'active' => (bool)$this->active,
            'category' => [
                'id' => $this->category?->id,
                'name' => $this->category?->name,
            ],
            'images' => $this->images->pluck('url'),
            'created_at' => $this->created_at,
        ];
    }
}
