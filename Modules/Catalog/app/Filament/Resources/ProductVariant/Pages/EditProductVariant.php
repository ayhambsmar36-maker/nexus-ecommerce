<?php

namespace Modules\Catalog\Filament\Resources\ProductVariant\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Catalog\Filament\Resources\ProductVariant\ProductVariantResource;

class EditProductVariant extends EditRecord
{
    protected static string $resource = ProductVariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
