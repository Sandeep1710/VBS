<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatusLog;
use App\Models\Payment;
use App\Services\Payments\PaymentGatewayManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(private readonly PaymentGatewayManager $gateways)
    {
    }

    /**
     * Render the payment screen for a non-COD order.
     * Customers reach this immediately after placing the order.
     */
    public function show(Request $request, Order $order): View|RedirectResponse
    {
        abort_unless($order->user_id === optional($request->user())->id, 403);

        if ($order->payment_status === Order::PAY_PAID) {
            return redirect()->route('checkout.success', $order);
        }
        if ($order->payment_method === 'cod') {
            return redirect()->route('checkout.success', $order);
        }

        $payment = $order->payments()->latest()->firstOrFail();

        // Razorpay handles UPI + Card. Future: route to gateway by method.
        $gateway = $this->gateways->get('razorpay');
        $intent = $gateway->createIntent($order, $payment);

        return view('payment.show', compact('order', 'payment', 'intent'));
    }

    public function callback(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->user_id === optional($request->user())->id, 403);

        $payment = $order->payments()->latest()->firstOrFail();
        $gateway = $this->gateways->get($payment->gateway ?: 'razorpay');

        $result = $gateway->verify($order, $payment, $request->all());

        if (! $result['success']) {
            $payment->forceFill([
                'status' => Payment::STATUS_FAILED,
                'error_message' => $result['error'] ?? 'Verification failed.',
                'response' => $request->all(),
            ])->save();

            return redirect()->route('payment.show', $order)
                ->with('error', $result['error'] ?? 'Payment verification failed.');
        }

        DB::transaction(function () use ($order, $payment, $request, $result) {
            $payment->forceFill([
                'status' => Payment::STATUS_SUCCESS,
                'gateway_payment_id' => $result['payment_id'] ?? null,
                'gateway_signature' => $request->input('razorpay_signature'),
                'paid_at' => now(),
                'response' => $request->all(),
            ])->save();

            $order->forceFill([
                'payment_status' => Order::PAY_PAID,
                'status' => $order->status === Order::STATUS_PENDING ? Order::STATUS_CONFIRMED : $order->status,
                'confirmed_at' => $order->confirmed_at ?? now(),
            ])->save();

            OrderStatusLog::create([
                'order_id' => $order->id,
                'from_status' => Order::STATUS_PENDING,
                'to_status' => Order::STATUS_CONFIRMED,
                'comment' => 'Payment successful via ' . ($payment->gateway ?: 'gateway') . '.',
                'source' => 'payment_gateway',
            ]);
        });

        return redirect()->route('checkout.success', $order)->with('success', 'Payment received.');
    }

    /**
     * Razorpay webhook receiver — for async events (refunds, async captures, etc.)
     */
    public function webhook(Request $request): JsonResponse
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature', '');

        $gateway = $this->gateways->get('razorpay');
        if (! $gateway->verifyWebhook($payload, $signature)) {
            Log::warning('Razorpay webhook signature mismatch', ['ip' => $request->ip()]);
            return response()->json(['ok' => false], 400);
        }

        $event = $request->input('event');
        $entity = $request->input('payload.payment.entity', []);
        $razorpayOrderId = $entity['order_id'] ?? null;

        if ($razorpayOrderId) {
            $payment = Payment::where('gateway_order_id', $razorpayOrderId)->first();
            if ($payment) {
                Log::info('Razorpay webhook', ['event' => $event, 'order' => $payment->order_id]);
                if ($event === 'payment.captured' && $payment->status !== Payment::STATUS_SUCCESS) {
                    $payment->forceFill([
                        'status' => Payment::STATUS_SUCCESS,
                        'gateway_payment_id' => $entity['id'] ?? null,
                        'paid_at' => now(),
                        'response' => $request->all(),
                    ])->save();

                    if ($payment->order && $payment->order->payment_status !== Order::PAY_PAID) {
                        $payment->order->forceFill([
                            'payment_status' => Order::PAY_PAID,
                        ])->save();
                    }
                }
            }
        }

        return response()->json(['ok' => true]);
    }
}
