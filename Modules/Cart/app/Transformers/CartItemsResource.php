<?php

namespace Modules\Cart\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

           'quantity' => $this->quantity,
           'product_variant' =>$this->whenloaded('productVariant', function () {
                return [
                    'id' => $this->productVariant?->id,
                    'price' => $this->productVariant?->price,
                    'sku' => $this->productVariant?->sku,
                    
            ];
            })
        ];
    }
}
