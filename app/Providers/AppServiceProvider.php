<?php

namespace App\Providers;

use App\Contracts\Notifications\SmsGatewayContract;
use App\Contracts\Notifications\WhatsAppGatewayContract;
use App\Services\Notifications\LogSmsGateway;
use App\Services\Notifications\LogWhatsAppGateway;
use App\Services\Payments\Gateways\CodGateway;
use App\Services\Payments\Gateways\RazorpayGateway;
use App\Services\Payments\Gateways\StripeGateway;
use App\Services\Payments\PaymentGatewayManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Notification gateways (replace with Twilio / MSG91 / Meta Cloud API etc. in prod)
        $this->app->singleton(SmsGatewayContract::class, LogSmsGateway::class);
        $this->app->singleton(WhatsAppGatewayContract::class, LogWhatsAppGateway::class);

        // Payment gateway registry
        $this->app->singleton(PaymentGatewayManager::class, function ($app) {
            $manager = new PaymentGatewayManager($app);
            $manager->register('cod', CodGateway::class);
            $manager->register('razorpay', RazorpayGateway::class);
            $manager->register('stripe', StripeGateway::class);
            // 'upi' and 'card' default to Razorpay (handles both UPI + card).
            // Switch the default by editing PaymentController::show().
            return $manager;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
