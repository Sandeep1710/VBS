<?php

namespace App\Services\Payments\Gateways;

use App\Contracts\Payments\PaymentGatewayContract;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Stripe gateway — uses Stripe PaymentIntents for the international card flow.
 *
 * Configure keys via env (STRIPE_SECRET, STRIPE_PUBLIC, STRIPE_WEBHOOK_SECRET)
 * or the `payment` settings group. Without keys, runs in DEMO mode the same
 * way Razorpay does so screenshots / tests still work end-to-end.
 *
 * For production, install the official `stripe/stripe-php` SDK and replace
 * the raw HTTP calls with the typed client.
 */
class StripeGateway implements PaymentGatewayContract
{
    public function name(): string
    {
        return 'stripe';
    }

    public function createIntent(Order $order, Payment $payment): array
    {
        $secret = $this->secretKey();
        $public = $this->publicKey();
        $amount = (int) round((float) $order->total * 100); // smallest currency unit

        if (! $secret || ! $public) {
            $fakeId = 'pi_demo_' . Str::random(24);
            $payment->forceFill([
                'gateway' => 'stripe',
                'gateway_order_id' => $fakeId,
            ])->save();

            return [
                'demo' => true,
                'client_secret' => $fakeId . '_secret_demo',
                'public_key' => 'demo',
                'amount' => $amount,
                'currency' => 'inr',
                'message' => 'Stripe keys not configured. Running in DEMO mode.',
            ];
        }

        $response = Http::withToken($secret)
            ->asForm()
            ->post('https://api.stripe.com/v1/payment_intents', [
                'amount' => $amount,
                'currency' => 'inr',
                'description' => "Order {$order->order_number}",
                'metadata[order_id]' => (string) $order->id,
                'metadata[payment_id]' => (string) $payment->id,
                'automatic_payment_methods[enabled]' => 'true',
            ]);

        if ($response->failed()) {
            Log::error('Stripe PaymentIntent creation failed', ['body' => $response->body()]);
            throw new \RuntimeException('Could not start payment: ' . $response->json('error.message', 'unknown error'));
        }

        $body = $response->json();
        $payment->forceFill([
            'gateway' => 'stripe',
            'gateway_order_id' => $body['id'],
        ])->save();

        return [
            'client_secret' => $body['client_secret'],
            'public_key' => $public,
            'gateway_order_id' => $body['id'],
            'amount' => $amount,
            'currency' => 'inr',
        ];
    }

    public function verify(Order $order, Payment $payment, array $data): array
    {
        $intentId = $data['payment_intent'] ?? null;
        if (! $intentId) {
            return ['success' => false, 'error' => 'Missing payment_intent.'];
        }
        if ($intentId !== $payment->gateway_order_id) {
            return ['success' => false, 'error' => 'Intent mismatch.'];
        }

        $secret = $this->secretKey();
        if (! $secret) {
            // Demo mode — accept
            return ['success' => true, 'payment_id' => $intentId];
        }

        $response = Http::withToken($secret)
            ->get("https://api.stripe.com/v1/payment_intents/{$intentId}");

        if ($response->failed()) {
            return ['success' => false, 'error' => $response->json('error.message', 'Verification failed.')];
        }

        $intent = $response->json();
        if (($intent['status'] ?? null) !== 'succeeded') {
            return ['success' => false, 'error' => 'Payment not yet captured (status: ' . ($intent['status'] ?? '?') . ').'];
        }

        return ['success' => true, 'payment_id' => $intent['id']];
    }

    public function verifyWebhook(string $payload, string $signature): bool
    {
        $secret = $this->webhookSecret();
        if (! $secret) {
            return false;
        }

        // Stripe-Signature header format: t=<timestamp>,v1=<hex>
        $parts = [];
        foreach (explode(',', $signature) as $piece) {
            [$k, $v] = array_pad(explode('=', $piece, 2), 2, null);
            $parts[$k] = $v;
        }
        $timestamp = $parts['t'] ?? null;
        $expectedV1 = $parts['v1'] ?? null;
        if (! $timestamp || ! $expectedV1) {
            return false;
        }

        $signed = $timestamp . '.' . $payload;
        $computed = hash_hmac('sha256', $signed, $secret);

        return hash_equals($computed, $expectedV1);
    }

    public function refund(Payment $payment, float $amount): array
    {
        $secret = $this->secretKey();
        if (! $secret || ! $payment->gateway_payment_id) {
            return ['success' => false, 'error' => 'Refund unavailable in current configuration.'];
        }

        $response = Http::withToken($secret)
            ->asForm()
            ->post('https://api.stripe.com/v1/refunds', [
                'payment_intent' => $payment->gateway_payment_id,
                'amount' => (int) round($amount * 100),
            ]);

        if ($response->failed()) {
            return ['success' => false, 'error' => $response->json('error.message', 'Refund failed.')];
        }

        return ['success' => true, 'refund_id' => $response->json('id')];
    }

    private function secretKey(): ?string
    {
        return env('STRIPE_SECRET') ?: Setting::get('stripe_secret', null, 'payment');
    }

    private function publicKey(): ?string
    {
        return env('STRIPE_PUBLIC') ?: Setting::get('stripe_public', null, 'payment');
    }

    private function webhookSecret(): ?string
    {
        return env('STRIPE_WEBHOOK_SECRET') ?: Setting::get('stripe_webhook_secret', null, 'payment');
    }
}
