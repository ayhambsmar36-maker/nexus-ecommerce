<?php

namespace Modules\Catalog\Filament\Resources\Product;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Catalog\Models\Product;
use Modules\Catalog\Services\Category\CategoryQueryService;
use Modules\Catalog\Services\Product\ProductQueryService;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

   protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'اضافة منتجات';
    protected static ?string $navigationLabel = 'المنتجات';
    protected static ?string $navigationBadge = '10';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // -------------------------------------------------------------
                // Part 1: البيانات الأساسية والتصنيفات (2 Columns)
                // -------------------------------------------------------------
                Group::make()
                    ->schema([
                        Section::make('معلومات المنتج الأساسية')
                            ->schema([
                                TextInput::make('name')
                                    ->label('اسم المنتج')
                                    ->required()
                                    ->live(onBlur: true),

                                TextInput::make('description')
                                    ->label('وصف المنتج')
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Repeater::make('التصنيفات')
                            ->schema([
                                Select::make('categories')
                                    ->label('اختر التصنيفات')
                                    ->options(function () {

                                        return CategoryQueryService::getCategory();
                                    })
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ])

                           
                    ])
                    ->columnSpan(2),

                // -------------------------------------------------------------
                // Part 2: حالة المنتج والأسعار (1 Column)
                // -------------------------------------------------------------
                Group::make()
                    ->schema([
                        Section::make('التسعير والحالة')
                            ->schema([
                                Select::make('status')
                                    ->label('حالة المنتج')
                                    ->options([
                                        'draft' => 'مسودة (Draft)',
                                        'published' => 'منشور (Published)',
                                        'archived' => 'مؤرشف (Archived)',
                                    ])
                                    ->default('draft')
                                    ->required(),

                                TextInput::make('price')
                                    ->label('السعر الأساسي')
                                    ->numeric()
                                    ->prefix('$')
                                    ->required(),

                                TextInput::make('compare_price')
                                    ->label('السعر قبل الخصم')
                                    ->numeric()
                                    ->prefix('$'),

                                Toggle::make('is_featured')
                                    ->label('منتج مميز (Featured)')
                                    ->default(false),
                            ]),
                    ])
                    ->columnSpan(1),

                // -------------------------------------------------------------
                // Part 3: الخصائص والقيم القابلة للتوليد (3 Columns Width)
                // -------------------------------------------------------------
                Repeater::make('attribute_selections')
                    ->label('خصائص المنتج وقيمها')
                    ->disabled(fn ($record) => $record !== null)
                    ->helperText(fn ($record) => $record !== null
                        ? 'لا يمكن تعديل الخصائص بعد الإنشاء. لإنشاء خصائص جديدة، أنشئ منتجاً جديداً.'
                        : null)
                    ->schema([

                        Select::make('attribute_name')
                            ->label('الخاصية')
                            ->options(function (ProductQueryService $service) {
                                $data = $service->getAttributeValues();

                                $keys = array_keys($data);

                                return array_combine($keys, $keys);
                            })
                            ->live()
                            ->required()
                            ->dehydrated(false),

                        Select::make('attribute_value_id')
                            ->label('القيمة')
                            ->dehydrated(true)
                            ->options(function (Get $get, ProductQueryService $service) {
                                $selectedAttribute = $get('attribute_name');

                                if (! $selectedAttribute) {
                                    return [];
                                }

                                $data = $service->getAttributeValues();

                                return array_flip($data[$selectedAttribute] ?? []);
                            })
                            ->required(),
                    ])->loadStateFromRelationshipsUsing(function (Product $record, Component $component,ProductQueryService $service) {
                        $result = $service->getAttributeValuesByProductId($record);
                        $component->state($result);

                    })

                    ->columns(2)
                    ->columnSpanFull(),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('اسم المنتج')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('السعر')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('compare_price')
                    ->label('السعر قبل الخصم')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('حالة المنتج')
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->label('منتج مميز (Featured)'),
                TextColumn::make('slug')
                    ->label('رابط المنتج'),
                TextColumn::make('sku')
                    ->label('رمز المنتج'),
                TextColumn::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
