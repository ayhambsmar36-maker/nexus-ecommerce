<?php

namespace Modules\Catalog\Observers;

use Illuminate\Support\Facades\Cache;
use Modules\Catalog\Models\ProductAttributeValue;

class ProductAttributeValueObserver
{
    /**
     * تُستدعى عند الإضافة أو التعديل
     */
    private function CacheClear(ProductAttributeValue $productAttributeValue): void
    {
        Cache::forget("product:{$productAttributeValue->product_id}:attribute_values");
        Cache::forget('attribute_values');
    }

    public function saved(ProductAttributeValue $productAttributeValue): void
    {
        $this->CacheClear($productAttributeValue);
    }

    /**
     * تُستدعى عند الحذف
     */
    public function deleted(ProductAttributeValue $productAttributeValue): void
    {
        $this->CacheClear($productAttributeValue);
    }
}
