<?php

namespace Modules\Catalog\Filament\Resources\ProductVariant\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Catalog\Filament\Resources\ProductVariant\ProductVariantResource;

class ListProductVariants extends ListRecords
{
    protected static string $resource = ProductVariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
