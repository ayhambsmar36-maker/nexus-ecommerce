<?php

namespace Modules\Order\Exceptions;
use App\Api\ApiResponse;
use Illuminate\Http\Request;

use Exception;
use function Illuminate\Events\queueable;

class EmptyCartException extends Exception {
    use ApiResponse;
 
    public function handle(Request $request) {
        if($request->is('api/*')) {
            return $this->errorResponse('Your cart is empty. Please add items to your cart before placing an order.', 400);
        }
     
    }
}
