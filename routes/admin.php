<?php

use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BatteryBrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TestimonialController;
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

        // Home page sections
        Route::resource('banners', BannerController::class)->except(['show']);
        Route::resource('testimonials', TestimonialController::class)->except(['show']);
        Route::resource('faqs', FaqController::class)->except(['show'])->parameters(['faqs' => 'faq']);

        // Static pages (About Us + Contact Us)
        Route::get('pages', [PageController::class, 'index'])->name('pages.index');
        Route::put('pages/{slug}', [PageController::class, 'update'])->name('pages.update');
    });
});
