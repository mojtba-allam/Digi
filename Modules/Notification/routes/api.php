<?php

use Illuminate\Support\Facades\Route;
use Modules\Notification\app\Http\Controllers\NotificationController;

        Route::apiResource('notifications', NotificationController::class);