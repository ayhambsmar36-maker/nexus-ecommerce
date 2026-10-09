<?php

namespace Modules\Cart\Services;

use App\Models\Customer;
use Modules\Cart\Models\Cart;
class CartService
{
    
    
    public function getCart() {
        
       $cart= auth('api')->user()->activeCart()->with('items.productVariant')->firstorFail() ;
    
    
          $cart['summary'] = $this->summary($cart);
          return $cart;
        
        
    }
    public function emptyCart() {
      
     
            $cart = auth('api')->user()->activeCart()->firstOrFail();
            
                return $cart->items()->delete();
            
    }
    private function summary(Cart $cart): array
    {
       
        $numberOfItems = $cart->items->count();
        $totalItems = $cart->items->sum('quantity');
       $totalPrice = $cart->items->sum(function ($item) {
            return $item->quantity * $item->productVariant->price;
        });

        return [
            'number_of_items' => $numberOfItems,
            'total_items' => $totalItems,
            'total_price' => $totalPrice,
        ];
    }
}
