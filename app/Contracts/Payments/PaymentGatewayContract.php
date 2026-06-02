<?php

namespace App\Contracts\Payments;

use App\Models\Order;
use App\Models\Payment;

interface PaymentGatewayContract
{
    /**
     * The gateway identifier (e.g. 'razorpay', 'stripe', 'cod').
     */
    public function name(): string;

    /**
     * Create a gateway-side order/intent and return data the client needs
     * to complete payment (e.g. Razorpay order_id + key for the SDK).
     *
     * @return array<string, mixed>
     */
    public function createIntent(Order $order, Payment $payment): array;

    /**
     * Verify the gateway response after a payment attempt.
     *
     * @param  array<string, mixed>  $data  Raw input from the gateway callback / client
     * @return array{success: bool, payment_id?: string, error?: string}
     */
    public function verify(Order $order, Payment $payment, array $data): array;

    /**
     * Verify a webhook signature (or no-op for gateways that don't need it).
     */
    public function verifyWebhook(string $payload, string $signature): bool;

    /**
     * Issue a refund. Optional — not all gateways support it via API.
     *
     * @return array{success: bool, refund_id?: string, error?: string}
     */
    public function refund(Payment $payment, float $amount): array;
}
