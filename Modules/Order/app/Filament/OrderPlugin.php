<?php

namespace Modules\Order\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class OrderPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Order';
    }

    public function getId(): string
    {
        return 'order';
    }

    public function boot(Panel $panel): void
    {
        $panel->resources([
            \Modules\Order\Filament\Resources\OrderResource::class,
        ]);
    }
}
