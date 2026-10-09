<?php

namespace Modules\Catalog\Observers;

use Modules\Catalog\Models\Product;
use Modules\Catalog\Jobs\GenerateProductVariants;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void {
       GenerateProductVariants::dispatch($product);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void {}

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void {}

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void {}

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void {}
}
