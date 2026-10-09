<?php

namespace Modules\Order\Filament\Resources\Order\Pages;

use Modules\Order\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
