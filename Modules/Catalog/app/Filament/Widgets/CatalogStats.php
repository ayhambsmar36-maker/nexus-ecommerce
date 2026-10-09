<?php

namespace Modules\Catalog\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Catalog\Models\Product;
use Modules\Catalog\Models\Category;


class CatalogStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('إجمالي المنتجات', Product::count())
                ->description('كل المنتجات')
                ->color('primary'),

            Stat::make('المنتجات المنشورة', Product::where('status', 'published')->count())
                ->description('جاهزة للبيع')
                ->color('success'),

            Stat::make('المسودات', Product::where('status', 'draft')->count())
                ->description('تحتاج إكمال')
                ->color('warning'),

            Stat::make('التصنيفات', Category::count())
                ->description('كل التصنيفات')
                ->color('info'),
        ];
    }
}
