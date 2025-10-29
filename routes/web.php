<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\category\CategoryController;
use App\Http\Controllers\product\ProductController;
use App\Http\Controllers\product\CommentController;
use Illuminate\Support\Facades\Route;
//breeze routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//custome routes for the app
Route::redirect('/', '/categories');
//Product routes
Route::get('/products', ProductController::class . '@index')->name('products.index');
Route::get('/products/create', ProductController::class . '@createView')->name('products.create');
Route::post('/product/store', ProductController::class . '@store')->name('products.store');
Route::get('/products/{product}', ProductController::class . '@show')->name('products.show');
Route::get('/products/{id}/edit', ProductController::class . '@edit')->name('products.edit');
Route::put('/products/update', ProductController::class . '@update')->name('products.update');
Route::delete('delete/products/{id}', ProductController::class . '@destroy')->name('products.destroy')->middleware(['auth', 'role:admin']);
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('trash/products', [ProductController::class, 'trash'])->name('products.trash');
    Route::post('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
});

// resource controller for categories
Route::resource('categories', CategoryController::class);
Route::patch('admin/categories/{id}/restore', [CategoryController::class, 'restore'])
    ->name('admin.categories.restore')
    ->middleware(['auth', 'role:admin']);
//comments routes it will be for the products only now but it can be used for any model passed to it
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
require __DIR__ . '/auth.php';
