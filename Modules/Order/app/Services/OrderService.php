<?php

namespace Modules\Order\Services;

use Illuminate\Support\Facades\DB;
use Modules\Cart\Models\Cart;
use Modules\Catalog\Models\Inventory;
use Modules\Order\Exceptions\EmptyCartException;
use Modules\Order\Exceptions\OutOfStockException;
use Modules\Order\Models\Order;
use Modules\Order\Models\OrderItem;
use Modules\Order\Exceptions\OrderNotCancellableException;

class OrderService
{
    public function createOrder(array $data, Cart $cart): Order
    {
     
        return DB::transaction(function () use ($data, $cart) {
        
            $cartItems = $cart->items()
                ->with('productVariant.product', 'productVariant.inventory')
                ->get();
            
            if ($cartItems->isEmpty()) {
                throw new EmptyCartException();
            }
            
           
            $this->lockInventories($cartItems);
            
        
            $this->ensureStockAvailable($cartItems);
            
          
            $subtotal = $cartItems->sum(fn($item) => 
                $item->quantity * $item->productVariant->price
            );
           
            
          
            $order = Order::create([
                'customer_id'    => $cart->customer_id,
                'status'         => 'pending',
                'payment_method' => $data['method_payment'] ?? 'cod',
                'payment_status' => 'pending',
                'subtotal'       => $subtotal,
                'shipping_cost'  => 0,
                'notes'          => $data['notes'] ?? null,
            ]);
            
          
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_variant_id' => $item->productVariant->id,
                    'product_name'       => $item->productVariant->product->name,
                    'variant_sku'        => $item->productVariant->sku,
                    'price'              => $item->productVariant->price,
                    'quantity'           => $item->quantity,
                    'sub_total'           => $item->quantity * $item->productVariant->price,
                ]);
            }
            
            
            $this->deductStock($cartItems);
            
            
            $cart->update(['status' => 'completed']);
             Cart::create([
                    'customer_id' => $cart->customer_id,
                   
                ]);
            
            return $order->load('items');
        });
    }
    
    private function lockInventories($cartItems): void
    {
        $variantIds = $cartItems->pluck('product_variant_id')->toArray();
        
       
        Inventory::whereIn('product_variant_id', $variantIds)
            ->lockForUpdate()
            ->get();
         
    }
    
    private function ensureStockAvailable($cartItems): void
    {
      
        foreach ($cartItems as $item) {
            if ($item->productVariant->inventory->quantity < $item->quantity) {
                throw new OutOfStockException(
                    $item->productVariant->product->name,
                    $item->productVariant->inventory->quantity
                );
            }
        }
        
    }
    
    private function deductStock($cartItems): void
    {
        foreach ($cartItems as $item) {
            $item->productVariant->inventory->decrement('quantity', $item->quantity);
        }
    }
    public function getOrderById($orderId): Order
    {
        $order=auth('api')->user()->orders()->where('id',$orderId)->with('items')->firstOrFail();
        return $order;
    }
    public function getOrdersForCustomer()
    {
        return auth('api')->user()->orders()->with('items')->get();
    }
    public function cancelOrder($orderId): Order
    {
        
       return DB::transaction(function () use ($orderId) {
            dd(auth('api')->user()->orders()->where('id',$orderId)->with('items.productVariant.inventory')->lockForUpdate()->firstOrFail());
            $order=auth('api')->user()->orders()->where('id',$orderId)->with('items.productVariant.inventory')->lockForUpdate()->firstOrFail();
            if ($order->status === 'cancelled') {
                throw new OrderNotCancellableException("الطلب ملغى بالفعل");
            }
           if(!$this->isCancellable($order)){
                throw new OrderNotCancellableException("لا يمكن الغاء الطلب بعد تأكيده بالدفع او شحنه
او بعد مرور 3 ساعات من انشائه
ويمكنك الالغاء الطلب خلال 60 دقيقة من انشائه فقط");
            }
            
         
            $order->update(['status'=>'cancelled',
            "cancelled_at" => now()
            ]);
            foreach ($order->items as $item) {
               
                $item->productVariant->inventory->increment('quantity', $item->quantity);
            }
            return $order;
        });
     
    }
    private function isCancellable(Order $order): bool
    {
        
       if ($order->status !== 'pending') {
            return false;
        }
        if ($order->updated_at->diffInMinutes(now()) <= 60) {
            
            return false;
        }
        if($order->updated_at->diffInMinutes(now())>180){
            return false;
        }
        if ($order->payment_status !== 'cod') {
            return false;
        }
        return true;
    }
}
