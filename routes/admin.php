<?php

use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BatteryBrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderReturnController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PincodeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\WarrantyClaimController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminLoginController::class, 'create'])->name('login');
        Route::post('login', [AdminLoginController::class, 'store'])->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('logout', [AdminLoginController::class, 'destroy'])->name('logout');
        Route::get('/', DashboardController::class)->name('dashboard');

        // Catalog
        Route::resource('products', ProductController::class)->except(['show']);
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('brands', BatteryBrandController::class)->except(['show'])->parameters(['brands' => 'brand']);

        // Sales
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order:order_number}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order:order_number}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
        Route::post('orders/{order:order_number}/mark-paid', [OrderController::class, 'markPaid'])->name('orders.mark-paid');
        Route::post('orders/{order:order_number}/refund', [OrderController::class, 'refund'])->name('orders.refund');
        Route::get('orders/{order:order_number}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');

        Route::resource('coupons', CouponController::class)->except(['show']);

        Route::get('returns', [OrderReturnController::class, 'index'])->name('returns.index');
        Route::patch('returns/{return}', [OrderReturnController::class, 'update'])->name('returns.update');

        Route::get('warranty-claims', [WarrantyClaimController::class, 'index'])->name('warranty-claims.index');
        Route::patch('warranty-claims/{claim}', [WarrantyClaimController::class, 'update'])->name('warranty-claims.update');

        // Customers + Reviews
        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');

        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::patch('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
        Route::patch('reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

        // Home page sections
        Route::resource('banners', BannerController::class)->except(['show']);
        Route::resource('testimonials', TestimonialController::class)->except(['show']);
        Route::resource('faqs', FaqController::class)->except(['show'])->parameters(['faqs' => 'faq']);

        // Settings
        Route::resource('pincodes', PincodeController::class)->except(['show']);

        // Static pages
        Route::get('pages', [PageController::class, 'index'])->name('pages.index');
        Route::put('pages/{slug}', [PageController::class, 'update'])->name('pages.update');
    });
});
