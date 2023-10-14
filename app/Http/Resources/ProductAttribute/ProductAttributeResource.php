<?php

namespace App\Http\Resources\ProductAttribute;

use App\Http\Resources\ProductCategory\ProductCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttributeResource extends JsonResource
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
            'product_category' => new ProductCategoryResource($this->whenLoaded('product_category')),
            'product_variants_count' => $this->when(
                isset($this->product_variants_count),
                $this->product_variants_count
            ),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
