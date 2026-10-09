<?php

namespace Modules\Catalog\Filament\Resources\Product\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Catalog\Filament\Resources\Product\ProductResource;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
