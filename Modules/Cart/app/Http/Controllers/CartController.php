<?php

namespace Modules\Cart\Http\Controllers;

use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Modules\Cart\Services\CartService;
use Modules\Cart\Transformers\CartResource;

class CartController extends Controller
{
    use ApiResponse;
   public function __construct(private CartService $service)
   {

   }
    public function show( )
    {
       
        return $this->successResponse( new CartResource($this->service->getCart()),'Cart retrieved successfully', 200);
    }

   
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy() {
        $this->service->emptyCart();
        return $this->successResponse([], 'Cart emptied successfully', 200);
    }
}
