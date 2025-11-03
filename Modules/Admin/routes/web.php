<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Http\Controllers\AdminController;
use Modules\Admin\App\Http\Controllers\UserController;
use Modules\Admin\App\Http\Controllers\OrderController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('users/bulk-action', [UserController::class, 'bulkAction'])->name('users.bulk-action');
    
    // Products Management (placeholder for future implementation)
    Route::get('products', function () {
        return view('admin.products.index');
    })->name('products.index');
    Route::get('products/create', function () {
        return view('admin.products.create');
    })->name('products.create');
    
    // Orders Management
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('orders/bulk-update-status', [OrderController::class, 'bulkUpdateStatus'])->name('orders.bulk-update-status');
    Route::get('orders/export', [OrderController::class, 'export'])->name('orders.export');
    Route::get('orders/stats', [OrderController::class, 'getStats'])->name('orders.stats');
    
    // Analytics (placeholder for future implementation)
    Route::get('analytics', function () {
        return view('admin.analytics.index');
    })->name('analytics.index');
    
    // Additional placeholders for sidebar routes
    Route::get('roles', function () {
        return redirect()->route('admin.users.index');
    })->name('roles.index');
    Route::get('categories', function () {
        return redirect()->route('admin.products.index');
    })->name('categories.index');
    Route::get('brands', function () {
        return redirect()->route('admin.products.index');
    })->name('brands.index');
    Route::get('vendors', function () {
        return view('admin.vendors.index');
    })->name('vendors.index');
    Route::get('settings', function () {
        return view('admin.settings.index');
    })->name('settings.index');
});