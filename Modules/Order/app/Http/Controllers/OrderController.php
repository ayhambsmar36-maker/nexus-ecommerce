<?php

namespace Modules\Order\Http\Controllers;

use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Order\Http\Requests\OrderRequest;
use Modules\Order\Services\OrderService;
use Modules\Order\Transformers\OrderResource;

class OrderController extends Controller
{
    use ApiResponse;
    public function __construct(private OrderService $service)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request) {
        $customer=auth('api')->user();
        $cart=$customer->activeCart()->first();
        if(!$cart){
            return $this->errorResponse("حدث خطا عربة الشراء غير موجودة",400);
        }
        $dataOrder=$this->service->createOrder($request->validated(),$cart);
        return $this->successResponse(new OrderResource($dataOrder),"تم انشاء الطلب بنجاح",201);
    }
    public function show(int $orderId){
        $order=$this->service->getOrderById($orderId);
        return $order ? $this->successResponse(new OrderResource($order),"تم جلب الطلب بنجاح") : $this->errorResponse("الطلب غير موجود",404);
    }
    public function index(){
        $orders=$this->service->getOrdersForCustomer();
        return  $this->successResponse(OrderResource::collection($orders),"تم جلب الطلبات بنجاح");
    }
    public function cancel(int $orderId){
        $order=$this->service->cancelOrder($orderId);
        return $this->successResponse(new OrderResource($order),"تم الغاء الطلب بنجاح");
    }
}
