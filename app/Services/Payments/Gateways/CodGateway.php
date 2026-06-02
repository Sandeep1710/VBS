<?php

namespace App\Services\Payments\Gateways;

use App\Contracts\Payments\PaymentGatewayContract;
use App\Models\Order;
use App\Models\Payment;

class CodGateway implements PaymentGatewayContract
{
    public function name(): string
    {
        return 'cod';
    }

    public function createIntent(Order $order, Payment $payment): array
    {
        // No external intent — payment is collected on delivery
        return [
            'gateway' => 'cod',
            'order_number' => $order->order_number,
            'amount' => (float) $order->total,
            'instructions' => 'Pay in cash at the time of delivery.',
        ];
    }

    public function verify(Order $order, Payment $payment, array $data): array
    {
        // COD is verified by the delivery flow, not an external gateway
        return ['success' => true, 'payment_id' => 'cod-' . $order->order_number];
    }

    public function verifyWebhook(string $payload, string $signature): bool
    {
        return false;
    }

    public function refund(Payment $payment, float $amount): array
    {
        return ['success' => false, 'error' => 'COD refunds are processed manually.'];
    }
}
