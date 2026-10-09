<?php

namespace Modules\Cart\Http\Controllers;

use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use Modules\Cart\Http\Requests\CartItemRequest;
use Modules\Cart\Http\Requests\UpdateCartItemRequest;
use Modules\Cart\Services\CartItemService;
use Modules\Cart\Transformers\CartItemsResource;
class CartItemController extends Controller
{
    use ApiResponse;
    public function __construct(private CartItemService $service)
    {
    }
    public function store(CartItemRequest $request)
    {

        $cartItem = $this->service->addItem(auth('api')->user(),  $request['product_variant_id']);
       

        return $this->successResponse(new CartItemsResource($cartItem), 'Item added to cart successfully.', 201);

    }
    public function edit(UpdateCartItemRequest $request)
    {
        $cartItem = $this->service->editItemQuantity($request['cart_item_id'], $request['quantity']);

        if ($cartItem) {
            return $this->successResponse(new CartItemsResource($cartItem), 'Cart item quantity updated successfully.');
        }

        return $this->successResponse(null, 'Cart item removed successfully.');
    }
   
}
