<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminHistoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminPromoController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Client\HomepageController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Customer;
use App\Http\Middleware\Employee;
use App\Http\Controllers\Employee\OrderController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    Route::get('/promo', [AdminPromoController::class, 'edit'])->name('promo.edit');
    Route::put('/promo', [AdminPromoController::class, 'update'])->name('promo.update');
    
    // Add order management routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{id}/done', [OrderController::class, 'markAsDone'])->name('orders.done');

    // Add notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unreadCount');
});

// CLIENT Routes
Route::middleware(['auth', Customer::class])->group(function () {
    Route::get('/', [HomepageController::class, 'index'])->name('home');
    Route::get('/detail-product/{id}', [HomepageController::class, 'detailProduct'])->name('detail-product');
    Route::get('/category/{id}', [HomepageController::class, 'category'])->name('category');
    Route::get('/cart', [HomepageController::class, 'cart'])->name('cart');
    Route::post('/cart/{id}', [HomepageController::class, 'cartStore'])->name('cart.store');
    Route::post('/midtrans/finish', [HomepageController::class, 'finish'])->name('finish');
    Route::post('/cart/update/{id}', [HomepageController::class, 'updateQuantity'])->name('update-cart');
    Route::delete('/cart/{id}', [HomepageController::class, 'removeFromCart'])->name('remove-from-cart');
    Route::get('/search', [HomepageController::class, 'search'])->name('search');
    Route::get('/my-orders', [HomepageController::class, 'myOrders'])->name('my-orders');
    Route::get('/order-detail/{id}', [HomepageController::class, 'orderDetail'])->name('order-detail');
});

Route::middleware('auth')->group(function () {
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Notification routes
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);
});

// Test notification route
Route::get('/test-notification', function() {
    $user = Auth::user();
    $user->notify(new \App\Notifications\NewOrderNotification([
        'message' => 'This is a test notification',
        'link' => '/employee/orders',
        'type' => 'system'
    ]));
    return 'Notification sent!';
})->middleware('auth');

require __DIR__ . '/auth.php';
