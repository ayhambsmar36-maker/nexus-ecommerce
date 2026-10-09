<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Transformers\Category\CategoryResource;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'product' => new ProductResource($this->whenLoaded('product')),
            'categories' => CategoryResource::collection($this->whenLoaded('product.categories')),
            'variants' => $this->whenLoaded('attributeValues', function () {
                return [
                    'id' => $this->id,
                    'sku' => $this->sku,
                    'price' => $this->price,
                    'compare_price' => $this->compare_price,
                    'status' => $this->status,
                    'inventory' => $this->whenLoaded('inventory', function () {
                        return [
                            'quantity' => $this->inventory?->quantity ?? 0,
                            'in_stock' => $this->inventory?->in_stock ?? false,
                        ];
                    }),
                ];
            }),
            'attribute_values' => $this->whenLoaded('attributeValues', function () {
                return [
                    'id' => $this->attributeValues->pluck('id'),
                    'value' => $this->attributeValues->pluck('value'),
                    'name' => $this->whenLoaded('attributeValues.attribute', function () {
                        return $this->attributeValues->pluck('productAttribute.name');
                    }),
                ];
            }),
        ];
    }
}
