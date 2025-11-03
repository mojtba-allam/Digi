<?php

use Illuminate\Support\Facades\Route;
use Modules\Notification\app\Http\Controllers\NotificationController;
use Modules\Notification\app\Http\Controllers\EmailNotificationController;

Route::apiResource('notifications', NotificationController::class);

// Email notification routes
Route::prefix('email-notifications')->group(function () {
    Route::post('order-confirmation', [EmailNotificationController::class, 'sendOrderConfirmation']);
    Route::post('user-registration', [EmailNotificationController::class, 'sendUserRegistration']);
    Route::post('password-reset', [EmailNotificationController::class, 'sendPasswordReset']);
    Route::post('vendor-order-notification', [EmailNotificationController::class, 'sendVendorOrderNotification']);
    Route::post('bulk-emails', [EmailNotificationController::class, 'sendBulkEmails']);
    Route::post('test-configuration', [EmailNotificationController::class, 'testEmailConfiguration']);
});