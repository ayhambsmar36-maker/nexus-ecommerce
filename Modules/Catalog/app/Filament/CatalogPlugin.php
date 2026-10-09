<?php

namespace Modules\Catalog\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Modules\Catalog\Filament\Widgets;
use Modules\Catalog\Filament\Widgets\CatalogStats;
use Modules\Catalog\Filament\Resources\Category\CategoryResource;
use Modules\Catalog\Filament\Resources\Product\ProductResource;
use Modules\Catalog\Filament\Resources\ProductAttribute\ProductAttributeResource;
use Modules\Catalog\Filament\Resources\ProductVariant\ProductVariantResource;
use Filament\Support\Colors\Color;
class CatalogPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Catalog';
    }

    public function getId(): string
    {
        return 'catalog';
    }

    public function boot(Panel $panel): void
    {
        
        $panel->widgets([
            CatalogStats::class,
        ])
        ->resources([
            CategoryResource::class,
            ProductResource::class,
            ProductAttributeResource::class,
            ProductVariantResource::class,
        ])
      
        ;

    }
}
