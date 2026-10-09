<?php

namespace Modules\Catalog\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\Catalog\Models\Product;
use Modules\Catalog\Models\Category;
use Modules\Catalog\Models\ProductAttribute;
use Modules\Catalog\Models\ProductVariant;
use Modules\Catalog\Policies\ProductPolicy;
use Modules\Catalog\Policies\CategoryPolicy;
use Modules\Catalog\Policies\ProductAttributePolicy;
use Modules\Catalog\Policies\ProductVariantPolicy;
use Illuminate\Support\Facades\Gate;

class CatalogServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Catalog';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'catalog';

    /**
     * Command classes to register.
     *
     * @var string[]
     */
    // protected array $commands = [];

    /**
     * Provider classes to register.
     *
     * @var string[]
     */
    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    /**
     * Define module schedules.
     *
     * @param  $schedule
     */
    // protected function configureSchedules(Schedule $schedule): void
    // {
    //     $schedule->command('inspire')->hourly();
    // }
    public function boot(): void
    {
        parent::boot();
    Gate::policy(Product::class, ProductPolicy::class);
    Gate::policy(Category::class, CategoryPolicy::class);
    Gate::policy(ProductAttribute::class, ProductAttributePolicy::class);
    Gate::policy(ProductVariant::class, ProductVariantPolicy::class);
    }
}
