<?php

namespace Modules\Cart\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Cart\Transformers\CartItemsResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'summary' =>$this->summary, 
          'cart_items' => CartItemsResource::collection($this->whenLoaded('items')),

        ];
    }
}
