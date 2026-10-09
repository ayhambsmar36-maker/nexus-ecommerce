<?php

namespace Modules\Catalog\Filament\Resources\ProductAttribute;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Catalog\Filament\Resources\ProductAttribute\Pages;
use Modules\Catalog\Models\ProductAttribute;

class ProductAttributeResource extends Resource
{
    protected static ?string $model = ProductAttribute::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'اضافة منتجات';
    protected static ?string $navigationLabel = 'خصائص المنتجات';
    protected static ?string $navigationBadge = '10';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('تفاصيل الخاصية')
                    ->schema([
                        // 1. اسم الخاصية الأساسية (مثل: اللون، المقاس)
                        TextInput::make('name')
                            ->label('اسم الخاصية')
                            ->placeholder('مثال: اللون، المقاس، السعة')
                            ->required()
                            ->unique(ignoreRecord: true),

                        // 2. قيم الخاصية التابعة لها (HasMany)
                        Repeater::make('values')
                            ->relationship('values') // علاقة HasMany مع موديل ProductAttributeValue
                            ->schema([
                                TextInput::make('value')
                                    ->label('القيمة')
                                    ->placeholder('مثال: أحمر، M، 128GB')
                                    ->required(),
                            ])
                            ->label('قيم الخاصية')
                            ->addActionLabel('إضافة قيمة جديدة')
                            ->defaultItems(1)
                            ->collapsible()
                            ->grid(2) // عرض القيم في عمودين لترتيب الشاشة
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('اسم الخاصية')
                    ->searchable()
                    ->sortable(),

                // عرض عدد القيم المضافة لهذه الخاصية
                TextColumn::make('values_count')
                    ->label('عدد القيم المتاحة')
                    ->counts('values')
                    ->sortable(),
                TextColumn::make('values.value')
                    ->label('القيم المتاحة')
                    ->badge() // يعرض كل قيمة بداخل كبسولة/بطاقة ملونة صغيرة
                    ->separator(',') // يفصل القيم عن بعضها
                    ->color('success'),

                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProductAttributes::route('/'),
            'create' => Pages\CreateProductAttribute::route('/create'),
            'edit' => Pages\EditProductAttribute::route('/{record}/edit'),
        ];
    }
}
