<?php

namespace Modules\Catalog\Filament\Resources\Category\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Catalog\Filament\Resources\Category\CategoryResource;
use Filament\Notifications\Notification;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('تم إنشاء التصنيف بنجاح')
            ->body('يمكنك الآن إضافة منتجات للتصنيف .');
    }
}
