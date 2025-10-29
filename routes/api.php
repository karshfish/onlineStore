<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;
// use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;


Route::middleware(['throttle:60,1'])->group(function () {
    Route::apiResource('APIproducts', ProductApiController::class);
    Route::apiResource('categories', CategoryApiController::class)->only(['index', 'show']);
});
