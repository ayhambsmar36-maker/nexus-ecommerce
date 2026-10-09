<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\OrderController;

Route::middleware(['auth:sanctum'])->prefix('orders')->group(function () {
    Route::post('/', [OrderController::class, 'store']);
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/{orderId}', [OrderController::class, 'show']);
    Route::post('/{orderId}/cancel', [OrderController::class, 'cancel']);//->middleware('throttle:1,60');
});
