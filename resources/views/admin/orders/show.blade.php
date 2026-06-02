<x-layouts.admin :title="'Order ' . $order->order_number" :header="'Order ' . $order->order_number" :subheader="$order->created_at->format('d M Y, h:i A')">
    <x-slot:actions>
        <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" class="btn btn-outline">Invoice</a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline">← Back</a>
    </x-slot:actions>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_360px]">
        <div class="space-y-6">
            {{-- Items --}}
            <x-card title="Items">
                <div class="-m-6">
                    <table class="w-full text-sm">
                        <thead class="bg-ink-50 text-left text-xs uppercase text-ink-500">
                            <tr>
                                <th class="px-6 py-3">Product</th>
                                <th class="px-6 py-3 text-center">Qty</th>
                                <th class="px-6 py-3 text-right">Price</th>
                                <th class="px-6 py-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-ink-200/60">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="px-6 py-3">
                                        <p class="font-medium text-ink-900">{{ $item->product_name }}</p>
                                        <p class="text-xs text-ink-500">{{ $item->product_sku }} · {{ $item->product_brand }}</p>
                                        @if($item->exchange_old_battery)<span class="badge bg-green-100 text-green-700">Exchange ₹{{ number_format((float) $item->exchange_discount, 0) }}</span>@endif
                                    </td>
                                    <td class="px-6 py-3 text-center">{{ $item->quantity }}</td>
                                    <td class="px-6 py-3 text-right">₹{{ number_format((float) ($item->offer_price ?? $item->price), 0) }}</td>
                                    <td class="px-6 py-3 text-right font-semibold">₹{{ number_format((float) $item->total, 0) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>

            {{-- Totals --}}
            <x-card title="Order summary">
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between"><dt class="text-ink-600">Subtotal</dt><dd>₹{{ number_format((float) $order->subtotal, 2) }}</dd></div>
                    @if((float) $order->exchange_discount > 0)
                        <div class="flex justify-between"><dt class="text-ink-600">Exchange discount</dt><dd class="text-green-700">-₹{{ number_format((float) $order->exchange_discount, 2) }}</dd></div>
                    @endif
                    @if((float) $order->discount > 0)
                        <div class="flex justify-between"><dt class="text-ink-600">Coupon ({{ $order->coupon_code }})</dt><dd class="text-green-700">-₹{{ number_format((float) $order->discount, 2) }}</dd></div>
                    @endif
                    <div class="flex justify-between"><dt class="text-ink-600">Delivery</dt><dd>{{ (float) $order->delivery_charge > 0 ? '₹' . number_format((float) $order->delivery_charge, 2) : 'Free' }}</dd></div>
                    @if((float) $order->tax_amount > 0)
                        <div class="flex justify-between"><dt class="text-ink-600">Tax</dt><dd>₹{{ number_format((float) $order->tax_amount, 2) }}</dd></div>
                    @endif
                    <div class="flex justify-between border-t border-ink-200/60 pt-2 text-base font-semibold"><dt>Total</dt><dd>₹{{ number_format((float) $order->total, 2) }}</dd></div>
                </dl>
            </x-card>

            {{-- Status log --}}
            <x-card title="Status history">
                <ol class="relative space-y-3 border-l-2 border-ink-200 pl-5">
                    @foreach($order->statusLogs as $log)
                        <li class="relative">
                            <span class="absolute -left-[26px] top-1 grid h-4 w-4 place-items-center rounded-full bg-brand-600 ring-2 ring-white"></span>
                            <p class="text-sm">
                                @if($log->from_status)
                                    <span class="text-ink-500">{{ ucfirst($log->from_status) }}</span>
                                    <span class="mx-1 text-ink-400">→</span>
                                @endif
                                <span class="font-semibold text-ink-900">{{ ucfirst($log->to_status) }}</span>
                            </p>
                            @if($log->comment)<p class="text-xs text-ink-600">{{ $log->comment }}</p>@endif
                            <p class="text-xs text-ink-400">{{ $log->created_at->format('d M Y, h:i A') }} · {{ $log->source }}{{ $log->changedBy ? ' (' . $log->changedBy->name . ')' : '' }}</p>
                        </li>
                    @endforeach
                </ol>
            </x-card>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            {{-- Status actions --}}
            <x-card title="Status & payment">
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-ink-500">Current status</p>
                        <p class="mt-1 font-semibold text-ink-900">{{ ucfirst($order->status) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-ink-500">Payment</p>
                        <p class="mt-1 font-semibold text-ink-900">{{ ucfirst($order->payment_status) }} ({{ strtoupper($order->payment_method) }})</p>
                    </div>

                    @if($nextOptions)
                        <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="space-y-2 border-t border-ink-200/60 pt-3">
                            @csrf
                            <x-label value="Move to next status" />
                            <select name="status" class="input">
                                @foreach($nextOptions as $opt)
                                    <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="comment" placeholder="Comment (optional)" maxlength="500" class="input">
                            <button type="submit" class="btn btn-primary w-full">Update status</button>
                        </form>
                    @endif

                    @if($order->payment_status !== 'paid' && $order->payment_status !== 'refunded')
                        <form method="POST" action="{{ route('admin.orders.mark-paid', $order) }}" class="border-t border-ink-200/60 pt-3">
                            @csrf
                            <button type="submit" class="btn btn-outline w-full">Mark payment received</button>
                        </form>
                    @endif

                    @if($order->payment_status === 'paid')
                        <details class="border-t border-ink-200/60 pt-3">
                            <summary class="cursor-pointer text-sm font-medium text-red-600">Issue refund</summary>
                            <form method="POST" action="{{ route('admin.orders.refund', $order) }}" class="mt-3 space-y-2">
                                @csrf
                                <x-input name="amount" type="number" step="0.01" min="1" :value="$order->total" placeholder="Amount" required />
                                <input type="text" name="notes" placeholder="Refund reason" maxlength="500" class="input">
                                <button type="submit" class="btn btn-danger w-full">Confirm refund</button>
                            </form>
                        </details>
                    @endif
                </div>
            </x-card>

            <x-card title="Customer">
                <p class="text-sm font-semibold text-ink-900">{{ $order->billing_name }}</p>
                @if($order->user)
                    <a href="{{ route('admin.customers.show', $order->user) }}" class="text-xs text-brand-600 hover:underline">View customer →</a>
                @endif
                <p class="mt-2 text-xs text-ink-600">{{ $order->billing_phone }}</p>
                @if($order->billing_email)<p class="text-xs text-ink-600">{{ $order->billing_email }}</p>@endif
            </x-card>

            <x-card title="Shipping address">
                <p class="text-sm">{{ $order->shipping_name }}</p>
                <p class="text-xs text-ink-600">{{ $order->shipping_phone }}</p>
                <p class="mt-1 text-xs text-ink-600">
                    {{ $order->shipping_line1 }}@if($order->shipping_line2), {{ $order->shipping_line2 }}@endif<br>
                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_pincode }}
                </p>
            </x-card>

            @if($order->notes)
                <x-card title="Customer notes">
                    <p class="text-sm text-ink-700">{{ $order->notes }}</p>
                </x-card>
            @endif
        </div>
    </div>
</x-layouts.admin>
