<?php

namespace Modules\Catalog\Filament\Resources\ProductAttribute\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Catalog\Filament\Resources\ProductAttribute\ProductAttributeResource;
use Filament\Notifications\Notification;

class EditProductAttribute extends EditRecord
{
    protected static string $resource = ProductAttributeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('تم تعديل الخاصية بنجاح')
            ->body('يمكنك الآن إضافة خواص للمنتجات .');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
