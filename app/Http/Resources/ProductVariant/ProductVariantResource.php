<?php

namespace App\Http\Resources\ProductVariant;

use App\Http\Resources\ProductAttribute\ProductAttributeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
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
            'product_attribute' => new ProductAttributeResource($this->whenLoaded('product_attribute')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
