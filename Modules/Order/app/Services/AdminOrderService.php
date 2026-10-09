<?php

namespace Modules\Order\Services;
use Modules\Order\Models\Order;
use Illuminate\Support\Facades\DB;
use Modules\Order\Exceptions\OrderNotCancellableException;
class AdminOrderService
{
    public function cancelOrder($orderId): Order
    {
        return DB::transaction(function () use ($orderId) {
            $order = Order::where('id', $orderId)
                ->with('items.productVariant.inventory')
                ->lockForUpdate()
                ->firstOrFail();

            if (!$order->canCancel() ) {
                throw new OrderNotCancellableException("الطلب لا يمكن إلغائه في حال {$order->status} ");
            }

            foreach ($order->items as $item) {
                $inventory = $item->productVariant->inventory;
                if ($inventory) {
                    $inventory->increment('quantity', $item->quantity);
                }
            }

            $order->update(['status' => 'cancelled'
            , "cancelled_at" => now()]);

            return $order;
        });
    }
    public function shippedOrder($orderId): Order
    {
        return DB::transaction(function () use ($orderId) {
            $order = Order::where('id', $orderId)
                ->lockForUpdate()
                ->firstOrFail();

            if (!$order->canShip() ) {
                throw new OrderNotCancellableException("الطلب لا يمكن شحنه في حال {$order->status} ");
            }

            $order->update(['status' => 'shipped',
            "shipped_at" => now()
            ]);

            return $order;
        });
    }
    public function deliveredOrder($orderId): Order
    {
        return DB::transaction(function () use ($orderId) {
            
            $order = Order::where('id', $orderId)
                ->lockForUpdate()
                ->firstOrFail();
             if(!$order->canDeliver()){
                throw new OrderNotCancellableException("لا يمكن تسليم الطلب شحنه في حال {$order->status} ");
             }
           

            $order->update(['status' => 'delivered',
            "delivered_at" => now()
            ]);

            return $order;
        });
    }
}
