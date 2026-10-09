<?php

namespace Modules\Order\Exceptions;

use Exception;
use Illuminate\Http\Request;
use App\Api\ApiResponse;
class OutOfStockException extends Exception {
    use ApiResponse;
     public function __construct(
        public string $productName,
        public int $available,
    ) {
        parent::__construct("المنتج {$productName} غير متوفر بالكمية المطلوبة");
    }
    public function handle(Request $request) {
        if($request->is('api/*')) {
            return $this->errorResponse($this->getMessage(), 400, [
                'product_name' => $this->productName,
                'available' => $this->available
            ]);
        }
    }
}
