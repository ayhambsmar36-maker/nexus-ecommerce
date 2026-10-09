<?php

namespace Modules\Catalog\Transformers\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'slug' => $this->slug,
            'children' => CategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}
