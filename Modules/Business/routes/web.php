<?php

use Illuminate\Support\Facades\Route;
use Modules\Business\App\Http\Controllers\VendorOrderController;

Route::get('/', function () {
    return view('Business::welcome');
});

// Vendor Order Management Routes
Route::middleware(['auth', 'vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/orders', [VendorOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [VendorOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [VendorOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('/orders/{order}/fulfillment', [VendorOrderController::class, 'markReadyForFulfillment'])->name('orders.fulfillment');
    Route::get('/orders/stats/dashboard', [VendorOrderController::class, 'getStats'])->name('orders.stats');
});