<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminSalesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Public Storefront Routes
Route::get('/', [StorefrontController::class, 'index'])->name('storefront.index');
Route::get('/dashboard', function () {
    return redirect()->route('storefront.index');
})->name('dashboard');
Route::get('/products/{product}', [StorefrontController::class, 'show'])->name('storefront.show');

// Customer Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/topup', [TopUpController::class, 'index'])->name('topups.index');
    Route::post('/topup', [TopUpController::class, 'store'])->name('topups.store');

    Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/complete', [UserOrderController::class, 'complete'])->name('orders.complete');
});

// General Auth Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Protected Routes
Route::middleware(['auth', CheckRole::class.':admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('products.index', ['products' => App\Models\Product::all()]); // redirect to products for now
    })->name('admin.dashboard');
    
    Route::resource('admin/products', ProductController::class);

    Route::get('/admin/topups', [TopUpController::class, 'adminIndex'])->name('admin.topups.index');
    Route::patch('/admin/topups/{topup}/approve', [TopUpController::class, 'approve'])->name('admin.topups.approve');
    Route::patch('/admin/topups/{topup}/reject', [TopUpController::class, 'reject'])->name('admin.topups.reject');

    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::patch('/admin/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');

    Route::get('/admin/sales', [AdminSalesController::class, 'index'])->name('admin.sales.index');
});

require __DIR__.'/auth.php';
