<?php

namespace Modules\Catalog\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Catalog\Models\Category;
use Modules\Catalog\Models\ProductAttribute;
use Modules\Catalog\Models\ProductAttributeValue;
use Modules\Catalog\Observers\CategoryObserver;
use Modules\Catalog\Observers\ProductAttributeValueObserver;
use Modules\Catalog\Models\Product;
use Modules\Catalog\Observers\ProductObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        
    ];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
    protected function configureEmailVerification(): void {}

    public function boot(): void
    {
        parent::boot();
        Category::observe(CategoryObserver::class);
        ProductAttributeValue::observe(ProductAttributeValueObserver::class);
        Product::observe(ProductObserver::class);
        //  ProductAttribute::observe(\Modules\Catalog\Observers\ProductAttributeValueObserver::class);
    }
}
