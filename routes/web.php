<?php

use App\Http\Controllers\product\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products', ProductController::class . '@index')->name('products.index');
Route::get('/products/create', ProductController::class . '@createView')->name('products.create');
Route::post('/product/store', ProductController::class . '@store')->name('products.store');
Route::get('/products/{id}', ProductController::class . '@show')->name('products.show');
Route::get('/products/{id}/edit', ProductController::class . '@edit')->name('products.edit');
Route::put('/products/update', ProductController::class . '@update')->name('products.update');
