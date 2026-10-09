<?php

use Illuminate\Support\Facades\Route;

use Modules\Catalog\Http\Controllers\CategoreyController;
use Modules\Catalog\Http\Controllers\ProductController;

Route::apiresource('categories', CategoreyController::class)->only(['index', 'show']);
Route::apiresource('products', ProductController::class)->only(['index', 'show']);
