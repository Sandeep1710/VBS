<x-layouts.app :title="'Your Cart | Trikuti Battery'">
    <h1 class="text-2xl font-bold text-ink-900 sm:text-3xl">Your cart</h1>
    <p class="mt-1 text-sm text-ink-600">{{ $itemsCount }} item(s)</p>

    @if(! $cart || $cart->items->isEmpty())
        <x-card class="mt-6">
            <div class="p-12 text-center">
                <p class="text-base text-ink-700">Your cart is empty.</p>
                <p class="mt-1 text-sm text-ink-500">Find a battery for your vehicle to get started.</p>
                <div class="mt-5 flex flex-wrap justify-center gap-3">
                    <a href="{{ url('/products') }}" class="btn btn-primary">Shop batteries</a>
                    <a href="{{ url('/finder') }}" class="btn btn-outline">Find my battery</a>
                </div>
            </div>
        </x-card>
    @else
        <div class="mt-6 grid gap-6 lg:grid-cols-[minmax(0,1fr)_360px]">
            <div class="space-y-3">
                @foreach($cart->items as $item)
                    @php $product = $item->product; @endphp
                    <x-card padding="p-4">
                        <div class="flex gap-4">
                            <a href="{{ $product ? route('products.show', $product) : '#' }}" class="h-24 w-24 shrink-0 rounded-lg bg-gradient-to-br from-slate-50 to-slate-100 overflow-hidden">
                                @if($product)
                                    <x-battery-image :product="$product" class="h-full w-full object-contain p-1" />
                                @endif
                            </a>

                            <div class="flex flex-1 flex-col">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-medium uppercase tracking-wider text-ink-500">{{ $product?->batteryBrand?->name }}</p>
                                        <h3 class="mt-0.5 text-sm font-semibold text-ink-900">
                                            <a href="{{ $product ? route('products.show', $product) : '#' }}" class="hover:text-brand-600">{{ $product?->name ?? '—' }}</a>
                                        </h3>
                                        @if($product?->capacity_ah || $product?->warranty_months)
                                            <p class="mt-0.5 text-xs text-ink-500">
                                                @if($product?->capacity_ah){{ rtrim(rtrim($product->capacity_ah, '0'), '.') }} Ah · @endif
                                                {{ $product?->warranty_months }} months warranty
                                            </p>
                                        @endif
                                    </div>
                                    <form method="POST" action="{{ route('cart.remove', $item) }}" onsubmit="return confirm('Remove from cart?')">
                                        @csrf @method('DELETE')
                                        <button class="text-xs font-medium text-red-600 hover:text-red-700">Remove</button>
                                    </form>
                                </div>

                                <div class="mt-3 flex flex-wrap items-center gap-3">
                                    <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                                        @csrf @method('PATCH')
                                        <label class="text-xs text-ink-600">Qty:</label>
                                        <select name="quantity" onchange="this.form.submit()" class="input w-20 py-1">
                                            @for($q = 1; $q <= min(10, max(1, $product?->stock_quantity ?? 1)); $q++)
                                                <option value="{{ $q }}" @selected($item->quantity === $q)>{{ $q }}</option>
                                            @endfor
                                        </select>
                                    </form>

                                    @if($product?->exchange_available)
                                        <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="exchange_old_battery" value="{{ $item->exchange_old_battery ? '0' : '1' }}">
                                            <button class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs font-medium {{ $item->exchange_old_battery ? 'bg-green-100 text-green-800' : 'bg-ink-100 text-ink-700 hover:bg-ink-200' }}">
                                                <span class="inline-block h-3 w-3 rounded-full {{ $item->exchange_old_battery ? 'bg-green-600' : 'border border-ink-400' }}"></span>
                                                Exchange old battery
                                                @if($item->exchange_old_battery)<span>(-₹{{ number_format((float) $item->exchange_discount, 0) }})</span>@endif
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <div class="text-right">
                                <p class="text-base font-bold text-ink-900">₹{{ number_format($item->line_total, 2) }}</p>
                                @if($item->offer_price && (float) $item->price > (float) $item->offer_price)
                                    <p class="text-xs text-ink-400 line-through">₹{{ number_format((float) $item->price * $item->quantity, 0) }}</p>
                                @endif
                                @if($item->exchange_old_battery)
                                    <p class="mt-0.5 text-xs font-medium text-green-700">Exchange saving applied</p>
                                @endif
                            </div>
                        </div>
                    </x-card>
                @endforeach

                <div class="pt-2">
                    <a href="{{ url('/products') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">← Continue shopping</a>
                </div>
            </div>

            {{-- Summary --}}
            <aside class="space-y-4 lg:sticky lg:top-20 lg:self-start">
                <x-card title="Order summary">
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between"><dt class="text-ink-600">Subtotal</dt><dd class="font-medium text-ink-900">₹{{ number_format((float) $cart->subtotal, 2) }}</dd></div>
                        @if((float) $cart->exchange_discount > 0)
                            <div class="flex justify-between"><dt class="text-ink-600">Exchange discount</dt><dd class="font-medium text-green-700">-₹{{ number_format((float) $cart->exchange_discount, 2) }}</dd></div>
                        @endif
                        @if((float) $cart->discount > 0)
                            <div class="flex items-center justify-between">
                                <dt class="flex items-center gap-2 text-ink-600">
                                    Coupon ({{ $cart->coupon_code }})
                                    <form method="POST" action="{{ route('cart.coupon.remove') }}">
                                        @csrf @method('DELETE')
                                        <button class="text-xs text-red-600 hover:underline">Remove</button>
                                    </form>
                                </dt>
                                <dd class="font-medium text-green-700">-₹{{ number_format((float) $cart->discount, 2) }}</dd>
                            </div>
                        @endif
                        <div class="flex justify-between"><dt class="text-ink-600">Delivery</dt><dd class="font-medium text-ink-900">{{ (float) $cart->delivery_charge > 0 ? '₹' . number_format((float) $cart->delivery_charge, 2) : 'Free' }}</dd></div>
                        @if((float) $cart->tax > 0)
                            <div class="flex justify-between"><dt class="text-ink-600">GST</dt><dd class="font-medium text-ink-900">₹{{ number_format((float) $cart->tax, 2) }}</dd></div>
                        @endif
                        <div class="flex justify-between border-t border-ink-200/60 pt-2 text-base"><dt class="font-semibold text-ink-900">Total</dt><dd class="font-bold text-ink-900">₹{{ number_format((float) $cart->total, 2) }}</dd></div>
                    </dl>

                    <div class="mt-5">
                        @auth
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary w-full">Proceed to checkout</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary w-full">Sign in to checkout</a>
                            <p class="mt-2 text-center text-xs text-ink-500">Your cart will be saved.</p>
                        @endauth
                    </div>
                </x-card>

                @guest
                @endguest
                @if(! (float) $cart->discount > 0)
                    <x-card title="Have a coupon?">
                        <form method="POST" action="{{ route('cart.coupon.apply') }}" class="flex gap-2">
                            @csrf
                            <input type="text" name="code" required maxlength="40" placeholder="Enter code" class="input flex-1 uppercase">
                            <button type="submit" class="btn btn-secondary">Apply</button>
                        </form>
                        <p class="mt-2 text-xs text-ink-500">Try <code class="rounded bg-ink-100 px-1.5 py-0.5">WELCOME200</code> or <code class="rounded bg-ink-100 px-1.5 py-0.5">SAVE10</code></p>
                    </x-card>
                @endif
            </aside>
        </div>
    @endif
</x-layouts.app>
