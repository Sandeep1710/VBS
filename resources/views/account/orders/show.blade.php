<x-layouts.account :title="'Order ' . $order->order_number">
    <x-slot:header>Order #{{ $order->order_number }}</x-slot:header>
    <x-slot:subheader>Placed on {{ $order->created_at->format('d M Y, h:i A') }}</x-slot:subheader>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <x-card title="Items">
                <div class="divide-y divide-ink-200/60">
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between py-3 first:pt-0 last:pb-0">
                            <div>
                                <p class="font-medium text-ink-900">{{ $item->product_name }}</p>
                                <p class="text-xs text-ink-500">SKU: {{ $item->product_sku }} · Qty: {{ $item->quantity }}</p>
                                @if($item->exchange_old_battery)
                                    <p class="text-xs font-medium text-green-700">Old battery exchange · -₹{{ number_format((float) $item->exchange_discount * $item->quantity, 2) }}</p>
                                @endif
                            </div>
                            <p class="font-semibold text-ink-900">₹{{ number_format((float) $item->total, 2) }}</p>
                        </div>
                    @endforeach
                </div>
            </x-card>

            <x-card title="Order timeline">
                @if($order->statusLogs->isEmpty())
                    <p class="text-sm text-ink-600">No updates yet.</p>
                @else
                    <ul class="space-y-3">
                        @foreach($order->statusLogs as $log)
                            <li class="flex items-start gap-3">
                                <span class="mt-1.5 h-2.5 w-2.5 rounded-full bg-brand-500"></span>
                                <div>
                                    <p class="text-sm font-medium text-ink-900">{{ ucfirst(str_replace('_', ' ', $log->to_status)) }}</p>
                                    <p class="text-xs text-ink-500">{{ $log->created_at->format('d M Y, h:i A') }}</p>
                                    @if($log->comment)<p class="text-sm text-ink-700">{{ $log->comment }}</p>@endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </x-card>
        </div>

        <div class="space-y-6">
            <x-card title="Summary">
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between"><dt class="text-ink-600">Subtotal</dt><dd class="font-medium text-ink-900">₹{{ number_format((float) $order->subtotal, 2) }}</dd></div>
                    @if((float) $order->discount > 0)
                        <div class="flex justify-between"><dt class="text-ink-600">Discount</dt><dd class="font-medium text-green-700">-₹{{ number_format((float) $order->discount, 2) }}</dd></div>
                    @endif
                    @if((float) $order->exchange_discount > 0)
                        <div class="flex justify-between"><dt class="text-ink-600">Old battery exchange</dt><dd class="font-medium text-green-700">-₹{{ number_format((float) $order->exchange_discount, 2) }}</dd></div>
                    @endif
                    <div class="flex justify-between"><dt class="text-ink-600">Delivery</dt><dd class="font-medium text-ink-900">₹{{ number_format((float) $order->delivery_charge, 2) }}</dd></div>
                    @if((float) $order->tax_amount > 0)
                        <div class="flex justify-between"><dt class="text-ink-600">Tax</dt><dd class="font-medium text-ink-900">₹{{ number_format((float) $order->tax_amount, 2) }}</dd></div>
                    @endif
                    <div class="flex justify-between border-t border-ink-200/60 pt-2 text-base"><dt class="font-semibold text-ink-900">Total</dt><dd class="font-bold text-ink-900">₹{{ number_format((float) $order->total, 2) }}</dd></div>
                </dl>
            </x-card>

            <x-card title="Shipping address">
                <p class="text-sm font-medium text-ink-900">{{ $order->shipping_name }}</p>
                <p class="text-sm text-ink-600">{{ $order->shipping_phone }}</p>
                <p class="mt-2 text-sm text-ink-600">
                    {{ $order->shipping_line1 }}@if($order->shipping_line2), {{ $order->shipping_line2 }}@endif<br>
                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_pincode }}<br>
                    {{ $order->shipping_country }}
                </p>
            </x-card>

            <a href="{{ route('account.orders.invoice', $order) }}" class="btn btn-outline w-full" target="_blank">Download invoice</a>

            @if(in_array($order->status, [\App\Models\Order::STATUS_DELIVERED, \App\Models\Order::STATUS_COMPLETED], true))
                <a href="{{ route('account.returns.create', $order) }}" class="btn btn-outline w-full">Request return</a>
                <a href="{{ route('account.warranty-claims.create', $order) }}" class="btn btn-outline w-full">Claim warranty</a>
            @endif

            @if($order->isCancellable())
                <form method="POST" action="{{ route('account.orders.cancel', $order) }}" onsubmit="return confirm('Cancel this order?')">
                    @csrf @method('PATCH')
                    <input type="hidden" name="reason" value="Cancelled by customer.">
                    <button type="submit" class="btn btn-danger w-full">Cancel order</button>
                </form>
            @endif
        </div>
    </div>
</x-layouts.account>
