<x-layouts.app :title="$seoTitle ?? ($title . ' | Vehicle Battery Store')" :metaDescription="$seoDescription ?? null">
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
                <x-card>
                    <div class="p-12 text-center">
                        <p class="text-sm text-ink-600">No batteries match your filters.</p>
                        <a href="{{ url()->current() }}" class="mt-3 inline-flex btn btn-primary">Clear filters</a>
                    </div>
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
