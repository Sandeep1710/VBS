<x-layouts.app :title="'Get a Callback | Trikuti Battery'">
    <h1 class="text-2xl font-bold text-ink-900 sm:text-3xl">Almost done — we'll call you</h1>
    <p class="mt-1 text-sm text-ink-600">
        Share your contact details below and our Mumbai team will call within 4 hours to confirm the battery model, delivery slot, and final price.
    </p>

    <x-validation-errors class="mt-5" />

    <form method="POST" action="{{ route('checkout.store') }}" class="mt-6 grid gap-6 lg:grid-cols-[minmax(0,1fr)_360px]">
        @csrf

        <div class="space-y-6">
            {{-- LEAD FORM --}}
            <x-card title="Your details">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <x-label for="name" value="Your name" required />
                        <x-input name="name" id="name" :value="old('name')" required autofocus />
                        <x-input-error for="name" />
                    </div>

                    <div>
                        <x-label for="phone" value="Phone number" required />
                        <x-input name="phone" id="phone" type="tel" :value="old('phone')" required placeholder="+91 98765 43210" />
                        <x-input-error for="phone" />
                    </div>

                    <div>
                        <x-label for="pincode" value="Delivery pincode" required />
                        <x-input name="pincode" id="pincode" :value="old('pincode')" required placeholder="400701" maxlength="6" />
                        <x-input-error for="pincode" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-label for="email" value="Email (optional)" />
                        <x-input name="email" id="email" type="email" :value="old('email')" placeholder="you@example.com" />
                        <p class="mt-1 text-xs text-ink-500">We'll send your order confirmation here. Skip if you prefer WhatsApp/phone only.</p>
                        <x-input-error for="email" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-label for="notes" value="Anything else? (optional)" />
                        <textarea name="notes" id="notes" rows="3" maxlength="1000" placeholder="Vehicle model, preferred delivery time, old battery for exchange, etc." class="input">{{ old('notes') }}</textarea>
                        <x-input-error for="notes" />
                    </div>
                </div>

                <div class="mt-4 rounded-lg bg-blue-50 p-3 text-xs text-blue-800 ring-1 ring-blue-200">
                    <p class="font-semibold">📞 What happens next?</p>
                    <p class="mt-1">
                        Our team calls you at your number within <strong>4 hours (Mon–Sat, 9 AM – 8 PM)</strong> to confirm the battery, collect the delivery address, and lock the final price. Payment is on delivery.
                    </p>
                </div>
            </x-card>
        </div>

        {{-- Interest summary (from cart) --}}
        <aside class="space-y-4 lg:sticky lg:top-20 lg:self-start">
            <x-card title="You're interested in">
                <ul class="divide-y divide-ink-200/60 text-sm">
                    @foreach($cart->items as $item)
                        <li class="flex items-start justify-between gap-3 py-2 first:pt-0 last:pb-0">
                            <div class="min-w-0">
                                <p class="line-clamp-2 font-medium text-ink-900">{{ $item->product?->name }}</p>
                                <p class="text-xs text-ink-500">
                                    Qty: {{ $item->quantity }}
                                    @if($item->exchange_old_battery) · with old battery exchange @endif
                                </p>
                            </div>
                            <p class="shrink-0 font-medium text-ink-900">~₹{{ number_format($item->line_total, 0) }}</p>
                        </li>
                    @endforeach
                </ul>

                <p class="mt-4 rounded-md bg-amber-50 p-2.5 text-xs text-amber-800 ring-1 ring-amber-200">
                    Prices shown are indicative. Final price will be confirmed on the call — often lower with old battery exchange.
                </p>

                <button type="submit" class="btn btn-primary mt-5 w-full">
                    Request Callback
                </button>
                <p class="mt-2 text-center text-xs text-ink-500">
                    By submitting you accept our
                    <a href="{{ url('/cms/terms-and-conditions') }}" class="text-brand-600 hover:underline">Terms</a>.
                </p>
            </x-card>
        </aside>
    </form>
</x-layouts.app>
