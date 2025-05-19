<?php

use Illuminate\Support\Facades\Route;
use Modules\Reaction\app\Http\Controllers\ReviewController;
use Modules\Reaction\app\Http\Controllers\RatingController;



Route::apiResource('reviews', ReviewController::class);

Route::apiResource('ratings', RatingController::class);