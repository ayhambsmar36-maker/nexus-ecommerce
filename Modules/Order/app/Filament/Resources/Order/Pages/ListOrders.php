<?php

namespace Modules\Order\Filament\Resources\Order\Pages;

use Modules\Order\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
