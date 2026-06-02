<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_number }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>
</head>
<body class="bg-ink-100 p-6 text-ink-800">
    @php
        $siteName = \App\Models\Setting::get('site_name', config('app.name'));
        $email = \App\Models\Setting::get('support_email');
        $phone = \App\Models\Setting::get('support_phone');
        $address = \App\Models\Setting::get('address');
    @endphp

    <div class="mx-auto max-w-3xl">
        <div class="no-print mb-4 flex justify-end gap-3">
            <button onclick="window.print()" class="btn btn-primary">Print / Save PDF</button>
            <a href="{{ route('account.orders.show', $order) }}" class="btn btn-outline">Back to order</a>
        </div>

        <div class="rounded-lg bg-white p-8 shadow-sm ring-1 ring-ink-200/60">
            <div class="flex items-start justify-between border-b border-ink-200 pb-4">
                <div>
                    <h1 class="text-2xl font-bold text-ink-900">{{ $siteName }}</h1>
                    <p class="text-xs text-ink-600">{{ $address }}</p>
                    <p class="text-xs text-ink-600">{{ $email }} · {{ $phone }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs uppercase text-ink-500">Invoice</p>
                    <p class="text-base font-bold text-ink-900">{{ $order->order_number }}</p>
                    <p class="text-xs text-ink-500">{{ $order->created_at->format('d M Y') }}</p>
                    @if($order->payment_status === 'paid')
                        <span class="mt-1 inline-flex rounded-full bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-700">PAID</span>
                    @endif
                </div>
            </div>

            <div class="mt-5 grid grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="text-xs font-semibold uppercase text-ink-500">Bill to</p>
                    <p class="mt-1 font-medium text-ink-900">{{ $order->billing_name }}</p>
                    <p class="text-ink-600">{{ $order->billing_phone }}</p>
                    @if($order->billing_email)<p class="text-ink-600">{{ $order->billing_email }}</p>@endif
                    <p class="text-ink-600">
                        {{ $order->billing_line1 }}@if($order->billing_line2), {{ $order->billing_line2 }}@endif<br>
                        {{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_pincode }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase text-ink-500">Ship to</p>
                    <p class="mt-1 font-medium text-ink-900">{{ $order->shipping_name }}</p>
                    <p class="text-ink-600">{{ $order->shipping_phone }}</p>
                    <p class="text-ink-600">
                        {{ $order->shipping_line1 }}@if($order->shipping_line2), {{ $order->shipping_line2 }}@endif<br>
                        {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_pincode }}
                    </p>
                </div>
            </div>

            <table class="mt-6 w-full text-sm">
                <thead class="border-b border-ink-200 text-left text-xs uppercase text-ink-500">
                    <tr>
                        <th class="py-2">Item</th>
                        <th class="py-2 text-center">Qty</th>
                        <th class="py-2 text-right">Unit price</th>
                        <th class="py-2 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-200/60">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="py-3">
                                <p class="font-medium text-ink-900">{{ $item->product_name }}</p>
                                <p class="text-xs text-ink-500">SKU: {{ $item->product_sku }}</p>
                                @if($item->exchange_old_battery)
                                    <p class="text-xs text-green-700">Old battery exchange (-₹{{ number_format((float) $item->exchange_discount * $item->quantity, 2) }})</p>
                                @endif
                            </td>
                            <td class="py-3 text-center">{{ $item->quantity }}</td>
                            <td class="py-3 text-right">₹{{ number_format((float) ($item->offer_price ?? $item->price), 2) }}</td>
                            <td class="py-3 text-right font-medium">₹{{ number_format((float) $item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 flex justify-end">
                <dl class="w-72 space-y-1 text-sm">
                    <div class="flex justify-between"><dt class="text-ink-600">Subtotal</dt><dd>₹{{ number_format((float) $order->subtotal, 2) }}</dd></div>
                    @if((float) $order->discount > 0)<div class="flex justify-between"><dt class="text-ink-600">Discount{{ $order->coupon_code ? " ({$order->coupon_code})" : '' }}</dt><dd class="text-green-700">-₹{{ number_format((float) $order->discount, 2) }}</dd></div>@endif
                    @if((float) $order->exchange_discount > 0)<div class="flex justify-between"><dt class="text-ink-600">Exchange discount</dt><dd class="text-green-700">-₹{{ number_format((float) $order->exchange_discount, 2) }}</dd></div>@endif
                    <div class="flex justify-between"><dt class="text-ink-600">Delivery</dt><dd>₹{{ number_format((float) $order->delivery_charge, 2) }}</dd></div>
                    @if((float) $order->tax_amount > 0)<div class="flex justify-between"><dt class="text-ink-600">GST</dt><dd>₹{{ number_format((float) $order->tax_amount, 2) }}</dd></div>@endif
                    <div class="flex justify-between border-t border-ink-200 pt-2 text-base font-bold text-ink-900"><dt>Total</dt><dd>₹{{ number_format((float) $order->total, 2) }}</dd></div>
                </dl>
            </div>

            <div class="mt-8 border-t border-ink-200 pt-4 text-xs text-ink-500">
                <p>Payment method: {{ strtoupper($order->payment_method) }} · Status: {{ ucfirst($order->payment_status) }}</p>
                <p class="mt-2">Thanks for shopping with {{ $siteName }}.</p>
            </div>
        </div>
    </div>
</body>
</html>
