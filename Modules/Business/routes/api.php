<?php

use Illuminate\Support\Facades\Route;
use Modules\Business\App\Http\Controllers\VendorOrderController;

Route::prefix('api')->group(function () {
    Route::get('/', function () {
        return response()->json(['module' => 'Business']);
    });
    
    // Vendor API Routes
    Route::middleware(['auth:sanctum', 'vendor'])->prefix('vendor')->group(function () {
        Route::get('/orders', [VendorOrderController::class, 'index']);
        Route::get('/orders/{order}', [VendorOrderController::class, 'show']);
        Route::patch('/orders/{order}/status', [VendorOrderController::class, 'updateStatus']);
        Route::patch('/orders/{order}/fulfillment', [VendorOrderController::class, 'markReadyForFulfillment']);
        Route::get('/orders/stats/dashboard', [VendorOrderController::class, 'getStats']);
    });
});