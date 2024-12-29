<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminHistoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Client\HomepageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// CLIENT
Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('/detail-product/{id}', [HomepageController::class, 'detailProduct'])->name('detail-product');
Route::get('/cart', [HomepageController::class, 'cart'])->name('cart');
Route::get('/category/{id}', [HomepageController::class, 'category'])->name('category');

// CATEGORY
Route::get('/admin/category', [AdminCategoryController::class, 'index'])->name('category.index');
Route::post('/admin/category', [AdminCategoryController::class, 'store'])->name('category.store');
Route::put('/admin/category/{id}', [AdminCategoryController::class, 'update'])->name('category.update');
Route::delete('/admin/category/{id}', [AdminCategoryController::class, 'destroy'])->name('category.destroy');

// PRODUCT
Route::get('/admin/product', [AdminProductController::class, 'index'])->name('product.index');
route::post('/admin/product', [AdminProductController::class, 'store'])->name('product.store');
route::put('/admin/product/{id}', [AdminProductController::class, 'update'])->name('product.update');
route::delete('/admin/product/{id}', [AdminProductController::class, 'destroy'])->name('product.destroy');

// USER
Route::get('/admin/user', [AdminUserController::class, 'index'])->name('user.index');
route::post('/admin/user', [AdminUserController::class, 'store'])->name('user.store');
route::put('/admin/user/{id}', [AdminUserController::class, 'update'])->name('user.update');
route::delete('/admin/user/{id}', [AdminUserController::class, 'destroy'])->name('user.destroy');

// HISTORY
Route::get('/admin/history', [AdminHistoryController::class, 'index'])->name('history.index');
Route::post('/admin/history', [AdminHistoryController::class, 'store'])->name('history.store');


Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
