<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\FinderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cms/{slug}', [HomeController::class, 'cmsPage'])->name('cms.show');

// SEO
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

// Delivery check (used by PDP + checkout)
Route::get('/delivery/check', [DeliveryController::class, 'check'])
    ->middleware('throttle:30,1')
    ->name('delivery.check');

// Catalog
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{category:slug}', [ProductController::class, 'category'])->name('categories.show');
Route::get('/brands/{brand:slug}', [ProductController::class, 'brand'])->name('brands.show');

// Battery finder
Route::prefix('finder')->name('finder.')->group(function () {
    Route::get('/', [FinderController::class, 'index'])->name('index');
    Route::post('/', [FinderController::class, 'submit'])->name('submit');
    Route::get('/brands', [FinderController::class, 'brands'])->name('brands');
    Route::get('/models', [FinderController::class, 'models'])->name('models');
    Route::get('/variants', [FinderController::class, 'variants'])->name('variants');
});

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product:slug}', [CartController::class, 'add'])->name('add');
    Route::patch('/items/{item}', [CartController::class, 'update'])->name('update');
    Route::delete('/items/{item}', [CartController::class, 'remove'])->name('remove');
    Route::post('/coupon', [CartController::class, 'applyCoupon'])->name('coupon.apply');
    Route::delete('/coupon', [CartController::class, 'removeCoupon'])->name('coupon.remove');
});

// Checkout (verified email required so we can confirm the order)
Route::middleware(['auth', 'customer', 'verified'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order:order_number}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Payment (post-checkout, before success — non-COD only)
    Route::get('/payment/{order:order_number}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order:order_number}/callback', [PaymentController::class, 'callback'])->name('payment.callback');
});

// Razorpay webhook (no auth, signed via webhook secret)
Route::post('/webhooks/razorpay', [PaymentController::class, 'webhook'])->name('webhooks.razorpay');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])
    ->middleware('throttle:6,1')
    ->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])
    ->name('newsletter.unsubscribe');

require __DIR__ . '/auth.php';
require __DIR__ . '/account.php';
require __DIR__ . '/admin.php';

// Catch-all 301 / 302 redirects (admin-managed via /admin/redirects).
// Runs only when no other route matches, replacing what would be a 404.
Route::fallback(function (\Illuminate\Http\Request $request) {
    if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
        abort(404);
    }
    if (! \Illuminate\Support\Facades\Schema::hasTable('redirects')) {
        abort(404);
    }
    $path = '/' . ltrim($request->path(), '/');
    $rule = \App\Models\Redirect::where('from_path', $path)
        ->where('is_active', true)
        ->first();
    if (! $rule) {
        abort(404);
    }
    \App\Models\Redirect::where('id', $rule->id)->update([
        'hits' => \DB::raw('hits + 1'),
        'last_hit_at' => now(),
    ]);
    return redirect($rule->to_path, $rule->status_code);
});
