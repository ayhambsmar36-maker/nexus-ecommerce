<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "product_name"=>$this->product_name,
            "sku"=>$this->variant_sku,
            "price"=>$this->price,
            "quantity"=>$this->quantity,
            "sub_total"=>$this->sub_total,
        ];
    }
}
