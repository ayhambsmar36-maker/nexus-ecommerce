<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\Http\Controllers\CartController;
use Modules\Cart\Http\Controllers\CartItemController;
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart', [CartController::class, 'show']);
    Route::delete('/cart/empty/{customer}', [CartController::class, 'destroy']);
    Route::post('/cart/item', [CartItemController::class, 'store']);
    Route::put('/cart/item', [CartItemController::class, 'edit']);
});

