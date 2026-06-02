<?php

namespace App\Http\Controllers\Admin;

use App\Models\OrderReturn;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderReturnController extends AdminController
{
    public function index(Request $request): View
    {
        $query = OrderReturn::with('order', 'user', 'orderItem')->latest();
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        $returns = $query->paginate(30)->withQueryString();
        return view('admin.returns.index', [
            'returns' => $returns,
            'statuses' => [OrderReturn::STATUS_REQUESTED, OrderReturn::STATUS_APPROVED, OrderReturn::STATUS_REJECTED, OrderReturn::STATUS_PICKED_UP, OrderReturn::STATUS_REFUNDED],
        ]);
    }

    public function update(Request $request, OrderReturn $return): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in([OrderReturn::STATUS_REQUESTED, OrderReturn::STATUS_APPROVED, OrderReturn::STATUS_REJECTED, OrderReturn::STATUS_PICKED_UP, OrderReturn::STATUS_REFUNDED])],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
            'refund_amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        $updates = [
            'status' => $data['status'],
            'admin_notes' => $data['admin_notes'] ?? $return->admin_notes,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ];

        if ($data['status'] === OrderReturn::STATUS_REFUNDED) {
            $updates['refunded_at'] = now();
            if (isset($data['refund_amount'])) {
                $updates['refund_amount'] = $data['refund_amount'];
            }
        }

        $return->update($updates);
        return back()->with('success', 'Return updated.');
    }
}
