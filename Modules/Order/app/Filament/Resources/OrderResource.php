<?php

namespace Modules\Order\Filament\Resources;

use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Filament\Resources\Order\Pages;
use Modules\Order\Models\Order;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'الطلبات';
    protected static ?string $navigationLabel = 'الطلبات';
    protected static ?string $pluralLabel = 'الطلبات';
    protected static ?int $navigationSort = 6;

    // ✅ منع الإنشاء/التعديل/الحذف
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table->modifyQueryUsing(fn($query) => 
        $query->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->select('orders.*')
            ->orderBy('orders.created_at', 'desc')
        
        )
            ->columns([
                TextColumn::make('order_number')
                    ->label('رقم الطلب')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('customer.name')
                    ->label('الزبون')
                    ->searchable()
                    ->sortable(['customer_id']),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'pending'   => 'warning',
                        'shipped'   => 'info',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn($state) => match($state) {
                        'pending'   => 'قيد الانتظار',
                        'shipped'   => 'تم الشحن',
                        'delivered' => 'تم التسليم',
                        'cancelled' => 'تم الإلغاء',
                        default     => $state,
                    }),

                TextColumn::make('payment_method')
                    ->label('طريقة الدفع')
                    ->badge()
                    ->formatStateUsing(fn($state) => match($state) {
                        'cod'   => 'عند التسليم',
                        'card'  => 'بطاقة',
                        'ecash' => 'eCash',
                        default => $state,
                    }),

                TextColumn::make('payment_status')
                    ->label('حالة الدفع')
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'paid'    => 'success',
                        'pending' => 'warning',
                        'failed'  => 'danger',
                        default   => 'gray',
                    })
                    ->formatStateUsing(fn($state) => match($state) {
                        'paid'    => 'تم الدفع',
                        'pending' => 'قيد الانتظار',
                        'failed'  => 'فشل الدفع',
                        default   => $state,
                    }),

                TextColumn::make('subtotal')
                    ->label('المجموع الفرعي')
                    ->money('usd')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('shipping_cost')
                    ->label('الشحن')
                    ->money('usd')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('total')
                    ->label('الإجمالي')
                    ->money('usd')
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('created_at')
                    ->label('تاريخ الطلب')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('حالة الطلب')
                    ->options([
                        'pending'   => 'قيد الانتظار',
                        'shipped'   => 'تم الشحن',
                        'delivered' => 'تم التسليم',
                        'cancelled' => 'تم الإلغاء',
                    ]),

                SelectFilter::make('payment_status')
                    ->label('حالة الدفع')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'paid'    => 'تم الدفع',
                        'failed'  => 'فشل الدفع',
                    ]),

                SelectFilter::make('payment_method')
                    ->label('طريقة الدفع')
                    ->options([
                        'cod'   => 'الدفع عند الاستلام',
                        'card'  => 'بطاقة ائتمان',
                        'ecash' => 'الدفع الإلكتروني',
                    ]),
            ])
            ->actions([
                // ✅ عرض
                ViewAction::make()->label('عرض'),

                // ✅ شحن
                Action::make('ship')
                    ->label('شحن')
                    ->icon('heroicon-o-truck')
                    ->color('info')
                    ->requiresConfirmation()
                    ->visible(fn(Order $record) => $record->canShip())
                    ->action(function (Order $record) {
                        try {
                            app(\Modules\Order\Services\AdminOrderService::class)
                                ->shippedOrder($record->id);

                            Notification::make()
                                ->title('تم شحن الطلب')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('فشل الشحن')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                // ✅ تسليم
                Action::make('deliver')
                    ->label('تسليم')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn(Order $record) => $record->canDeliver())
                    ->action(function (Order $record) {
                        try {
                            app(\Modules\Order\Services\AdminOrderService::class)
                                ->deliveredOrder($record->id);

                            Notification::make()
                                ->title('تم تسليم الطلب')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('فشل التسليم')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                // ✅ إلغاء
                Action::make('cancel')
                    ->label('إلغاء')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn(Order $record) => $record->canCancel())
                    ->action(function (Order $record) {
                        try {
                            app(\Modules\Order\Services\AdminOrderService::class)
                                ->cancelOrder($record->id);

                            Notification::make()
                                ->title('تم إلغاء الطلب')
                                ->success()
                                ->send();
                        } catch (\Modules\Order\Exceptions\OrderNotCancellableException $e) {
                            Notification::make()
                                ->title('فشل الإلغاء')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([
                
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('بيانات الطلب')
                ->schema([
                    Infolists\Components\TextEntry::make('order_number')
                        ->label('رقم الطلب'),
                    Infolists\Components\TextEntry::make('status')
                        ->label('الحالة')
                        ->formatStateUsing(fn($state) => match($state) {
                            'pending'   => 'قيد الانتظار',
                            'shipped'   => 'تم الشحن',
                            'delivered' => 'تم التسليم',
                            'cancelled' => 'تم الإلغاء',
                            default     => $state,
                        })
                        ->color(fn($state) => match($state) {
                            'pending'   => 'warning',
                            'shipped'   => 'info',
                            'delivered' => 'success',
                            'cancelled' => 'danger',
                            default     => 'gray',
                        })
                        ->badge(),
                    Infolists\Components\TextEntry::make('payment_method')
                        ->label('طريقة الدفع'),

                    Infolists\Components\TextEntry::make('created_at')
                        ->label('تاريخ الطلب')
                        ->dateTime(),
                ])->columns(4),

            Infolists\Components\Section::make('بيانات الزبون')
                ->schema([
                    Infolists\Components\TextEntry::make('customer.name')
                        ->label('الاسم'),
                    Infolists\Components\TextEntry::make('customer.email')
                        ->label('البريد'),
                    Infolists\Components\TextEntry::make('customer.phone')
                        ->label('الهاتف')
                        ->default('—'),
                ])->columns(3),

            Infolists\Components\Section::make('المنتجات')
                ->schema([
                    Infolists\Components\RepeatableEntry::make('items')
                        ->schema([
                            Infolists\Components\TextEntry::make('product_name')
                                ->label('المنتج'),
                            Infolists\Components\TextEntry::make('variant_sku')
                                ->label('SKU'),
                            Infolists\Components\TextEntry::make('price')
                                ->label('السعر')
                                ->money('usd'),
                            Infolists\Components\TextEntry::make('quantity')
                                ->label('الكمية'),
                            Infolists\Components\TextEntry::make('subtotal')
                                ->label('المجموع')
                                ->money('usd'),
                        ])->columns(5),
                ]),

            Infolists\Components\Section::make('المبالغ')
                ->schema([
                    Infolists\Components\TextEntry::make('subtotal')
                        ->label('المجموع الفرعي')
                        ->money('usd'),
                    Infolists\Components\TextEntry::make('shipping_cost')
                        ->label('الشحن')
                        ->money('usd'),
                    Infolists\Components\TextEntry::make('total')
                        ->label('الإجمالي')
                        ->money('usd')
                        ->weight('bold'),
                ])->columns(3),

            Infolists\Components\Section::make('ملاحظات')
                ->schema([
                    Infolists\Components\TextEntry::make('notes')
                        ->default('لا توجد ملاحظات'),
                ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/')
         
            
        ];
    }

    public static function getRelations(): array
    {
        return [];
    }
}