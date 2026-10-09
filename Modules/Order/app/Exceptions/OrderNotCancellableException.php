<?php

namespace Modules\Order\Exceptions;

use Exception;
use App\Api\ApiResponse;
use Illuminate\Http\Request;
class OrderNotCancellableException extends Exception {
    use ApiResponse;
        public function __construct(
             string $message,
        ) {
            parent::__construct(" $message ");
        }
        public function handle(Request $request) {
            if($request->is('api/*')) {
                return $this->errorResponse($this->getMessage(), 403);
            }
        }
}
