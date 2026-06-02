<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderReturn;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderReturnController extends Controller
{
    public function create(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 403);
        abort_unless(in_array($order->status, [
            Order::STATUS_DELIVERED, Order::STATUS_COMPLETED,
        ], true), 422, 'This order is not eligible for return yet.');

        $order->loadMissing('items');
        return view('account.returns.create', compact('order'));
    }

    public function store(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'order_item_id' => [
                'required', 'integer',
                Rule::exists('order_items', 'id')->where('order_id', $order->id),
            ],
            'quantity' => ['required', 'integer', 'min:1'],
            'reason' => ['required', 'string', Rule::in(array_keys(OrderReturn::REASONS))],
            'details' => ['nullable', 'string', 'max:2000'],
        ]);

        $item = OrderItem::findOrFail($data['order_item_id']);
        if ($data['quantity'] > $item->quantity) {
            return back()->withErrors(['quantity' => 'Quantity cannot exceed what you ordered.'])->withInput();
        }

        OrderReturn::create([
            'order_id' => $order->id,
            'order_item_id' => $item->id,
            'user_id' => $request->user()->id,
            'quantity' => $data['quantity'],
            'reason' => $data['reason'],
            'details' => $data['details'] ?? null,
            'status' => OrderReturn::STATUS_REQUESTED,
        ]);

        return redirect()->route('account.orders.show', $order)
            ->with('success', 'Return request submitted. Our team will review and respond within 2 business days.');
    }
}
