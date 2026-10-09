<?php

namespace Modules\Catalog\Filament\Resources\ProductAttribute\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Modules\Catalog\Filament\Resources\ProductAttribute\ProductAttributeResource;
use Override;

class CreateProductAttribute extends CreateRecord
{
    protected static string $resource = ProductAttributeResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    #[Override]
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('تم إنشاء الخاصية بنجاح')
            ->body('يمكنك الآن إضافة خواص للمنتجات .');
    }
}
