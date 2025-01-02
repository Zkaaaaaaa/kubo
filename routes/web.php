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

Route::middleware('auth')->group(function () {
    
    // CLIENT Routes
    Route::get('/', [HomepageController::class, 'index'])->name('home');
    
    Route::middleware([Customer::class])->group(function () {
        Route::get('/detail-product/{id}', [HomepageController::class, 'detailProduct'])->name('detail-product');
        Route::get('/cart', [HomepageController::class, 'cart'])->name('cart');
        Route::post('/cart/{id}', [HomepageController::class, 'cartStore'])->name('cart.store');
        Route::get('/category/{id}', [HomepageController::class, 'category'])->name('category');
        Route::get('/checkout', [HomepageController::class, 'checkout'])->name('checkout');
        Route::post('/checkout', [HomepageController::class, 'checkoutStore'])->name('checkout.store');
    });

    // ADMIN Routes
    Route::middleware([Admin::class])->group(function () {
        // Dashboard
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // USER Management
        Route::resource('admin/user', AdminUserController::class)->except(['show']);
    });

    // EMPLOYEE Routes
    Route::middleware([Employee::class])->group(function () {
        // Dashboard (same for Admin & Employee)
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // CATEGORY Management
        Route::resource('admin/category', AdminCategoryController::class)->except(['show']);
        
        // PRODUCT Management
        Route::resource('admin/product', AdminProductController::class)->except(['show']);

        // HISTORY Management
        Route::resource('admin/history', AdminHistoryController::class)->only(['index', 'store']);
    });

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php'; 
