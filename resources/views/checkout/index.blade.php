<x-layouts.app :title="'Checkout | Vehicle Battery Store'">
    <h1 class="text-2xl font-bold text-ink-900 sm:text-3xl">Checkout</h1>
    <p class="mt-1 text-sm text-ink-600">Review your order and place it.</p>

    <x-validation-errors class="mt-5" />

    <form method="POST" action="{{ route('checkout.store') }}" class="mt-6 grid gap-6 lg:grid-cols-[minmax(0,1fr)_360px]">
        @csrf

        <div class="space-y-6">
            {{-- Address selection --}}
            <x-card title="Delivery address">
                @if($addresses->isEmpty())
                    <p class="text-sm text-ink-600">You don't have any saved addresses yet.</p>
                    <a href="{{ route('account.addresses.create') }}" class="mt-3 inline-flex btn btn-primary">+ Add address</a>
                @else
                    <div class="space-y-3">
                        @foreach($addresses as $address)
                            <label class="block cursor-pointer rounded-lg border p-4 transition-colors {{ ($address->is_default && ! old('address_id')) || (int) old('address_id') === $address->id ? 'border-brand-500 bg-brand-50/40 ring-2 ring-brand-500/20' : 'border-ink-200 hover:bg-ink-50' }}">
                                <div class="flex items-start gap-3">
                                    <input type="radio" name="address_id" value="{{ $address->id }}" @checked(((int) old('address_id', $address->is_default ? $address->id : 0)) === $address->id) class="mt-1 h-4 w-4 border-ink-300 text-brand-600 focus:ring-brand-500" required>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-semibold text-ink-900">{{ $address->name }}</span>
                                            <span class="badge bg-ink-100 text-ink-700">{{ $address->label }}</span>
                                            @if($address->is_default)<span class="badge bg-green-100 text-green-700">Default</span>@endif
                                        </div>
                                        <p class="text-xs text-ink-600">{{ $address->phone }}</p>
                                        <p class="mt-1 text-sm text-ink-700">{{ $address->full_address }}</p>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('account.addresses.create') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">+ Add new address</a>
                    </div>
                @endif
                <x-input-error for="address_id" />
            </x-card>

            {{-- Payment method (driven by admin settings) --}}
            <x-card title="Payment & confirmation">
                @php
                    $methods = collect([
                        ['cod', 'Cash on Delivery', 'Pay when your battery is delivered to your doorstep.', \App\Models\Setting::get('cod_enabled', false, 'payment')],
                        ['upi', 'UPI', 'Pay via Google Pay, PhonePe, Paytm, etc.', \App\Models\Setting::get('upi_enabled', false, 'payment')],
                        ['card', 'Credit / Debit Card', 'Visa, Mastercard, RuPay accepted.', \App\Models\Setting::get('card_enabled', false, 'payment')],
                    ])->filter(fn ($m) => (bool) $m[3])->values();
                    $defaultMethod = $methods->first()[0] ?? 'cod';
                @endphp

                <div class="space-y-3">
                    @foreach($methods as [$key, $label, $desc, $_enabled])
                        <label class="block cursor-pointer rounded-lg border p-4 transition-colors {{ old('payment_method', $defaultMethod) === $key ? 'border-brand-500 bg-brand-50/40 ring-2 ring-brand-500/20' : 'border-ink-200 hover:bg-ink-50' }}">
                            <div class="flex items-start gap-3">
                                <input type="radio" name="payment_method" value="{{ $key }}" @checked(old('payment_method', $defaultMethod) === $key) class="mt-1 h-4 w-4 border-ink-300 text-brand-600 focus:ring-brand-500" required>
                                <div>
                                    <p class="text-sm font-semibold text-ink-900">{{ $label }}</p>
                                    <p class="text-xs text-ink-600">{{ $desc }}</p>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
                <x-input-error for="payment_method" />

                <div class="mt-3 rounded-lg bg-blue-50 p-3 text-xs text-blue-800 ring-1 ring-blue-200">
                    <p class="font-semibold">📞 What happens next?</p>
                    <p class="mt-1">After you place the order, our team will call you within 4 hours at <strong>{{ \App\Models\Setting::get('support_phone', '+91 9920971479') }}</strong> to confirm the battery model, delivery slot, and final amount.</p>
                </div>
            </x-card>

            <x-card title="Order notes (optional)">
                <textarea name="notes" rows="3" maxlength="1000" placeholder="Anything we should know about delivery?" class="input">{{ old('notes') }}</textarea>
                <x-input-error for="notes" />
            </x-card>
        </div>

        {{-- Order summary --}}
        <aside class="space-y-4 lg:sticky lg:top-20 lg:self-start">
            <x-card title="Your order">
                <ul class="divide-y divide-ink-200/60 text-sm">
                    @foreach($cart->items as $item)
                        <li class="flex items-start justify-between gap-3 py-2 first:pt-0 last:pb-0">
                            <div class="min-w-0">
                                <p class="line-clamp-2 font-medium text-ink-900">{{ $item->product?->name }}</p>
                                <p class="text-xs text-ink-500">
                                    Qty: {{ $item->quantity }}
                                    @if($item->exchange_old_battery) · with exchange @endif
                                </p>
                            </div>
                            <p class="shrink-0 font-medium text-ink-900">₹{{ number_format($item->line_total, 2) }}</p>
                        </li>
                    @endforeach
                </ul>

                <dl class="mt-4 space-y-2 border-t border-ink-200/60 pt-4 text-sm">
                    <div class="flex justify-between"><dt class="text-ink-600">Subtotal</dt><dd class="font-medium text-ink-900">₹{{ number_format((float) $cart->subtotal, 2) }}</dd></div>
                    @if((float) $cart->exchange_discount > 0)
                        <div class="flex justify-between"><dt class="text-ink-600">Exchange discount</dt><dd class="font-medium text-green-700">-₹{{ number_format((float) $cart->exchange_discount, 2) }}</dd></div>
                    @endif
                    @if((float) $cart->discount > 0)
                        <div class="flex justify-between"><dt class="text-ink-600">Coupon ({{ $cart->coupon_code }})</dt><dd class="font-medium text-green-700">-₹{{ number_format((float) $cart->discount, 2) }}</dd></div>
                    @endif
                    <div class="flex justify-between"><dt class="text-ink-600">Delivery</dt><dd class="font-medium text-ink-900">{{ (float) $cart->delivery_charge > 0 ? '₹' . number_format((float) $cart->delivery_charge, 2) : 'Free' }}</dd></div>
                    @if((float) $cart->tax > 0)
                        <div class="flex justify-between"><dt class="text-ink-600">GST</dt><dd class="font-medium text-ink-900">₹{{ number_format((float) $cart->tax, 2) }}</dd></div>
                    @endif
                    <div class="flex justify-between border-t border-ink-200/60 pt-2 text-base"><dt class="font-semibold text-ink-900">Total</dt><dd class="font-bold text-ink-900">₹{{ number_format((float) $cart->total, 2) }}</dd></div>
                </dl>

                <button type="submit" class="btn btn-primary mt-5 w-full">Confirm Order — We'll Call You</button>
                <p class="mt-2 text-center text-xs text-ink-500">By confirming you accept our <a href="{{ url('/cms/terms-and-conditions') }}" class="text-brand-600 hover:underline">Terms</a>.</p>
            </x-card>
        </aside>
    </form>
</x-layouts.app>
