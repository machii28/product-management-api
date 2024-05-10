<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use Orion\Facades\Orion;

Orion::resource('products', ProductController::class);

Route::post('/product/{product}/purchase', [InventoryController::class, 'purchase']);
Route::post('/product/{product}/return', [InventoryController::class, 'return']);
