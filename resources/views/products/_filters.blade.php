@php
    $currentCategory = $currentCategory ?? null;
    $currentBrand = $currentBrand ?? null;
@endphp

@php
    $checkedBrands = $activeFilters['brand'] ?? [];
    $checkedCategories = $activeFilters['category'] ?? [];
@endphp

<form method="GET" action="{{ url()->current() }}" class="card p-5 sticky top-20">
    @if($activeFilters['vehicle_variant'])
        <input type="hidden" name="vehicle_variant" value="{{ $activeFilters['vehicle_variant'] }}">
    @endif
    @if($activeFilters['q'])
        <input type="hidden" name="q" value="{{ $activeFilters['q'] }}">
    @endif

    <div class="space-y-5">
        @if(! $currentCategory && $allCategories->isNotEmpty())
            <div>
                <h4 class="text-sm font-semibold text-ink-900">Category</h4>
                <div class="mt-2 space-y-2">
                    @foreach($allCategories as $cat)
                        <label class="flex cursor-pointer items-center gap-2 text-sm text-ink-700">
                            <input type="checkbox" name="category[]" value="{{ $cat->slug }}" @checked(in_array($cat->slug, $checkedCategories)) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
                            {{ $cat->name }}
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        @if(! $currentBrand && $allBrands->isNotEmpty())
            <div>
                <h4 class="text-sm font-semibold text-ink-900">Battery brand</h4>
                <div class="mt-2 max-h-48 space-y-2 overflow-y-auto">
                    @foreach($allBrands as $b)
                        <label class="flex cursor-pointer items-center gap-2 text-sm text-ink-700">
                            <input type="checkbox" name="brand[]" value="{{ $b->slug }}" @checked(in_array($b->slug, $checkedBrands)) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
                            {{ $b->name }}
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        <div>
            <h4 class="text-sm font-semibold text-ink-900">Price range</h4>
            <div class="mt-2 grid grid-cols-2 gap-2">
                <input type="number" name="min_price" placeholder="Min" min="0" step="100" value="{{ $activeFilters['min_price'] }}" class="input">
                <input type="number" name="max_price" placeholder="Max" min="0" step="100" value="{{ $activeFilters['max_price'] }}" class="input">
            </div>
        </div>

        <div class="space-y-2">
            <label class="flex cursor-pointer items-center gap-2 text-sm text-ink-700">
                <input type="checkbox" name="in_stock" value="1" @checked($activeFilters['in_stock']) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
                In stock only
            </label>
            <label class="flex cursor-pointer items-center gap-2 text-sm text-ink-700">
                <input type="checkbox" name="exchange" value="1" @checked($activeFilters['exchange']) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
                Old battery exchange available
            </label>
        </div>

        <div class="flex flex-col gap-2 pt-2">
            <button type="submit" class="btn btn-primary w-full">Apply filters</button>
            <a href="{{ url()->current() }}" class="btn btn-outline w-full text-xs">Clear all</a>
        </div>
    </div>
</form>
