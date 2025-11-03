<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Http\Controllers\Api\UserApiController;
use Modules\Admin\App\Http\Controllers\Api\ProductApiController;
use Modules\Admin\App\Http\Controllers\Api\AnalyticsApiController;

Route::prefix('api/admin')->middleware(['auth:sanctum', 'api.role:admin'])->group(function () {
    
    // User Management API
    Route::prefix('users')->group(function () {
        Route::get('/', [UserApiController::class, 'index'])->name('admin.api.users.index');
        Route::post('/', [UserApiController::class, 'store'])->name('admin.api.users.store');
        Route::get('/statistics', [UserApiController::class, 'statistics'])->name('admin.api.users.statistics');
        Route::get('/roles', [UserApiController::class, 'roles'])->name('admin.api.users.roles');
        Route::post('/bulk-action', [UserApiController::class, 'bulkAction'])->name('admin.api.users.bulk-action');
        Route::get('/{user}', [UserApiController::class, 'show'])->name('admin.api.users.show');
        Route::put('/{user}', [UserApiController::class, 'update'])->name('admin.api.users.update');
        Route::delete('/{user}', [UserApiController::class, 'destroy'])->name('admin.api.users.destroy');
        Route::patch('/{user}/toggle-status', [UserApiController::class, 'toggleStatus'])->name('admin.api.users.toggle-status');
    });

    // Product Management API
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductApiController::class, 'index'])->name('admin.api.products.index');
        Route::post('/', [ProductApiController::class, 'store'])->name('admin.api.products.store');
        Route::get('/statistics', [ProductApiController::class, 'statistics'])->name('admin.api.products.statistics');
        Route::get('/filter-options', [ProductApiController::class, 'filterOptions'])->name('admin.api.products.filter-options');
        Route::post('/bulk-action', [ProductApiController::class, 'bulkAction'])->name('admin.api.products.bulk-action');
        Route::get('/{product}', [ProductApiController::class, 'show'])->name('admin.api.products.show');
        Route::put('/{product}', [ProductApiController::class, 'update'])->name('admin.api.products.update');
        Route::delete('/{product}', [ProductApiController::class, 'destroy'])->name('admin.api.products.destroy');
        Route::patch('/{product}/toggle-status', [ProductApiController::class, 'toggleStatus'])->name('admin.api.products.toggle-status');
        Route::patch('/{product}/update-stock', [ProductApiController::class, 'updateStock'])->name('admin.api.products.update-stock');
    });

    // Analytics and Reporting API
    Route::prefix('analytics')->group(function () {
        Route::get('/overview', [AnalyticsApiController::class, 'overview'])->name('admin.api.analytics.overview');
        Route::get('/sales', [AnalyticsApiController::class, 'sales'])->name('admin.api.analytics.sales');
        Route::get('/customers', [AnalyticsApiController::class, 'customers'])->name('admin.api.analytics.customers');
        Route::get('/products', [AnalyticsApiController::class, 'products'])->name('admin.api.analytics.products');
        Route::get('/vendors', [AnalyticsApiController::class, 'vendors'])->name('admin.api.analytics.vendors');
        Route::post('/generate-report', [AnalyticsApiController::class, 'generateReport'])->name('admin.api.analytics.generate-report');
        Route::get('/reports', [AnalyticsApiController::class, 'reports'])->name('admin.api.analytics.reports');
        Route::get('/reports/{report}/download', [AnalyticsApiController::class, 'downloadReport'])->name('admin.api.analytics.download-report');
    });

    // General admin info
    Route::get('/', function () {
        return response()->json([
            'success' => true,
            'message' => 'Admin API endpoints available',
            'endpoints' => [
                'users' => '/api/admin/users',
                'products' => '/api/admin/products', 
                'analytics' => '/api/admin/analytics'
            ]
        ]);
    })->name('admin.api.index');
});