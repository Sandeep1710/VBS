<x-layouts.app :title="'Order received | Trikuti Battery'">
    <div class="mx-auto max-w-2xl">
        <x-card padding="p-8">
            <div class="text-center">
                <div class="mx-auto grid h-16 w-16 place-items-center rounded-full bg-green-100 text-green-600">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m5 13 4 4L19 7"/></svg>
                </div>
                <h1 class="mt-4 text-2xl font-bold text-ink-900">Order received!</h1>
                <p class="mt-2 text-sm text-ink-600">Thanks for choosing us. Our team will call you within <strong>4 working hours</strong> at <strong>{{ $order->billing_phone }}</strong> to confirm the battery model and schedule delivery.</p>
            </div>

            <dl class="mt-6 grid gap-4 rounded-lg bg-ink-50 p-4 text-sm sm:grid-cols-2">
                <div>
                    <dt class="text-xs uppercase text-ink-500">Order number</dt>
                    <dd class="mt-0.5 font-semibold text-ink-900">{{ $order->order_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase text-ink-500">Estimated total</dt>
                    <dd class="mt-0.5 font-semibold text-ink-900">₹{{ number_format((float) $order->total, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase text-ink-500">Payment</dt>
                    <dd class="mt-0.5 font-semibold text-ink-900">Cash on Delivery</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase text-ink-500">Items</dt>
                    <dd class="mt-0.5 font-semibold text-ink-900">{{ $order->items->sum('quantity') }} battery item(s)</dd>
                </div>
            </dl>

            @if($order->exchange_pickup_required)
                <div class="mt-4 rounded-lg bg-green-50 p-3 text-sm text-green-800 ring-1 ring-green-200">
                    Please keep your old battery ready for pickup at the time of delivery.
                </div>
            @endif

            <div class="mt-6 rounded-lg bg-blue-50 p-4 text-sm text-blue-900 ring-1 ring-blue-200">
                <p class="font-semibold">📞 Need to reach us first?</p>
                <p class="mt-1">Call or WhatsApp <a href="tel:{{ \App\Models\Setting::get('support_phone') }}" class="font-bold underline">{{ \App\Models\Setting::get('support_phone', '+91 9920971479') }}</a> — we're available Mon–Sat, 9 AM – 8 PM.</p>
            </div>

            <div class="mt-6 flex flex-wrap justify-center gap-3">
                <a href="{{ route('account.orders.show', $order) }}" class="btn btn-primary">View order details</a>
                <a href="{{ url('/products') }}" class="btn btn-outline">Continue shopping</a>
            </div>
        </x-card>
    </div>
</x-layouts.app>
