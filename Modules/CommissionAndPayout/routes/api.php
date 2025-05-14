<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::get('/', function () {
        return response()->json(['module' => 'CommissionAndPayout']);
    });
});