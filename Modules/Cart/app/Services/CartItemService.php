<?php

namespace Modules\Cart\Services;

use App\Models\Customer;
use Modules\Cart\Models\Cart;
use Modules\Cart\Models\CartItem;

class CartItemService
{
    public function __construct( private CartService $service)
    {
        
    }
   /* public function getCartItems(CartItem $cartItem)
    {
        return $cartItem->load('productVariant');
    }*/

    public function addItem(Customer $customer,int  $productVariantId)
    {
       $cart=$customer->activeCart()->first();
       $cartItem = $cart->items()->where('product_variant_id', $productVariantId)->first();
   

        if ($cartItem) {

            $cartItem->increment('quantity', 1);

            return $cartItem->refresh()->load('productVariant');
             
        }
     
       $cartItem= CartItem::create([
            'cart_id' => $cart->id,
            'product_variant_id' => $productVariantId,
            'quantity' => 1,
        ]);
   
        return $cartItem->load('productVariant');

    }

    public function editItemQuantity(int $cartItemId, int $quantity)
    {
        $cartItem = CartItem::where('id', $cartItemId)->first();
        if ($quantity <= 0) {
            $this->removeItem($cartItem);

            return null;
        }
        $cartItem->update(['quantity' => $quantity]);

        return $cartItem->refresh();
    }

    private function removeItem(CartItem $cartItem)
    {
        $cartItem->delete();

        return null;
    }
}
