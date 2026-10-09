<?php

namespace Modules\Catalog\Filament\Resources\ProductVariant;

use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Catalog\Filament\Resources\Product\ProductResource;
use Modules\Catalog\Filament\Resources\ProductVariant\Pages;
use Modules\Catalog\Models\ProductVariant;
use Override;

class ProductVariantResource extends Resource
{
    protected static ?string $model = ProductVariant::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'ادارة المخزون والمنتجات';
    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'جميع أنواع المنتجات';

    protected static ?string $modelLabel = 'نوع منتج';

    protected static ?string $pluralModelLabel = 'أنواع المنتجات';

    #[Override]
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')
                    ->label('اسم المنتج')
                    ->searchable()
                    ->sortable()
                    ->url(fn (ProductVariant $record) => $record->product_id
                        ? ProductResource::getUrl('edit', ['record' => $record->product_id])
                        : null
                    ),

                TextColumn::make('sku')
                    ->label('رمز المنتج')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('price')
                    ->label('السعر')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('attributeValues.value')
                    ->label('الخصائص التركيبية')
                    ->badge()
                    ->color('info'),

                TextColumn::make('inventory.quantity')
                    ->label('الكمية بالمخزن')
                    ->default(0)
                    ->sortable()
                    ->action(
                        Action::make('updateQuantity')
                            ->label('تحديث الكمية')
                            ->modalHeading('تعديل كمية المخزون')
                            ->form([
                                TextInput::make('quantity')
                                    ->label('الكمية الجديدة')
                                    ->numeric()
                                    ->required()
                                    ->default(fn (ProductVariant $record) => $record->inventory?->quantity ?? 0),
                            ])
                            ->action(function (ProductVariant $record, array $data) {
                                $record->inventory()->updateOrCreate(
                                    ['product_variant_id' => $record->id],
                                    ['quantity' => $data['quantity']]
                                );
                            })
                    ),

                TextColumn::make('inventory.low_stock_threshold')
                    ->label('الحد الادنى للكمية')
                    ->default(0)
                    ->sortable()
                    ->action(
                        Action::make('updateLowStockThreshold')
                            ->label('تحديث الحد الادنى للكمية')
                            ->modalHeading('تعديل الحد الادنى للكمية')
                            ->form([
                                TextInput::make('low_stock_threshold')
                                    ->label('الحد الادنى للكمية')
                                    ->numeric()
                                    ->required()
                                    ->default(fn (ProductVariant $record) => $record->inventory?->low_stock_threshold ?? 0),
                            ])
                            ->action(function (ProductVariant $record, array $data) {
                                $record->inventory()->updateOrCreate(
                                    ['product_variant_id' => $record->id],
                                    ['low_stock_threshold' => $data['low_stock_threshold']]
                                );
                            })
                    ),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductVariants::route('/'),
            'create' => Pages\CreateProductVariant::route('/create'),
            'edit' => Pages\EditProductVariant::route('/{record}/edit'),
        ];
    }
}
