<?php

use Illuminate\Support\Facades\Route;
use Modules\List\app\Http\Controllers\WishlistController;
use Modules\List\app\Http\Controllers\WishlistItemController;

Route::prefix('api')->group(function () {
    Route::get('/', function () {
        return response()->json(['module' => 'List']);
    });
});

Route::apiResource('wishlists', WishlistController::class);
Route::apiResource('wishlist-items', WishlistItemController::class);