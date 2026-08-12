<x-layouts.app :title="$seoTitle ?? ($title . ' | Trikuti Battery')" :metaDescription="$seoDescription ?? null">
    @push('head')
        @php
            $crumbs = [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
            ];
            if (isset($currentCategory) && $currentCategory) {
                $crumbs[] = ['@type' => 'ListItem', 'position' => 2, 'name' => 'Batteries', 'item' => route('products.index')];
                $crumbs[] = ['@type' => 'ListItem', 'position' => 3, 'name' => $currentCategory->name];
            } elseif (isset($currentBrand) && $currentBrand) {
                $crumbs[] = ['@type' => 'ListItem', 'position' => 2, 'name' => 'Batteries', 'item' => route('products.index')];
                $crumbs[] = ['@type' => 'ListItem', 'position' => 3, 'name' => $currentBrand->name];
            } else {
                $crumbs[] = ['@type' => 'ListItem', 'position' => 2, 'name' => $title];
            }
            $breadcrumbSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => $crumbs,
            ];

            $collectionSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => $title,
                'description' => $description ?? $seoDescription ?? null,
                'url' => url()->current(),
                'isPartOf' => ['@id' => url('/') . '#website'],
            ];
        @endphp
        <script type="application/ld+json">{!! json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
        <script type="application/ld+json">{!! json_encode(array_filter($collectionSchema, fn ($v) => $v !== null), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

        {{-- Auto-apply filters: submit on any change. Debounce number inputs. --}}
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('change', function (e) {
                var form = e.target.closest('.js-filter-form');
                if (!form) return;

                // On the mobile drawer, close the <details> so the reload starts fresh
                var details = form.closest('details');
                if (details) details.removeAttribute('open');

                // Debounce text/number inputs so we don't submit on every keystroke
                if (['text', 'number'].indexOf(e.target.type) !== -1) {
                    clearTimeout(form.__filterTimer);
                    form.__filterTimer = setTimeout(function () { form.submit(); }, 600);
                } else {
                    form.submit();
                }
            });

            // Also fire on Enter inside a number/text input (in case blur doesn't happen)
            document.addEventListener('keydown', function (e) {
                if (e.key !== 'Enter') return;
                var form = e.target.closest('.js-filter-form');
                if (!form) return;
                if (['text', 'number'].indexOf(e.target.type) !== -1) {
                    e.preventDefault();
                    clearTimeout(form.__filterTimer);
                    form.submit();
                }
            });
        });
        </script>
    @endpush

    <div class="mb-6 flex flex-col gap-4">
        <nav class="text-xs text-ink-500">
            <a href="{{ url('/') }}" class="hover:text-brand-600">Home</a>
            <span class="mx-1">/</span>
            <span class="text-ink-700">{{ $title }}</span>
        </nav>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-ink-900 sm:text-3xl">{{ $title }}</h1>
                @if($description)
                    <p class="mt-1 text-sm text-ink-600">{{ $description }}</p>
                @endif
                <p class="mt-1 text-xs text-ink-500">{{ $products->total() }} batteries found</p>
            </div>

            <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2">
                @foreach($activeFilters as $key => $value)
                    @if($key !== 'sort' && $value !== null && $value !== '' && $value !== false && (! is_array($value) || count($value)))
                        @if(is_array($value))
                            @foreach($value as $v)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endif
                @endforeach
                <label class="text-sm text-ink-600">Sort:</label>
                <select name="sort" onchange="this.form.submit()" class="input w-auto">
                    <option value="newest" @selected($activeFilters['sort'] === 'newest')>Newest</option>
                    <option value="popular" @selected($activeFilters['sort'] === 'popular')>Most popular</option>
                    <option value="price_asc" @selected($activeFilters['sort'] === 'price_asc')>Price: Low to High</option>
                    <option value="price_desc" @selected($activeFilters['sort'] === 'price_desc')>Price: High to Low</option>
                    <option value="rating" @selected($activeFilters['sort'] === 'rating')>Best rated</option>
                </select>
            </form>
        </div>

        @if($vehicleContext)
            <div class="flex flex-wrap items-center gap-2 rounded-lg bg-brand-50 px-4 py-3 ring-1 ring-brand-200">
                <span class="text-sm font-medium text-brand-800">
                    Showing batteries for: {{ $vehicleContext->vehicleModel->vehicleBrand->name }} {{ $vehicleContext->vehicleModel->name }} {{ $vehicleContext->name }}
                    @if($vehicleContext->fuel_type)<span class="text-xs">({{ ucfirst($vehicleContext->fuel_type) }})</span>@endif
                </span>
                <a href="{{ url()->current() }}" class="ml-auto text-xs font-medium text-brand-700 hover:underline">Clear vehicle</a>
            </div>
        @endif
    </div>

    <div class="grid gap-6 lg:grid-cols-[260px_minmax(0,1fr)]">
        <aside class="hidden lg:block">
            @include('products._filters', compact('allBrands', 'allCategories', 'activeFilters', 'currentCategory', 'currentBrand'))
        </aside>

        <div>
            {{-- Mobile filter toggle --}}
            <details class="mb-4 lg:hidden">
                <summary class="card cursor-pointer p-3 text-sm font-medium text-ink-700">Filters & sort</summary>
                <div class="mt-3">
                    @include('products._filters', compact('allBrands', 'allCategories', 'activeFilters', 'currentCategory', 'currentBrand'))
                </div>
            </details>

            @if($products->isEmpty())
                @php
                    // "Coming soon" = whole category is empty (not just a filtered-down view).
                    // Any active filter → treat it as a filter-mismatch instead.
                    $comingSoon = isset($currentCategory)
                        && $currentCategory->products()->where('is_active', true)->count() === 0;
                    $phone    = \App\Models\Setting::get('support_phone', '+91 9920971479');
                    $whatsapp = \App\Models\Setting::get('whatsapp_number', '+919920971479');
                @endphp
                <x-card>
                    @if($comingSoon)
                        <div class="p-10 text-center sm:p-12">
                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-amber-700">
                                Coming soon
                            </span>
                            <h2 class="mt-4 text-lg font-bold text-ink-900 sm:text-xl">
                                We're stocking {{ strtolower($currentCategory->name) }} shortly.
                            </h2>
                            <p class="mx-auto mt-2 max-w-md text-sm text-ink-600">
                                Need one urgently? Call or WhatsApp us with your vehicle details — we'll arrange it from our distributor and confirm the price + delivery date.
                            </p>
                            <div class="mt-5 flex flex-wrap items-center justify-center gap-3">
                                <a href="tel:{{ $phone }}" class="btn btn-primary">
                                    Call {{ $phone }}
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $whatsapp) }}?text=Hi%2C%20I%20need%20a%20{{ urlencode($currentCategory->name) }}%20for%20my%20vehicle."
                                   target="_blank" rel="noopener"
                                   class="btn btn-secondary">
                                    WhatsApp us
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="p-12 text-center">
                            <p class="text-sm text-ink-600">No batteries match your filters.</p>
                            <a href="{{ url()->current() }}" class="mt-3 inline-flex btn btn-primary">Clear filters</a>
                        </div>
                    @endif
                </x-card>
            @else
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
