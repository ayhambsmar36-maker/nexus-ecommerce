<?php

namespace Modules\Catalog\Services\ProductVariant;

use Illuminate\Support\Facades\DB;
use Modules\Catalog\Models\Product;
use Modules\Catalog\Models\ProductVariant;
use Modules\Catalog\Services\Product\ProductQueryService;

class VariantGenerate
{
    public function handle() {}

    public function generateFor(Product $product)
    {
        return DB::transaction(function () use ($product) {
            $combintations = ProductQueryService::getProductAttributeValues($product);

            if (empty($combintations)) {
                return;
            }
            $data = $this->cartesian($combintations);
            
            foreach ($data as $combination) {
                $this->createVariant($combination, $product);
            }

        });
    }

    private function cartesian(array $data)
    {
        $result = [[]];
        foreach ($data as $value) {
            $temp = [];
            foreach ($result as $item) {
                foreach ($value as $val) {
                    $temp[] = array_merge($item, [$val]);
                }

            }
            $result = $temp;
        }

        return $result;
    }
    private function createVariant(array $combination, Product $product){
        $sku= $product->sku.'-'.implode('-', $combination);
          $product_variant = ProductVariant::firstOrCreate([
                    'sku' => $sku,
                ], [
                    'product_id' => $product->id,
                    'price' => $product->price,

                ]
                );

                $product_variant->attributeValues()->sync($combination);
                $product_variant->inventory()->create([
                    'quantity' => 1,
                    'low_stock_threshold' => 1,

                ]);

    }
}
