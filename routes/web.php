<?php

use App\Http\Controllers\category\CategoryController;
use App\Http\Controllers\product\ProductController;
use App\Http\Controllers\product\CommentController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/categories');
//Product routes
Route::get('/products', ProductController::class . '@index')->name('products.index');
Route::get('/products/create', ProductController::class . '@createView')->name('products.create');
Route::post('/product/store', ProductController::class . '@store')->name('products.store');
Route::get('/products/{product}', ProductController::class . '@show')->name('products.show');
Route::get('/products/{id}/edit', ProductController::class . '@edit')->name('products.edit');
Route::put('/products/update', ProductController::class . '@update')->name('products.update');
// resource controller for categories
Route::resource('categories', CategoryController::class);
//comments routes it will be for the products only now but it can be used for any model passed to it
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
