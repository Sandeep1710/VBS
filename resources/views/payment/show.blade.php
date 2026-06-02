<x-layouts.app :title="'Complete payment - ' . $order->order_number">
    <div class="mx-auto max-w-xl">
        <x-card padding="p-7">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-ink-900">Complete your payment</h1>
                <p class="mt-1 text-sm text-ink-600">Order <span class="font-mono font-semibold">{{ $order->order_number }}</span></p>
            </div>

            <dl class="mt-6 grid gap-2 rounded-lg bg-ink-50 p-4 text-sm">
                <div class="flex justify-between"><dt class="text-ink-600">Amount due</dt><dd class="text-base font-bold text-ink-900">₹{{ number_format((float) $order->total, 2) }}</dd></div>
                <div class="flex justify-between"><dt class="text-ink-600">Method</dt><dd class="font-medium text-ink-900">{{ strtoupper($order->payment_method) }}</dd></div>
            </dl>

            @if(! empty($intent['demo']))
                <div class="mt-4 rounded-lg bg-amber-50 p-4 text-sm text-amber-900 ring-1 ring-amber-200">
                    <p class="font-semibold">Demo mode</p>
                    <p class="text-xs">Razorpay keys are not configured. Click "Complete payment" to simulate a successful charge.</p>
                </div>

                <form method="POST" action="{{ route('payment.callback', $order) }}" class="mt-5">
                    @csrf
                    <input type="hidden" name="razorpay_order_id" value="{{ $intent['gateway_order_id'] }}">
                    <input type="hidden" name="razorpay_payment_id" value="pay_demo_{{ Str::random(14) }}">
                    <input type="hidden" name="razorpay_signature" value="demo">
                    <x-button type="submit" class="w-full">Complete payment (demo)</x-button>
                </form>
            @else
                <div id="razorpay-config"
                     data-key="{{ $intent['key'] }}"
                     data-order-id="{{ $intent['gateway_order_id'] }}"
                     data-amount="{{ $intent['amount'] }}"
                     data-name="{{ \App\Models\Setting::get('site_name', config('app.name')) }}"
                     data-description="Order {{ $order->order_number }}"
                     data-prefill-name="{{ $order->billing_name }}"
                     data-prefill-email="{{ $order->billing_email }}"
                     data-prefill-phone="{{ $order->billing_phone }}"
                     data-callback-url="{{ route('payment.callback', $order) }}"
                     data-csrf="{{ csrf_token() }}">
                </div>

                <button id="pay-now" type="button" class="btn btn-primary mt-5 w-full">Pay ₹{{ number_format((float) $order->total, 2) }}</button>

                @push('head')
                    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                    <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const cfg = document.getElementById('razorpay-config').dataset;
                        const btn = document.getElementById('pay-now');
                        btn.addEventListener('click', () => {
                            const rzp = new Razorpay({
                                key: cfg.key,
                                amount: parseInt(cfg.amount, 10),
                                currency: 'INR',
                                name: cfg.name,
                                description: cfg.description,
                                order_id: cfg.orderId,
                                prefill: {
                                    name: cfg.prefillName,
                                    email: cfg.prefillEmail,
                                    contact: cfg.prefillPhone,
                                },
                                handler: (response) => {
                                    const form = document.createElement('form');
                                    form.method = 'POST';
                                    form.action = cfg.callbackUrl;
                                    const fields = {
                                        _token: cfg.csrf,
                                        razorpay_order_id: response.razorpay_order_id,
                                        razorpay_payment_id: response.razorpay_payment_id,
                                        razorpay_signature: response.razorpay_signature,
                                    };
                                    for (const [k, v] of Object.entries(fields)) {
                                        const input = document.createElement('input');
                                        input.type = 'hidden';
                                        input.name = k;
                                        input.value = v;
                                        form.appendChild(input);
                                    }
                                    document.body.appendChild(form);
                                    form.submit();
                                },
                                theme: { color: '#dc2626' },
                            });
                            rzp.open();
                        });
                    });
                    </script>
                @endpush
            @endif

            <p class="mt-4 text-center text-xs text-ink-500">
                Want to switch to Cash on Delivery?
                <a href="{{ route('account.orders.show', $order) }}" class="font-medium text-brand-600 hover:underline">Contact support</a>
            </p>
        </x-card>
    </div>
</x-layouts.app>
