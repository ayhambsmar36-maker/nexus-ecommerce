<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Transformers\Category\CategoryResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'compare_price' => $this->compare_price,
            'status' => $this->status,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'is_featured' => $this->is_featured,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            
        ];
    }
}
