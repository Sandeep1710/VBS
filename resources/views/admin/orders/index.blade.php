<x-layouts.admin :title="'Orders'" :header="'Orders'" :subheader="$orders->total() . ' total'">
    <form method="GET" class="card mb-4 grid gap-3 p-4 md:grid-cols-5">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search order #, name, email, phone" class="input md:col-span-2">
        <select name="status" class="input">
            <option value="">All statuses</option>
            @foreach($statuses as $s)
                <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <select name="payment_status" class="input">
            <option value="">Any payment</option>
            @foreach($paymentStatuses as $p)
                <option value="{{ $p }}" @selected(request('payment_status') === $p)>{{ ucfirst($p) }}</option>
            @endforeach
        </select>
        <div class="flex gap-2">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline">Clear</a>
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="datatable" data-no-init>
                <colgroup>
                    <col style="width: 150px">
                    <col>
                    <col style="width: 130px">
                    <col style="width: 110px">
                    <col style="width: 130px">
                    <col style="width: 120px">
                    <col style="width: 140px">
                    <col style="width: 100px">
                </colgroup>
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th class="text-right">Total</th>
                        <th class="text-center">Items</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Payment</th>
                        <th>Placed</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="font-mono text-xs font-semibold text-ink-900">{{ $order->order_number }}</td>
                            <td>
                                <p class="font-medium text-ink-900">{{ $order->billing_name }}</p>
                                <p class="text-xs text-ink-500">{{ $order->billing_phone }}</p>
                            </td>
                            <td class="text-right font-semibold text-ink-900">₹{{ number_format((float) $order->total, 0) }}</td>
                            <td class="text-center text-ink-700">{{ $order->items->sum('quantity') }}</td>
                            <td class="text-center">
                                <span class="badge {{ match($order->status) {
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'confirmed' => 'bg-blue-100 text-blue-700',
                                    'dispatched' => 'bg-indigo-100 text-indigo-700',
                                    'delivered' => 'bg-green-100 text-green-700',
                                    'completed' => 'bg-emerald-100 text-emerald-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    default => 'bg-ink-100 text-ink-700',
                                } }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ match($order->payment_status) {
                                    'paid' => 'bg-green-100 text-green-700',
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'failed' => 'bg-red-100 text-red-700',
                                    'refunded' => 'bg-ink-100 text-ink-700',
                                    default => 'bg-ink-100 text-ink-700',
                                } }}">{{ ucfirst($order->payment_status) }}</span>
                            </td>
                            <td class="whitespace-nowrap text-xs text-ink-500">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="table-action-edit">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-4 py-12 text-center text-ink-500">No orders found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">{{ $orders->links() }}</div>
    </div>
</x-layouts.admin>
