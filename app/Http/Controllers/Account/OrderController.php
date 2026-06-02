<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusLog;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('account.orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 403);
        $order->load(['items', 'statusLogs.changedBy', 'latestPayment']);
        return view('account.orders.show', compact('order'));
    }

    public function cancel(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        if (! $order->isCancellable()) {
            return back()->with('error', 'This order can no longer be cancelled.');
        }

        $reason = $request->validate([
            'reason' => ['nullable', 'string', 'max:500'],
        ])['reason'] ?? null;

        DB::transaction(function () use ($order, $request, $reason) {
            $previous = $order->status;

            $order->forceFill([
                'status' => Order::STATUS_CANCELLED,
                'cancelled_at' => now(),
                'cancellation_reason' => $reason,
            ])->save();

            foreach ($order->items as $item) {
                if ($item->product_id) {
                    Product::where('id', $item->product_id)
                        ->update(['stock_quantity' => DB::raw('stock_quantity + ' . (int) $item->quantity)]);
                }
            }

            OrderStatusLog::create([
                'order_id' => $order->id,
                'from_status' => $previous,
                'to_status' => Order::STATUS_CANCELLED,
                'comment' => $reason ?: 'Cancelled by customer.',
                'changed_by' => $request->user()->id,
                'source' => 'customer',
            ]);
        });

        return back()->with('success', 'Order cancelled.');
    }

    public function invoice(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 403);
        $order->load('items');
        return view('account.orders.invoice', compact('order'));
    }
}
