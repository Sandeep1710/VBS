<x-layouts.app
    :title="$product->name . ' | Trikuti Battery'"
    :metaDescription="$product->short_description"
>
    @push('head')
        <link rel="canonical" href="{{ route('products.show', $product) }}">
        @php
            $schema = [
                '@context' => 'https://schema.org/',
                '@type' => 'Product',
                'name' => $product->name,
                'sku' => $product->sku,
                'description' => $product->short_description ?? strip_tags($product->description ?? ''),
                'brand' => ['@type' => 'Brand', 'name' => $product->batteryBrand?->name],
                'offers' => [
                    '@type' => 'Offer',
                    'url' => route('products.show', $product),
                    'priceCurrency' => 'INR',
                    'price' => (string) (float) $product->effective_price,
                    'availability' => $product->in_stock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                ],
            ];
            if ($product->primaryImage?->path) {
                $schema['image'] = asset('storage/' . $product->primaryImage->path);
            }
            if ($product->rating_count > 0) {
                $schema['aggregateRating'] = [
                    '@type' => 'AggregateRating',
                    'ratingValue' => (string) (float) $product->rating_avg,
                    'reviewCount' => (int) $product->rating_count,
                ];
            }
        @endphp
        <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES) !!}</script>
    @endpush

    <nav class="mb-4 text-xs text-ink-500">
        <a href="{{ url('/') }}" class="hover:text-brand-600">Home</a>
        <span class="mx-1">/</span>
        <a href="{{ route('products.index') }}" class="hover:text-brand-600">Batteries</a>
        @if($product->category)
            <span class="mx-1">/</span>
            <a href="{{ route('categories.show', $product->category) }}" class="hover:text-brand-600">{{ $product->category->name }}</a>
        @endif
        <span class="mx-1">/</span>
        <span class="text-ink-700">{{ Str::limit($product->name, 50) }}</span>
    </nav>

    <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_420px]">
        {{-- Gallery --}}
        <div>
            <div class="card overflow-hidden">
                <div class="aspect-square bg-gradient-to-br from-slate-50 to-slate-100">
                    <x-battery-image :product="$product" class="h-full w-full object-contain p-4" />
                </div>
            </div>

            @if($product->images->count() > 1)
                <div class="mt-3 grid grid-cols-5 gap-2">
                    @foreach($product->images as $img)
                        <div class="card aspect-square bg-gradient-to-br from-slate-50 to-slate-100">
                            @if(str_ends_with($img->path, 'placeholder.svg'))
                                <x-battery-image :product="$product" class="h-full w-full object-contain p-1" />
                            @else
                                <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $img->alt }}" class="h-full w-full object-contain p-1" loading="lazy">
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Buy box --}}
        <div>
            <p class="text-xs font-medium uppercase tracking-wider text-ink-500">{{ $product->batteryBrand?->name }}</p>
            <h1 class="mt-1 text-2xl font-bold leading-tight text-ink-900 sm:text-3xl">{{ $product->name }}</h1>

            <div class="mt-3 flex flex-wrap items-center gap-3 text-sm">
                @if($product->rating_count > 0)
                    <div class="flex items-center gap-1 text-ink-700">
                        <svg class="h-4 w-4 fill-amber-500" viewBox="0 0 20 20"><path d="m10 1 2.6 6 6.4.5-4.9 4.3 1.5 6.3L10 14.8 4.4 18.1 5.9 11.8 1 7.5 7.4 7z"/></svg>
                        <span class="font-semibold">{{ number_format((float) $product->rating_avg, 1) }}</span>
                        <span class="text-ink-500">({{ $product->rating_count }} reviews)</span>
                    </div>
                @endif
                <span class="text-ink-300">·</span>
                <span class="text-ink-600">SKU: {{ $product->sku }}</span>
            </div>

            <div class="mt-4 flex flex-wrap items-baseline gap-3">
                <span class="text-3xl font-bold text-ink-900">₹{{ number_format((float) $product->effective_price, 0) }}</span>
                @if($product->offer_price && (float) $product->price > (float) $product->offer_price)
                    <span class="text-base text-ink-400 line-through">₹{{ number_format((float) $product->price, 0) }}</span>
                    <span class="badge bg-green-100 text-green-700">{{ $product->discount_percent }}% off</span>
                @endif
            </div>
            <p class="mt-1 text-xs text-ink-500">Inclusive of all taxes</p>

            <div class="mt-5 grid grid-cols-3 gap-3 rounded-xl bg-ink-50 p-4 text-center text-xs">
                <div>
                    <p class="font-bold text-ink-900">{{ $product->capacity_ah ? rtrim(rtrim($product->capacity_ah, '0'), '.') . ' Ah' : '—' }}</p>
                    <p class="mt-0.5 text-ink-500">Capacity</p>
                </div>
                <div>
                    <p class="font-bold text-ink-900">{{ $product->warranty_months ?: 0 }} months</p>
                    <p class="mt-0.5 text-ink-500">Warranty</p>
                </div>
                <div>
                    <p class="font-bold text-ink-900">{{ $product->voltage ? rtrim(rtrim($product->voltage, '0'), '.') . 'V' : '12V' }}</p>
                    <p class="mt-0.5 text-ink-500">Voltage</p>
                </div>
            </div>

            @if($product->in_stock)
                <p class="mt-3 inline-flex items-center gap-1 text-xs font-medium text-green-700">
                    <span class="h-2 w-2 rounded-full bg-green-600"></span>
                    In stock
                    @if($product->is_low_stock)<span class="text-amber-700">· Only {{ $product->stock_quantity }} left</span>@endif
                </p>
            @else
                <p class="mt-3 inline-flex items-center gap-1 text-xs font-medium text-red-700">
                    <span class="h-2 w-2 rounded-full bg-red-600"></span>
                    Out of stock
                </p>
            @endif

            {{-- Delivery check --}}
            <div class="mt-4 rounded-lg bg-ink-50 p-3">
                <label for="pincode-input" class="text-xs font-semibold text-ink-700">Check delivery to your pincode</label>
                <div class="mt-1.5 flex gap-2">
                    <input id="pincode-input" type="text" inputmode="numeric" pattern="[0-9]{4,10}" maxlength="10" placeholder="e.g. 400001" class="input flex-1 py-1.5 text-sm">
                    <button type="button" id="pincode-check" class="btn btn-secondary text-xs">Check</button>
                </div>
                <p id="pincode-result" class="mt-2 text-xs text-ink-600"></p>
            </div>
            @push('head')
                <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const input = document.getElementById('pincode-input');
                    const btn = document.getElementById('pincode-check');
                    const result = document.getElementById('pincode-result');
                    if (!btn) return;
                    btn.addEventListener('click', async () => {
                        const code = (input.value || '').trim();
                        if (!/^\d{4,10}$/.test(code)) {
                            result.className = 'mt-2 text-xs text-red-600';
                            result.textContent = 'Please enter a valid pincode.';
                            return;
                        }
                        result.className = 'mt-2 text-xs text-ink-600';
                        result.textContent = 'Checking…';
                        try {
                            const res = await fetch(`{{ route('delivery.check') }}?pincode=${encodeURIComponent(code)}`, {
                                headers: { 'Accept': 'application/json' }
                            });
                            const data = await res.json();
                            if (data.serviceable) {
                                const charge = data.delivery_charge > 0 ? `₹${data.delivery_charge} delivery` : 'free delivery';
                                result.className = 'mt-2 text-xs text-green-700 font-medium';
                                result.textContent = `✓ ${data.message} — ${data.city} (${charge})`;
                            } else {
                                result.className = 'mt-2 text-xs text-red-600';
                                result.textContent = `✗ ${data.message || 'Not deliverable yet.'}`;
                            }
                        } catch (e) {
                            result.className = 'mt-2 text-xs text-red-600';
                            result.textContent = 'Could not check delivery right now. Please try again.';
                        }
                    });
                    input.addEventListener('keydown', (e) => { if (e.key === 'Enter') { e.preventDefault(); btn.click(); } });
                });
                </script>
            @endpush

            <form method="POST" action="{{ route('cart.add', $product) }}" id="add-to-cart-form" class="mt-5 space-y-4">
                @csrf

                @if($product->exchange_available && (float) $product->exchange_discount > 0)
                    <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-3">
                        <input type="checkbox" name="exchange_old_battery" value="1" class="mt-1 h-4 w-4 rounded border-green-300 text-green-600 focus:ring-green-500">
                        <div>
                            <p class="text-sm font-semibold text-green-900">Exchange your old battery</p>
                            <p class="text-xs text-green-700">Save ₹{{ number_format((float) $product->exchange_discount, 0) }} when you return your old battery on delivery.</p>
                        </div>
                    </label>
                @endif

                <div class="flex items-center gap-3">
                    <label for="quantity" class="text-sm text-ink-700">Quantity:</label>
                    <select name="quantity" id="quantity" class="input w-24">
                        @for($i = 1; $i <= min(10, max(1, $product->stock_quantity)); $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <button type="submit" name="buy_now" value="1" {{ $product->in_stock ? '' : 'disabled' }} class="btn btn-primary">Buy now</button>
                    <button type="submit" {{ $product->in_stock ? '' : 'disabled' }} class="btn btn-outline">Add to cart</button>
                </div>
            </form>

            @auth
                @php
                    $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                @endphp
                <form method="POST" action="{{ $inWishlist ? route('account.wishlist.destroy', $product) : route('account.wishlist.store', $product) }}" class="mt-3">
                    @csrf
                    @if($inWishlist) @method('DELETE') @endif
                    <button class="btn btn-outline w-full text-sm">
                        @if($inWishlist)
                            <svg class="h-4 w-4 fill-brand-600" viewBox="0 0 24 24"><path d="M12 21s-7-4.5-9.5-9A5 5 0 0 1 12 5.7 5 5 0 0 1 21.5 12c-2.5 4.5-9.5 9-9.5 9z"/></svg>
                            Saved to wishlist
                        @else
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 21s-7-4.5-9.5-9A5 5 0 0 1 12 5.7 5 5 0 0 1 21.5 12c-2.5 4.5-9.5 9-9.5 9z"/></svg>
                            Add to wishlist
                        @endif
                    </button>
                </form>
            @endauth

            <div class="mt-6 grid grid-cols-2 gap-3 border-t border-ink-200/60 pt-5 text-center text-xs">
                @foreach([
                    ['Free delivery', 'M3 12h18M5 12V5h14v7'],
                    ['Manufacturer warranty', 'M9 12l2 2 4-4M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z'],
                    ['Genuine product', 'M12 2 4 5v6c0 5 3.4 9.4 8 10 4.6-.6 8-5 8-10V5l-8-3Z'],
                    ['7-day returns', 'M3 12a9 9 0 1 0 3-6.7M3 4v5h5'],
                ] as [$label, $path])
                    <div class="flex items-center gap-2 text-ink-700">
                        <svg class="h-5 w-5 shrink-0 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $path }}"/></svg>
                        {{ $label }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="mt-12 grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-8">
            {{-- Description --}}
            @if($product->description)
                <section>
                    <h2 class="text-xl font-bold text-ink-900">Description</h2>
                    <div class="prose prose-ink mt-3 max-w-none text-sm text-ink-700">
                        {!! $product->description !!}
                    </div>
                </section>
            @endif

            {{-- Specifications --}}
            @if($product->specifications->isNotEmpty())
                <section>
                    <h2 class="text-xl font-bold text-ink-900">Specifications</h2>
                    <div class="mt-3 card overflow-hidden">
                        <table class="w-full text-sm">
                            <tbody class="divide-y divide-ink-200/60">
                                @foreach($product->specifications->groupBy('group') as $group => $specs)
                                    @if($group)
                                        <tr class="bg-ink-50">
                                            <td colspan="2" class="px-4 py-2 text-xs font-semibold uppercase tracking-wider text-ink-600">{{ $group }}</td>
                                        </tr>
                                    @endif
                                    @foreach($specs as $spec)
                                        <tr>
                                            <td class="w-48 px-4 py-3 text-ink-600">{{ $spec->key }}</td>
                                            <td class="px-4 py-3 font-medium text-ink-900">{{ $spec->value }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            @endif

            {{-- Compatible vehicles --}}
            @if($product->fitments->isNotEmpty())
                <section>
                    <h2 class="text-xl font-bold text-ink-900">Compatible vehicles</h2>
                    <div class="mt-3 grid gap-2 sm:grid-cols-2">
                        @foreach($product->fitments->take(20) as $fit)
                            @php
                                $variant = $fit->vehicleVariant;
                                $model = $variant?->vehicleModel;
                            @endphp
                            @if($variant && $model)
                                <div class="card p-3 text-sm">
                                    <p class="font-medium text-ink-900">{{ $model->vehicleBrand?->name }} {{ $model->name }}</p>
                                    <p class="text-xs text-ink-500">{{ $variant->name }}@if($variant->fuel_type) · {{ ucfirst($variant->fuel_type) }}@endif @if($variant->year_from) · {{ $variant->year_from }}@if($variant->year_to)–{{ $variant->year_to }}@endif @endif</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @if($product->fitments->count() > 20)
                        <p class="mt-2 text-xs text-ink-500">+ {{ $product->fitments->count() - 20 }} more vehicles</p>
                    @endif
                </section>
            @endif

            {{-- Reviews --}}
            <section>
                <h2 class="text-xl font-bold text-ink-900">Reviews</h2>

                @if($product->approvedReviews->isEmpty())
                    <div class="card mt-3 p-6 text-center text-sm text-ink-600">No reviews yet. Be the first to review this battery.</div>
                @else
                    <div class="mt-3 space-y-3">
                        @foreach($product->approvedReviews->take(5) as $review)
                            <div class="card p-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex gap-0.5 text-amber-500">
                                        @for($i = 0; $i < $review->rating; $i++)<svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="m10 1 2.6 6 6.4.5-4.9 4.3 1.5 6.3L10 14.8 4.4 18.1 5.9 11.8 1 7.5 7.4 7z"/></svg>@endfor
                                    </div>
                                    <span class="text-sm font-semibold text-ink-900">{{ $review->title ?: '—' }}</span>
                                    @if($review->is_verified_buyer)<span class="badge bg-green-100 text-green-700">Verified buyer</span>@endif
                                </div>
                                <p class="mt-2 text-sm text-ink-700">{{ $review->comment }}</p>
                                @if($review->images && $review->images->isNotEmpty())
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @foreach($review->images as $img)
                                            <a href="{{ asset('storage/' . $img->path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $img->path) }}" alt="Review photo" class="h-16 w-16 rounded-md object-cover ring-1 ring-ink-200">
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                <p class="mt-2 text-xs text-ink-500">{{ $review->user?->name }} · {{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Submit review --}}
                @auth
                    @php
                        $existingReview = \App\Models\Review::where('product_id', $product->id)->where('user_id', auth()->id())->first();
                    @endphp
                    @if($existingReview)
                        <div class="mt-4 card p-4">
                            <p class="text-sm font-medium text-ink-900">You've already reviewed this product.</p>
                            @if(! $existingReview->is_approved)
                                <p class="text-xs text-amber-700">Your review is awaiting moderation.</p>
                            @endif
                        </div>
                    @else
                        <details class="mt-4 card overflow-hidden">
                            <summary class="cursor-pointer p-4 text-sm font-semibold text-ink-900">Write a review</summary>
                            <form method="POST" action="{{ route('account.reviews.store', $product) }}" enctype="multipart/form-data" class="space-y-3 border-t border-ink-200/60 p-4">
                                @csrf
                                <div>
                                    <x-label value="Rating" required />
                                    <div class="flex gap-1">
                                        @for($r = 1; $r <= 5; $r++)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="rating" value="{{ $r }}" class="peer sr-only" required>
                                                <span class="block rounded-md border border-ink-200 px-3 py-1.5 text-xs font-semibold text-ink-700 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-700">{{ $r }} ★</span>
                                            </label>
                                        @endfor
                                    </div>
                                    <x-input-error for="rating" />
                                </div>
                                <div>
                                    <x-label for="title" value="Title (optional)" />
                                    <x-input name="title" />
                                </div>
                                <div>
                                    <x-label for="comment" value="Your review" required />
                                    <textarea name="comment" rows="3" minlength="10" maxlength="5000" required class="input"></textarea>
                                    <x-input-error for="comment" />
                                </div>
                                <div>
                                    <x-label value="Photos (optional, up to 5)" />
                                    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-ink-700 file:mr-3 file:rounded-lg file:border-0 file:bg-ink-100 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-ink-700 hover:file:bg-ink-200">
                                    <x-input-error for="images.*" />
                                </div>
                                <button type="submit" class="btn btn-primary">Submit review</button>
                            </form>
                        </details>
                    @endif
                @else
                    <p class="mt-4 text-sm text-ink-600"><a href="{{ route('login') }}" class="font-medium text-brand-600 hover:underline">Sign in</a> to leave a review.</p>
                @endauth
            </section>
        </div>

        {{-- Sidebar: similar products --}}
        <div>
            @if($similar->isNotEmpty())
                <h3 class="text-base font-semibold text-ink-900">Similar products</h3>
                <div class="mt-3 space-y-3">
                    @foreach($similar as $sim)
                        <a href="{{ route('products.show', $sim) }}" class="card flex gap-3 p-3 transition-colors hover:bg-ink-50">
                            <div class="h-16 w-16 shrink-0 rounded-lg bg-gradient-to-br from-slate-50 to-slate-100 overflow-hidden">
                                <x-battery-image :product="$sim" class="h-full w-full object-contain p-1" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-medium uppercase text-ink-500">{{ $sim->batteryBrand?->name }}</p>
                                <p class="line-clamp-2 text-sm font-medium text-ink-900">{{ $sim->name }}</p>
                                <p class="mt-1 text-sm font-bold text-ink-900">₹{{ number_format((float) $sim->effective_price, 0) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Sticky mobile CTA --}}
    <div class="fixed inset-x-0 bottom-0 z-40 border-t border-ink-200 bg-white p-3 shadow-lg lg:hidden">
        <div class="flex items-center gap-3">
            <div class="flex-1">
                <p class="text-lg font-bold text-ink-900">₹{{ number_format((float) $product->effective_price, 0) }}</p>
                @if($product->offer_price && (float) $product->price > (float) $product->offer_price)
                    <p class="text-xs text-green-700">{{ $product->discount_percent }}% off</p>
                @endif
            </div>
            <button type="submit" form="add-to-cart-form" name="buy_now" value="1" {{ $product->in_stock ? '' : 'disabled' }} class="btn btn-primary flex-1">Buy now</button>
            <button type="submit" form="add-to-cart-form" {{ $product->in_stock ? '' : 'disabled' }} class="btn btn-outline flex-1">Add to cart</button>
        </div>
    </div>
    <div class="h-20 lg:hidden"></div>
</x-layouts.app>
