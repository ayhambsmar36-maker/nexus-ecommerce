<?php

namespace Modules\Catalog\Filament\Resources\ProductVariant\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Catalog\Filament\Resources\ProductVariant\ProductVariantResource;

class CreateProductVariant extends CreateRecord
{
    protected static string $resource = ProductVariantResource::class;

}
