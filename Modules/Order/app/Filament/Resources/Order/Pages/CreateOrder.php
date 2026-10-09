<?php

namespace Modules\Order\Filament\Resources\Order\Pages;

use Modules\Order\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
    
}
