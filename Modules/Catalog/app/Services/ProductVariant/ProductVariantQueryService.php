<?php

namespace Modules\Catalog\Services\ProductVariant;
use Modules\Catalog\Models\ProductVariant;

class ProductVariantQueryService
{
    public function handle() {}
        public function getProductById(int $id){

        return ProductVariant::where('product_id', $id)->with('Product')->with('product.categories')->with('attributeValues')->with('attributeValues.attribute')->with('inventory')->first(); 
    }
}
