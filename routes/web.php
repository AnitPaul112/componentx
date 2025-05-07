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
Route::get('/product/{product_id}', function($product_id) {
    $product = DB::table('products')->where('product_id', $product_id)->first();
    if (!$product) { abort(404, 'Product not found'); }
    return view('productdetails', compact('product'));
})->name('product.details');
Route::get('/product/{id}/image', [ProductController::class, 'show'])->name('product.image');

// Auth routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
    
    // Cart routes
    Route::post('/product/{product}/add-to-cart', [CartController::class, 'addToCart'])->name('product.add-to-cart');
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
    Route::get('/cart/remove/{product_id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/update/{product_id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('update-shipping-method', [CartController::class, 'updateShippingMethod'])->name('cart.updateShippingMethod');
    Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
    
    // Blog routes
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
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
    
    // Favorite routes
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{productId}', [FavoriteController::class, 'addToFavorites'])->name('favorites.add');
    Route::delete('/favorites/{productId}', [FavoriteController::class, 'removeFromFavorites'])->name('favorites.remove');
});

// Admin routes
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'viewUsers'])->name('admin.viewUsers');
    Route::get('admin/users/{id}', [AdminController::class, 'viewUser'])->name('admin.viewUser');
    Route::get('admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.editUser');
    Route::put('admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.updateUser');
    Route::delete('admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
    Route::get('/admin/orders', [AdminController::class, 'showOrders'])->name('admin.orders');
    Route::get('/admin/orders/{order}/details', [AdminController::class, 'showOrderDetails'])->name('admin.order.details');
    Route::put('admin/order/{orderId}/update-shipping-status', [AdminController::class, 'updateShippingStatus'])->name('admin.updateShippingStatus');
    Route::get('/admin/discounts', [AdminController::class, 'showDiscounts'])->name('admin.discounts');
    Route::post('/discounts', [CouponController::class, 'store'])->name('discount.store');
    Route::delete('/discount/{id}', [CouponController::class, 'destroy'])->name('discount.destroy');

    // Category management
    Route::resource('categories', ProductCategoryController::class);
    
    // Tag management
    Route::resource('tags', ProductTagController::class);
});

// Utility routes
Route::get('/clear-cart', function () {
    session()->forget('cart');
    return "Cart cleared!";
});

require __DIR__.'/auth.php';
