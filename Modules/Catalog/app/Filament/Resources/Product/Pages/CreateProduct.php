<?php

namespace Modules\Catalog\Filament\Resources\Product\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Catalog\Filament\Resources\Product\ProductResource;
use Filament\Notifications\Notification;
use Override;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function afterCreate()
    {
        $this->saveCategories();
        $this->saveAttributeValues();
    }
    #[Override]
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
   protected function getCreatedNotification(): ?Notification
{
    return Notification::make()
        ->success()
        ->title('تم إنشاء المنتج بنجاح')
        ->body('جاري توليد المتغيرات في الخلفية...');
}
    private function saveCategories()
    {
        $categories = $this->data['categories'] ?? [];
        if (empty($categories)) {
            return;
        }
        $this->record->categories()->sync($categories);
    }
    private function saveAttributeValues()
    {
        $attributeValues = $this->data['attribute_selections'] ?? [];
        if (empty($attributeValues)) {
            return;
        }
        $valuesId = collect($attributeValues)->pluck('attribute_value_id')->toArray();
        $this->record->attributeValues()->sync($valuesId);
    }
}
