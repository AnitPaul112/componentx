<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ShoutoutController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductTagController;
use App\Http\Controllers\AdminRegisterController;
use App\Http\Controllers\LendingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Public routes
Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::get('/search', [WelcomeController::class, 'search'])->name('search.products');
Route::get('/aboutus', function () { return view('aboutus'); })->name('aboutus');
Route::get('/blogs', function () { return view('blogs'); })->name('blogs');
Route::get('/community', function () { return view('community'); })->name('community');
Route::get('/products', [ProductController::class, 'index'])->name('products');

// Product routes
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.details');
Route::get('/product/{id}/image', [ProductController::class, 'show'])->name('product.image');

// Auth routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
    
    // Cart routes with auth middleware
    Route::middleware(['auth'])->group(function () {
        Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
        Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
        Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::patch('/cart/update/{productId}', [CartController::class, 'updateCart'])->name('cart.update');
        Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
        Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
        Route::post('/cart/update-shipping', [CartController::class, 'updateShippingMethod'])->name('cart.updateShippingMethod');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    });
    
    // Blog routes
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create')->middleware('auth');
    Route::post('/blog', [BlogController::class, 'store'])->name('blog.store')->middleware('auth');
    Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.show');
    Route::post('/blog/{blog}/vote', [BlogController::class, 'vote'])->name('blog.vote')->middleware('auth');
    Route::get('/viewblogs', [BlogController::class, 'showBlogs'])->name('viewblogs');

    // Compare routes
    Route::get('/compare', [ProductController::class, 'compare'])->name('compare.index');
    Route::get('/compare/add/{product_id}', [ProductController::class, 'addToCompare'])->name('compare.add');
    Route::get('/compare/remove/{product_id}', [ProductController::class, 'removeFromCompare'])->name('compare.remove');

    // Shoutout routes
    Route::get('/shoutout', [ShoutoutController::class, 'index'])->name('shoutout.index');
    Route::post('/shoutout', [ShoutoutController::class, 'store']);

    // Order routes
    Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/order/confirmation/{order_id}', [OrderController::class, 'orderConfirmation'])->name('order.confirmation');
    Route::get('/my-orders', [OrderController::class, 'index'])->name('my.orders');
    
    // bKash payment routes
    Route::get('/bkash/payment/{order_id}', [OrderController::class, 'showBkashPayment'])->name('bkash.payment');
    Route::post('/bkash/verify/{order_id}', [OrderController::class, 'verifyBkashPayment'])->name('bkash.verify');

    // Favorites routes
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{product}', [FavoriteController::class, 'add'])->name('favorites.add');
    Route::delete('/favorites/{product}', [FavoriteController::class, 'remove'])->name('favorites.remove');

    // Lending routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/lending', [LendingController::class, 'index'])->name('lending.index');
        Route::get('/lending/my-components', [LendingController::class, 'myComponents'])->name('lending.my-components');
        Route::get('/lending/my-requests', [LendingController::class, 'myRequests'])->name('lending.my-requests');
        Route::get('/lending/create', [LendingController::class, 'create'])->name('lending.create');
        Route::post('/lending', [LendingController::class, 'store'])->name('lending.store');
        Route::post('/lending/requests/{request}/{status}', [LendingController::class, 'updateRequestStatus'])->name('lending.update-request-status');
        Route::get('/lending/{component}', [LendingController::class, 'show'])->name('lending.show');
        Route::get('/lending/{component}/request', [LendingController::class, 'request'])->name('lending.request');
        Route::post('/lending/{component}/request', [LendingController::class, 'storeRequest'])->name('lending.store-request');
    });
});

// Admin routes
Route::middleware(['web'])->group(function () {
    // Admin login routes
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
    Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    // Admin registration routes
    Route::get('/admin/register', [AdminRegisterController::class, 'showRegistrationForm'])->name('admin.register');
    Route::post('/admin/register', [AdminRegisterController::class, 'register'])->name('admin.register.submit');

    // Protected admin routes
    Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'viewUsers'])->name('viewUsers');
        Route::get('/users/{id}', [AdminController::class, 'viewUser'])->name('viewUser');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('editUser');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('updateUser');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');
        Route::get('/orders', [AdminController::class, 'showOrders'])->name('orders');
        Route::get('/orders/{order}/details', [AdminController::class, 'showOrderDetails'])->name('order.details');
        Route::put('/order/{orderId}/update-shipping-status', [AdminController::class, 'updateShippingStatus'])->name('updateShippingStatus');
        Route::get('/discounts', [AdminController::class, 'showDiscounts'])->name('discounts');
        Route::post('/discounts', [CouponController::class, 'store'])->name('discount.store');
        Route::delete('/discount/{id}', [CouponController::class, 'destroy'])->name('discount.destroy');

        // Product management routes
        Route::get('/products', [AdminController::class, 'showProducts'])->name('products');
        Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
        Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
        Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
        Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('products.delete');

        // Category management
        Route::resource('categories', ProductCategoryController::class);

        // Tag management
        Route::resource('tags', ProductTagController::class);
    });
});

// Utility routes
Route::get('/clear-cart', function () {
    session()->forget('cart');
    return "Cart cleared!";
});

require __DIR__.'/auth.php';
