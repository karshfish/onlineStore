<?php

use App\Http\Controllers\product\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products', ProductController::class . '@index');
Route::get('/products/create', ProductController::class . '@createView')->name('products.create');;
Route::get('/products/{id}', ProductController::class . '@show');
