<?php

namespace Modules\Catalog\Filament\Resources\ProductAttribute\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Catalog\Filament\Resources\ProductAttribute\ProductAttributeResource;

class ListProductAttributes extends ListRecords
{
    protected static string $resource = ProductAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
