<?php

use App\Http\Controllers\Account\AddressController;
use App\Http\Controllers\Account\DashboardController;
use App\Http\Controllers\Account\OrderController;
use App\Http\Controllers\Account\OrderReturnController;
use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\Account\ReviewController;
use App\Http\Controllers\Account\WarrantyClaimController;
use App\Http\Controllers\Account\WishlistController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'customer'])->prefix('account')->name('account.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('password', [ProfileController::class, 'passwordEdit'])->name('password.edit');
    Route::patch('password', [ProfileController::class, 'passwordUpdate'])->name('password.update');

    Route::resource('addresses', AddressController::class)->except(['show']);
    Route::patch('addresses/{address}/default', [AddressController::class, 'setDefault'])->name('addresses.default');

    Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('wishlist/{product:slug}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('wishlist/{product:slug}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order:order_number}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order:order_number}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('orders/{order:order_number}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');

    Route::get('orders/{order:order_number}/return', [OrderReturnController::class, 'create'])->name('returns.create');
    Route::post('orders/{order:order_number}/return', [OrderReturnController::class, 'store'])->name('returns.store');
    Route::get('orders/{order:order_number}/warranty-claim', [WarrantyClaimController::class, 'create'])->name('warranty-claims.create');
    Route::post('orders/{order:order_number}/warranty-claim', [WarrantyClaimController::class, 'store'])->name('warranty-claims.store');

    Route::post('reviews/{product:slug}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});
