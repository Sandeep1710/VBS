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
 * Razorpay gateway — uses the standard Orders API + checkout flow.
 *
 * Configure keys via the `payment` settings group, env vars, or both:
 *   RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET, RAZORPAY_WEBHOOK_SECRET
 *
 * If keys are missing, the gateway runs in DEMO mode — it generates a
 * fake gateway_order_id so the storefront flow still works for screenshots
 * and tests. Replace with the official `razorpay/razorpay` SDK in production.
 */
class RazorpayGateway implements PaymentGatewayContract
{
    public function name(): string
    {
        return 'razorpay';
    }

    public function createIntent(Order $order, Payment $payment): array
    {
        $keyId = $this->keyId();
        $keySecret = $this->keySecret();
        $amountPaise = (int) round((float) $order->total * 100);

        if (! $keyId || ! $keySecret) {
            // Demo mode — useful in dev / tests
            $fakeId = 'order_demo_' . Str::random(14);
            $payment->forceFill([
                'gateway' => 'razorpay',
                'gateway_order_id' => $fakeId,
            ])->save();

            return [
                'demo' => true,
                'key' => 'demo',
                'gateway_order_id' => $fakeId,
                'amount' => $amountPaise,
                'currency' => 'INR',
                'order_number' => $order->order_number,
                'message' => 'Razorpay keys not configured. Running in DEMO mode.',
            ];
        }

        $response = Http::withBasicAuth($keyId, $keySecret)
            ->acceptJson()
            ->asJson()
            ->post('https://api.razorpay.com/v1/orders', [
                'amount' => $amountPaise,
                'currency' => 'INR',
                'receipt' => $order->order_number,
                'notes' => [
                    'order_id' => (string) $order->id,
                    'payment_id' => (string) $payment->id,
                ],
            ]);

        if ($response->failed()) {
            Log::error('Razorpay order creation failed', ['body' => $response->body()]);
            throw new \RuntimeException('Could not start payment: ' . $response->json('error.description', 'unknown error'));
        }

        $body = $response->json();
        $payment->forceFill([
            'gateway' => 'razorpay',
            'gateway_order_id' => $body['id'],
        ])->save();

        return [
            'key' => $keyId,
            'gateway_order_id' => $body['id'],
            'amount' => $amountPaise,
            'currency' => 'INR',
            'order_number' => $order->order_number,
        ];
    }

    public function verify(Order $order, Payment $payment, array $data): array
    {
        $expected = $payment->gateway_order_id;
        $razorpayOrderId = $data['razorpay_order_id'] ?? null;
        $razorpayPaymentId = $data['razorpay_payment_id'] ?? null;
        $signature = $data['razorpay_signature'] ?? null;

        if (! $razorpayOrderId || ! $razorpayPaymentId || ! $signature) {
            return ['success' => false, 'error' => 'Missing payment data.'];
        }

        if ($razorpayOrderId !== $expected) {
            return ['success' => false, 'error' => 'Order mismatch.'];
        }

        $secret = $this->keySecret();
        if (! $secret) {
            // Demo mode: accept any non-empty signature
            return ['success' => true, 'payment_id' => $razorpayPaymentId];
        }

        $expectedSig = hash_hmac('sha256', $razorpayOrderId . '|' . $razorpayPaymentId, $secret);
        if (! hash_equals($expectedSig, $signature)) {
            return ['success' => false, 'error' => 'Invalid signature.'];
        }

        return ['success' => true, 'payment_id' => $razorpayPaymentId];
    }

    public function verifyWebhook(string $payload, string $signature): bool
    {
        $secret = $this->webhookSecret();
        if (! $secret) {
            return false;
        }
        return hash_equals(hash_hmac('sha256', $payload, $secret), $signature);
    }

    public function refund(Payment $payment, float $amount): array
    {
        $keyId = $this->keyId();
        $keySecret = $this->keySecret();
        if (! $keyId || ! $keySecret || ! $payment->gateway_payment_id) {
            return ['success' => false, 'error' => 'Refund unavailable in current configuration.'];
        }

        $response = Http::withBasicAuth($keyId, $keySecret)
            ->acceptJson()
            ->asJson()
            ->post("https://api.razorpay.com/v1/payments/{$payment->gateway_payment_id}/refund", [
                'amount' => (int) round($amount * 100),
            ]);

        if ($response->failed()) {
            return ['success' => false, 'error' => $response->json('error.description', 'Refund failed.')];
        }

        return ['success' => true, 'refund_id' => $response->json('id')];
    }

    private function keyId(): ?string
    {
        return env('RAZORPAY_KEY_ID') ?: Setting::get('razorpay_key_id', null, 'payment');
    }

    private function keySecret(): ?string
    {
        return env('RAZORPAY_KEY_SECRET') ?: Setting::get('razorpay_key_secret', null, 'payment');
    }

    private function webhookSecret(): ?string
    {
        return env('RAZORPAY_WEBHOOK_SECRET') ?: Setting::get('razorpay_webhook_secret', null, 'payment');
    }
}
