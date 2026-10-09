<?php

namespace Modules\Catalog\Services\Product;

use Illuminate\Support\Facades\Cache;
use Modules\Catalog\Models\Product;
use Modules\Catalog\Models\ProductAttribute;
use Modules\Catalog\Models\ProductVariant;

class ProductQueryService
{
    public function handle() {}

    public static function getProductAttributeValues(Product $product)
    {

        return $product->attributeValues->groupBy('product_attribute_id')->map(function ($values) {
            return $values->pluck('id');

        })->toArray();

    }


    public function getAttributeValues(): array
    {
        $key = 'attribute_values';

        $result = Cache::remember($key, now()->addDays(6), function () {

            return ProductAttribute::with('values')->get()->mapWithKeys(function ($attribute) {
                return [$attribute->name => $attribute->values->pluck('id', 'value')];
            });
        })->toArray();

        return $result;
    }

    public function getAllProducts(){

        return Product::with('categories')->get();
    }
    public function getAttributeValuesByProductId(Product $product){

        $attributeValues = $product->attributeValues()->with('attribute')->get();

                        $result = [];
                        foreach ($attributeValues as $value) {

                            $result[] = [
                                'attribute_name' => $value->attribute?->name,
                                'attribute_value_id' => $value->id,
                            ];
                        }
                      return $result;
                        
    }

}
