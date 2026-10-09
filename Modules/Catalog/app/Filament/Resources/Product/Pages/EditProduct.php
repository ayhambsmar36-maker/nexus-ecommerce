<?php

namespace Modules\Catalog\Filament\Resources\Product\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Modules\Catalog\Filament\Resources\Product\ProductResource;
use Override;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    #[Override]
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('تم تعديل المنتج بنجاح')
            ->body('غير ممكن التعديل علئ خصائص المنتج مثلاً لون مقاس وغيره    ...');
    }

    #[Override]
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [

            Actions\DeleteAction::make(),
        ];
    }
}
