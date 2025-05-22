<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\app\Http\Controllers\ProductController;

Route::prefix('api')->group(function () {
    Route::get('/', function () {
        return response()->json(['module' => 'Product']);
    });
});

Route::apiResource('products', ProductController::class);
