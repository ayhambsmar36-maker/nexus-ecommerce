<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "customer_id"=>$this->customer_id,
            "total"=>$this->total,
            "method_payment"=>$this->method_payment,
            "notes"=>$this->notes,
            "status"=>$this->status,
            
            "items"=>$this->whenLoaded('items', function() {
                return OrderItemsResource::collection($this->items);
            }),
        ];
    }
}
