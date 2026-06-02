<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderStatusLog;
use App\Models\Payment;
use App\Services\Orders\OrderStatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use RuntimeException;

class OrderController extends AdminController
{
    public function __construct(private readonly OrderStatusService $statusService)
    {
    }

    public function index(Request $request): View
    {
        $query = Order::with('user', 'items')->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($payment = $request->input('payment_status')) {
            $query->where('payment_status', $payment);
        }
        if ($q = trim((string) $request->input('q'))) {
            $query->where(function ($b) use ($q) {
                $b->where('order_number', 'like', "%$q%")
                    ->orWhere('billing_name', 'like', "%$q%")
                    ->orWhere('billing_email', 'like', "%$q%")
                    ->orWhere('billing_phone', 'like', "%$q%");
            });
        }

        $orders = $query->paginate(50)->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'statuses' => Order::statuses(),
            'paymentStatuses' => [Order::PAY_PENDING, Order::PAY_PAID, Order::PAY_FAILED, Order::PAY_REFUNDED],
        ]);
    }

    public function show(Order $order): View
    {
        $order->load(['items', 'user', 'statusLogs.changedBy', 'payments', 'coupon']);
        return view('admin.orders.show', [
            'order' => $order,
            'nextOptions' => $this->statusService->nextOptions($order),
        ]);
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string'],
            'comment' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $this->statusService->changeStatus($order, $data['status'], $request->user(), $data['comment'] ?? null);
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Order status updated.');
    }

    public function markPaid(Request $request, Order $order): RedirectResponse
    {
        $this->statusService->markPaymentReceived($order, $request->user());
        return back()->with('success', 'Payment marked as received.');
    }

    public function refund(Request $request, Order $order): RedirectResponse
    {
        if ($order->payment_status !== Order::PAY_PAID) {
            return back()->with('error', 'Only paid orders can be refunded.');
        }

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:' . (float) $order->total],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($order, $request, $data) {
            $order->forceFill(['payment_status' => Order::PAY_REFUNDED])->save();

            if ($payment = $order->payments()->latest()->first()) {
                $payment->forceFill(['status' => Payment::STATUS_REFUNDED])->save();
            }

            OrderStatusLog::create([
                'order_id' => $order->id,
                'from_status' => $order->status,
                'to_status' => $order->status,
                'comment' => 'Refund of ₹' . number_format((float) $data['amount'], 2) . ($data['notes'] ? ' — ' . $data['notes'] : ''),
                'changed_by' => $request->user()->id,
                'source' => 'admin',
            ]);
        });

        return back()->with('success', 'Refund recorded.');
    }

    public function invoice(Order $order): View
    {
        $order->load('items');
        return view('admin.orders.invoice', compact('order'));
    }
}
