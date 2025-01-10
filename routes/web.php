<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminHistoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Client\HomepageController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Customer;
use App\Http\Middleware\Employee;
use Illuminate\Support\Facades\Route;
// ADMIN Routes
Route::middleware(['auth', Admin::class])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('user', AdminUserController::class)->except(['show']);
});

// EMPLOYEE Routes
Route::middleware(['auth', Employee::class])->name('employee.')->prefix('employee')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('category', AdminCategoryController::class)->except(['show']);
    Route::resource('product', AdminProductController::class)->except(['show']);
    Route::resource('history', AdminHistoryController::class)->only(['index', 'store']);
});

// CLIENT Routes
Route::middleware(['auth', Customer::class])->group(function () {
    Route::get('/', [HomepageController::class, 'index'])->name('home');
    Route::get('/detail-product/{id}', [HomepageController::class, 'detailProduct'])->name('detail-product');
    Route::get('/cart', [HomepageController::class, 'cart'])->name('cart');
    Route::post('/cart/{id}', [HomepageController::class, 'cartStore'])->name('cart.store');
    Route::get('/category/{id}', [HomepageController::class, 'category'])->name('category');
    Route::get('/checkout', [HomepageController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [HomepageController::class, 'checkoutStore'])->name('checkout.store');
});

Route::middleware('auth')->group(function () {
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
