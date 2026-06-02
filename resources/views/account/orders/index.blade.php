<x-layouts.account :title="'My Orders'">
    <x-slot:header>My orders</x-slot:header>

    @if($orders->isEmpty())
        <x-card>
            <div class="p-12 text-center">
                <p class="text-sm text-ink-600">You haven't placed any orders yet.</p>
                <a href="{{ url('/products') }}" class="mt-3 inline-flex btn btn-primary">Shop batteries</a>
            </div>
        </x-card>
    @else
        <x-card padding="p-0">
            <div class="divide-y divide-ink-200/60">
                @foreach($orders as $order)
                    <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <p class="text-sm font-semibold text-ink-900">{{ $order->order_number }}</p>
                                <span class="badge bg-ink-100 text-ink-800">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                                @if($order->payment_status === 'paid')
                                    <span class="badge bg-green-100 text-green-700">Paid</span>
                                @elseif($order->payment_status === 'pending')
                                    <span class="badge bg-amber-100 text-amber-700">Payment pending</span>
                                @endif
                            </div>
                            <p class="mt-1 text-xs text-ink-500">{{ $order->created_at->format('d M Y, h:i A') }} · {{ $order->items->sum('quantity') }} item(s) · {{ ucfirst($order->payment_method) }}</p>
                            <p class="mt-1 text-sm text-ink-700">
                                @foreach($order->items as $item)
                                    <span>{{ $item->quantity }}× {{ Str::limit($item->product_name, 40) }}</span>@if(! $loop->last) · @endif
                                @endforeach
                            </p>
                        </div>
                        <div class="flex items-center gap-3 text-right">
                            <p class="text-base font-semibold text-ink-900">₹{{ number_format((float) $order->total, 2) }}</p>
                            <a href="{{ route('account.orders.show', $order) }}" class="btn btn-outline text-xs">View</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</x-layouts.account>
