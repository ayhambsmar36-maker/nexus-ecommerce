<?php

namespace Modules\Catalog\Filament\Resources\Category;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Modules\Catalog\Filament\Resources\Category\Pages;
use Modules\Catalog\Models\Category;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'اضافة منتجات';
    protected static ?string $navigationLabel = 'التصنيفات';
    protected static ?string $navigationBadge = '10';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // العمود الأول: البيانات النصية والروابط (يأخذ ثلثي المساحة)
                Group::make()
                    ->schema([
                        Section::make('معلومات التصنيف الأساسية')
                            ->description('أدخل الاسم والروابط الهيكلية للتصنيف')
                            ->schema([
                                TextInput::make('name')
                                    ->label('اسم التصنيف')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, callable $set) {
                                        if ($operation === 'create') {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),

                                TextInput::make('slug')
                                    ->label('الرابط الفريد (Slug)')
                                    ->required()
                                    ->unique(ignoreRecord: true),

                                Select::make('parent_id')
                                    ->label('التصنيف الأب')
                                    ->relationship('parent', 'name')
                                    ->options(function () {
                                        return Category::whereNull('parent_id')->pluck('name', 'id');
                                    })
                                    ->searchable()
                                    ->placeholder('اختر إذا كان هذا تصنيفاً فرعياً'),
                            ]),
                        Toggle::make('is_active')
                            ->label('مُفعل في المتجر')
                            ->default(true),
                    ]),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('اسم التصنيف')
                    ->searchable() // تفكير ذكي: جعل العمود قابل للبحث!
                    ->sortable(),

                TextColumn::make('parent.name')
                    ->label('التصنيف الأب')
                    ->placeholder('تصنيف رئيسي')
                    ->searchable() // تفكير ذكي: جعل العمود قابل للبحث!
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('مُفعل في المتجر')
                    ->boolean(),
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

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
