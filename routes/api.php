<?php

use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\FinderController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\OtpController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\WishlistController as ApiWishlistController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    // Public auth
    Route::post('auth/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('auth/login', [AuthController::class, 'login'])
        ->middleware('throttle:10,1')
        ->name('auth.login');

    // OTP login (passwordless)
    Route::post('auth/otp/send', [OtpController::class, 'send'])
        ->middleware('throttle:6,1')
        ->name('auth.otp.send');
    Route::post('auth/otp/verify', [OtpController::class, 'verify'])
        ->middleware('throttle:6,1')
        ->name('auth.otp.verify');

    // Public catalog
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('brands/{brand:slug}', [BrandController::class, 'show'])->name('brands.show');

    // Delivery check
    Route::get('delivery/check', [\App\Http\Controllers\DeliveryController::class, 'check'])
        ->middleware('throttle:30,1')
        ->name('delivery.check');

    // Battery finder
    Route::prefix('finder')->name('finder.')->group(function () {
        Route::get('types', [FinderController::class, 'types'])->name('types');
        Route::get('brands', [FinderController::class, 'brands'])->name('brands');
        Route::get('models', [FinderController::class, 'models'])->name('models');
        Route::get('variants', [FinderController::class, 'variants'])->name('variants');
    });

    // Authenticated routes (Sanctum)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/me', [AuthController::class, 'me'])->name('auth.me');
        Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

        // Profile
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');

        // Addresses
        Route::apiResource('addresses', AddressController::class);
        Route::patch('addresses/{address}/default', [AddressController::class, 'setDefault'])->name('addresses.default');

        // Wishlist
        Route::get('wishlist', [ApiWishlistController::class, 'index'])->name('wishlist.index');
        Route::post('wishlist/{product:slug}', [ApiWishlistController::class, 'store'])->name('wishlist.store');
        Route::delete('wishlist/{product:slug}', [ApiWishlistController::class, 'destroy'])->name('wishlist.destroy');

        // Cart (mobile app must authenticate; guest carts use the web cookie flow)
        Route::prefix('cart')->name('cart.')->group(function () {
            Route::get('/', [CartController::class, 'show'])->name('show');
            Route::post('items/{product:slug}', [CartController::class, 'add'])->name('add');
            Route::patch('items/{item}', [CartController::class, 'update'])->name('update');
            Route::delete('items/{item}', [CartController::class, 'remove'])->name('remove');
            Route::post('coupon', [CartController::class, 'applyCoupon'])->name('coupon.apply');
            Route::delete('coupon', [CartController::class, 'removeCoupon'])->name('coupon.remove');
        });

        // Orders
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('orders/{order:order_number}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order:order_number}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    });
});
