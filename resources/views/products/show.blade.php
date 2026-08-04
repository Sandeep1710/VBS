<x-layouts.app
    :title="$product->name . ' | Trikuti Battery'"
    :metaDescription="$product->short_description"
    :canonical="route('products.show', $product)"
    :ogType="'product'"
    :ogImage="$product->primaryImage?->path ? asset('storage/' . $product->primaryImage->path) : null"
>
    @push('head')
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

            $breadcrumbs = [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Batteries', 'item' => route('products.index')],
            ];
            if ($product->category) {
                $breadcrumbs[] = ['@type' => 'ListItem', 'position' => 3, 'name' => $product->category->name, 'item' => route('categories.show', $product->category)];
            }
            $breadcrumbs[] = ['@type' => 'ListItem', 'position' => count($breadcrumbs) + 1, 'name' => $product->name];
            $breadcrumbSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => $breadcrumbs,
            ];
        @endphp
        <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES) !!}</script>
        <script type="application/ld+json">{!! json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES) !!}</script>
    @endpush

    @php
        $whatsappNum = \App\Models\Setting::get('whatsapp_number', '+919920971479');
        $waNumberPdp = preg_replace('/[^0-9]/', '', $whatsappNum);
        $waMsgPdp    = "Hi Trikuti Battery, please call me back regarding \"{$product->name}\" ("
            . route('products.show', $product)
            . "). I'd like to know the best price and delivery options.";
        $waHrefPdp   = 'https://wa.me/' . $waNumberPdp . '?text=' . rawurlencode($waMsgPdp);
    @endphp

    {{-- ============ BREADCRUMB ============ --}}
    <nav class="flex flex-wrap items-center gap-1 text-xs text-ink-500" aria-label="Breadcrumb">
        <a href="{{ url('/') }}" class="hover:text-brand-600">Home</a>
        <span class="text-ink-300">/</span>
        <a href="{{ route('products.index') }}" class="hover:text-brand-600">Batteries</a>
        @if($product->category)
            <span class="text-ink-300">/</span>
            <a href="{{ route('categories.show', $product->category) }}" class="hover:text-brand-600">{{ $product->category->name }}</a>
        @endif
        <span class="text-ink-300">/</span>
        <span class="truncate text-ink-700">{{ Str::limit($product->name, 60) }}</span>
    </nav>

    {{-- ============ MAIN: GALLERY + BUY BOX ============ --}}
    <div class="mt-5 grid gap-10 lg:grid-cols-2">

        {{-- ─── LEFT: Gallery ─── --}}
        <div class="lg:sticky lg:top-24 lg:self-start">
            <div class="card mx-auto overflow-hidden lg:max-w-md">
                <div class="aspect-square bg-gradient-to-br from-slate-50 to-slate-100">
                    <x-battery-image :product="$product" class="h-full w-full object-contain p-6" />
                </div>
            </div>

            @if($product->images->count() > 1)
                <div class="mx-auto mt-3 grid max-w-md grid-cols-5 gap-2">
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

            {{-- Trust bar under image on desktop --}}
            <div class="mx-auto mt-6 hidden max-w-md rounded-xl border border-ink-200 bg-white p-4 lg:block">
                <div class="grid grid-cols-2 gap-3 text-xs">
                    @foreach([
                        ['Same or next-day delivery in Mumbai', 'M3 7h13a4 4 0 0 1 0 8H10 M7 11l-4 4 4 4'],
                        ['Manufacturer warranty', 'M9 12l2 2 4-4 M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z'],
                        ['100% genuine product', 'M12 2 4 5v6c0 5 3.4 9.4 8 10 4.6-.6 8-5 8-10V5l-8-3Z'],
                        ['Free installation on-site', 'M9 12l2 2 4-4M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z'],
                    ] as [$label, $path])
                        <div class="flex items-center gap-2 text-ink-700">
                            <svg class="h-4 w-4 shrink-0 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $path }}"/></svg>
                            <span>{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ─── RIGHT: Buy box ─── --}}
        <div>
            {{-- Brand pill --}}
            @if($product->batteryBrand?->name)
                <span class="inline-block rounded-full bg-brand-100 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-brand-700">
                    {{ $product->batteryBrand->name }}
                </span>
            @endif

            {{-- Title --}}
            <h1 class="mt-3 text-2xl font-extrabold leading-tight text-ink-900 sm:text-3xl lg:text-4xl">{{ $product->name }}</h1>

            {{-- Rating + SKU --}}
            <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm">
                @if($product->rating_count > 0)
                    <div class="inline-flex items-center gap-1">
                        <div class="flex gap-0.5 text-amber-500">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="h-4 w-4 {{ $i < round($product->rating_avg) ? 'fill-current' : 'text-ink-300' }}" viewBox="0 0 20 20"><path d="m10 1 2.6 6 6.4.5-4.9 4.3 1.5 6.3L10 14.8 4.4 18.1 5.9 11.8 1 7.5 7.4 7z"/></svg>
                            @endfor
                        </div>
                        <span class="font-semibold text-ink-700">{{ number_format((float) $product->rating_avg, 1) }}</span>
                        <span class="text-ink-500">({{ $product->rating_count }} reviews)</span>
                    </div>
                @endif
                <span class="text-xs text-ink-500">SKU: <span class="font-mono">{{ $product->sku }}</span></span>
            </div>

            {{-- Price --}}
            <div class="mt-6 rounded-xl bg-gradient-to-br from-slate-50 to-white p-5 ring-1 ring-ink-200">
                <div class="flex flex-wrap items-baseline gap-3">
                    <span class="text-4xl font-extrabold text-ink-900">₹{{ number_format((float) $product->effective_price, 0) }}</span>
                    @if($product->offer_price && (float) $product->price > (float) $product->offer_price)
                        <span class="text-lg text-ink-400 line-through">₹{{ number_format((float) $product->price, 0) }}</span>
                        <span class="badge bg-green-100 text-green-700">{{ $product->discount_percent }}% OFF</span>
                    @endif
                </div>
                <p class="mt-1 text-xs text-ink-500">Inclusive of all taxes · Free delivery in Mumbai</p>

                @if($product->in_stock)
                    <p class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-green-700">
                        <span class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-500 opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-green-500"></span>
                        </span>
                        In stock
                        @if($product->is_low_stock)<span class="text-amber-700">— only {{ $product->stock_quantity }} left</span>@endif
                    </p>
                @else
                    <p class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-red-700">
                        <span class="h-2 w-2 rounded-full bg-red-500"></span>
                        Out of stock
                    </p>
                @endif
            </div>

            {{-- Spec tiles --}}
            <div class="mt-4 grid grid-cols-3 gap-3">
                @foreach([
                    ['label' => 'Capacity', 'value' => $product->capacity_ah ? rtrim(rtrim($product->capacity_ah, '0'), '.') . ' Ah' : '—'],
                    ['label' => 'Warranty', 'value' => ($product->warranty_months ?: 0) . ' mo'],
                    ['label' => 'Voltage',  'value' => $product->voltage ? rtrim(rtrim($product->voltage, '0'), '.') . 'V' : '12V'],
                ] as $spec)
                    <div class="card p-3 text-center">
                        <p class="text-lg font-extrabold text-ink-900">{{ $spec['value'] }}</p>
                        <p class="mt-0.5 text-[11px] uppercase tracking-wider text-ink-500">{{ $spec['label'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Delivery check --}}
            <div class="mt-4 rounded-xl border border-dashed border-ink-300 bg-white p-4">
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z M12 10a2 2 0 1 1 0-4 2 2 0 0 1 0 4Z"/></svg>
                    <label for="pincode-input" class="text-xs font-semibold text-ink-800">Check delivery to your pincode</label>
                </div>
                <div class="mt-2 flex gap-2">
                    <input id="pincode-input" type="text" inputmode="numeric" pattern="[0-9]{4,10}" maxlength="10" placeholder="e.g. 400701" class="input flex-1 py-2 text-sm">
                    <button type="button" id="pincode-check" class="btn btn-primary text-xs">Check</button>
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
                                result.className = 'mt-2 text-xs font-semibold text-green-700';
                                result.textContent = `✓ ${data.message || 'Delivers to your pincode.'}`;
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

            {{-- Exchange offer --}}
            @if($product->exchange_available && (float) $product->exchange_discount > 0)
                <label class="mt-4 flex cursor-pointer items-start gap-3 rounded-xl border-2 border-green-300 bg-green-50 p-4">
                    <input form="add-to-cart-form" type="checkbox" name="exchange_old_battery" value="1" class="mt-0.5 h-4 w-4 rounded border-green-400 text-green-600 focus:ring-green-500">
                    <div>
                        <p class="text-sm font-bold text-green-900">Exchange your old battery — save ₹{{ number_format((float) $product->exchange_discount, 0) }}</p>
                        <p class="mt-1 text-xs leading-relaxed text-green-800">Hand over your dead battery when our technician delivers, and we'll deduct the exchange amount from the total.</p>
                    </div>
                </label>
            @endif

            {{-- CTAs --}}
            <form method="POST" action="{{ route('cart.add', $product) }}" id="add-to-cart-form" class="mt-5 space-y-4">
                @csrf

                <div class="flex items-center gap-3">
                    <label for="quantity" class="text-sm text-ink-700">Quantity:</label>
                    <select name="quantity" id="quantity" class="input w-24">
                        @for($i = 1; $i <= min(10, max(1, $product->stock_quantity)); $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    @if($product->in_stock)
                        <a href="{{ $waHrefPdp }}" target="_blank" rel="noopener" class="btn btn-primary">💬 Schedule a Call</a>
                    @else
                        <button type="button" disabled class="btn btn-primary">Out of stock</button>
                    @endif
                    <button type="submit" {{ $product->in_stock ? '' : 'disabled' }} class="btn btn-outline">Add to cart</button>
                </div>
            </form>

            {{-- Mobile trust bar (desktop shows it under the image) --}}
            <div class="mt-6 grid grid-cols-2 gap-3 border-t border-ink-200/60 pt-5 text-xs lg:hidden">
                @foreach([
                    ['Same or next-day delivery', 'M3 7h13a4 4 0 0 1 0 8H10 M7 11l-4 4 4 4'],
                    ['Manufacturer warranty', 'M9 12l2 2 4-4M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z'],
                    ['Genuine product', 'M12 2 4 5v6c0 5 3.4 9.4 8 10 4.6-.6 8-5 8-10V5l-8-3Z'],
                    ['Free installation', 'M3 12h18M5 12V5h14v7'],
                ] as [$label, $path])
                    <div class="flex items-center gap-2 text-ink-700">
                        <svg class="h-4 w-4 shrink-0 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $path }}"/></svg>
                        {{ $label }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ============ BELOW-FOLD SECTIONS (full width) ============ --}}
    <div class="mt-14 space-y-12">

        {{-- Description --}}
        @if($product->description)
            <section>
                <div class="mb-4 flex items-center gap-3">
                    <h2 class="text-xl font-extrabold text-ink-900 sm:text-2xl">About this battery</h2>
                    <div class="h-px flex-1 bg-ink-200"></div>
                </div>
                <div class="card p-6 sm:p-8">
                    <div class="prose prose-ink max-w-none text-sm leading-relaxed text-ink-700">
                        {!! $product->description !!}
                    </div>
                </div>
            </section>
        @endif

        {{-- Specifications --}}
        @if($product->specifications->isNotEmpty())
            <section>
                <div class="mb-4 flex items-center gap-3">
                    <h2 class="text-xl font-extrabold text-ink-900 sm:text-2xl">Specifications</h2>
                    <div class="h-px flex-1 bg-ink-200"></div>
                </div>
                <div class="card overflow-hidden">
                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-ink-200/60">
                            @foreach($product->specifications->groupBy('group') as $group => $specs)
                                @if($group)
                                    <tr class="bg-ink-50">
                                        <td colspan="2" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-ink-600">{{ $group }}</td>
                                    </tr>
                                @endif
                                @foreach($specs as $spec)
                                    <tr class="hover:bg-ink-50/60">
                                        <td class="w-56 px-5 py-3.5 text-ink-600">{{ $spec->key }}</td>
                                        <td class="px-5 py-3.5 font-semibold text-ink-900">{{ $spec->value }}</td>
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
                <div class="mb-4 flex items-center gap-3">
                    <h2 class="text-xl font-extrabold text-ink-900 sm:text-2xl">Compatible vehicles</h2>
                    <div class="h-px flex-1 bg-ink-200"></div>
                </div>
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($product->fitments->take(24) as $fit)
                        @php
                            $variant = $fit->vehicleVariant;
                            $model = $variant?->vehicleModel;
                        @endphp
                        @if($variant && $model)
                            <div class="card p-3 text-sm">
                                <p class="font-semibold text-ink-900">{{ $model->vehicleBrand?->name }} {{ $model->name }}</p>
                                <p class="mt-0.5 text-xs text-ink-500">
                                    {{ $variant->name }}@if($variant->fuel_type) · {{ ucfirst($variant->fuel_type) }}@endif @if($variant->year_from) · {{ $variant->year_from }}@if($variant->year_to)–{{ $variant->year_to }}@endif @endif
                                </p>
                            </div>
                        @endif
                    @endforeach
                </div>
                @if($product->fitments->count() > 24)
                    <p class="mt-3 text-xs text-ink-500">+ {{ $product->fitments->count() - 24 }} more vehicles fit this battery</p>
                @endif
            </section>
        @endif

        {{-- Reviews --}}
        <section>
            <div class="mb-4 flex items-center gap-3">
                <h2 class="text-xl font-extrabold text-ink-900 sm:text-2xl">Customer reviews</h2>
                <div class="h-px flex-1 bg-ink-200"></div>
            </div>

            @if($product->approvedReviews->isEmpty())
                <div class="card p-8 text-center">
                    <div class="mx-auto mb-3 grid h-12 w-12 place-items-center rounded-full bg-ink-100 text-ink-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="m10 1 2.6 6 6.4.5-4.9 4.3 1.5 6.3L10 14.8 4.4 18.1 5.9 11.8 1 7.5 7.4 7z"/></svg>
                    </div>
                    <p class="text-sm font-medium text-ink-700">No reviews yet.</p>
                    <p class="mt-1 text-xs text-ink-500">Be the first to share your experience with this battery.</p>
                </div>
            @else
                <div class="grid gap-4 md:grid-cols-2">
                    @foreach($product->approvedReviews->take(6) as $review)
                        <div class="card p-5">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex gap-0.5 text-amber-500">
                                    @for($i = 0; $i < $review->rating; $i++)<svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="m10 1 2.6 6 6.4.5-4.9 4.3 1.5 6.3L10 14.8 4.4 18.1 5.9 11.8 1 7.5 7.4 7z"/></svg>@endfor
                                </div>
                                @if($review->is_verified_buyer)<span class="badge bg-green-100 text-green-700">✓ Verified buyer</span>@endif
                            </div>
                            @if($review->title)
                                <p class="mt-2 text-sm font-bold text-ink-900">{{ $review->title }}</p>
                            @endif
                            <p class="mt-2 text-sm leading-relaxed text-ink-700">{{ $review->comment }}</p>
                            @if($review->images && $review->images->isNotEmpty())
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @foreach($review->images as $img)
                                        <a href="{{ asset('storage/' . $img->path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $img->path) }}" alt="Review photo" class="h-16 w-16 rounded-md object-cover ring-1 ring-ink-200">
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                            <p class="mt-3 border-t border-ink-100 pt-3 text-xs text-ink-500">{{ $review->user?->name }} · {{ $review->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- LEAD-GEN MODE: review submission is customer-account gated; hidden while accounts are off.
                 Original @auth block is preserved (commented) for easy re-enable. --}}
            {{--
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
                            </div>
                            <div><x-label for="title" value="Title (optional)" /><x-input name="title" /></div>
                            <div><x-label for="comment" value="Your review" required /><textarea name="comment" rows="3" minlength="10" maxlength="5000" required class="input"></textarea></div>
                            <div><x-label value="Photos (optional, up to 5)" /><input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-ink-700 file:mr-3 file:rounded-lg file:border-0 file:bg-ink-100 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-ink-700 hover:file:bg-ink-200"></div>
                            <button type="submit" class="btn btn-primary">Submit review</button>
                        </form>
                    </details>
                @endif
            @endauth
            --}}
        </section>

        {{-- Similar products --}}
        @if($similar->isNotEmpty())
            <section>
                <div class="mb-4 flex items-center gap-3">
                    <h2 class="text-xl font-extrabold text-ink-900 sm:text-2xl">You may also like</h2>
                    <div class="h-px flex-1 bg-ink-200"></div>
                </div>
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($similar as $sim)
                        <x-product-card :product="$sim" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    {{-- ============ STICKY MOBILE CTA ============ --}}
    <div class="fixed inset-x-0 bottom-0 z-40 border-t border-ink-200 bg-white p-3 shadow-lg lg:hidden">
        <div class="flex items-center gap-3">
            <div class="flex-1">
                <p class="text-lg font-bold text-ink-900">₹{{ number_format((float) $product->effective_price, 0) }}</p>
                @if($product->offer_price && (float) $product->price > (float) $product->offer_price)
                    <p class="text-xs text-green-700">{{ $product->discount_percent }}% off</p>
                @endif
            </div>
            @if($product->in_stock)
                <a href="{{ $waHrefPdp }}" target="_blank" rel="noopener" class="btn btn-primary flex-1">💬 Schedule Call</a>
            @else
                <button type="button" disabled class="btn btn-primary flex-1">Out of stock</button>
            @endif
            <button type="submit" form="add-to-cart-form" {{ $product->in_stock ? '' : 'disabled' }} class="btn btn-outline flex-1">Add to cart</button>
        </div>
    </div>
    <div class="h-20 lg:hidden"></div>
</x-layouts.app>
