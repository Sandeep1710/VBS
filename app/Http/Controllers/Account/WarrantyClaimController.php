<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\WarrantyClaim;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WarrantyClaimController extends Controller
{
    public function create(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 403);
        abort_unless(in_array($order->status, [
            Order::STATUS_DELIVERED, Order::STATUS_COMPLETED,
        ], true), 422, 'This order is not eligible for a warranty claim.');

        $order->loadMissing('items');
        return view('account.warranty-claims.create', compact('order'));
    }

    public function store(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'order_item_id' => [
                'required', 'integer',
                Rule::exists('order_items', 'id')->where('order_id', $order->id),
            ],
            'issue_type' => ['required', 'string', Rule::in(array_keys(WarrantyClaim::ISSUE_TYPES))],
            'description' => ['required', 'string', 'min:20', 'max:5000'],
        ]);

        $item = OrderItem::findOrFail($data['order_item_id']);
        if ($item->warranty_ends_at && $item->warranty_ends_at->isPast()) {
            return back()->withErrors(['order_item_id' => 'Warranty has expired for this item.'])->withInput();
        }

        WarrantyClaim::create([
            'order_id' => $order->id,
            'order_item_id' => $item->id,
            'user_id' => $request->user()->id,
            'issue_type' => $data['issue_type'],
            'description' => $data['description'],
            'status' => WarrantyClaim::STATUS_SUBMITTED,
        ]);

        return redirect()->route('account.orders.show', $order)
            ->with('success', 'Warranty claim submitted. Our team will reach out within 3 business days.');
    }
}
