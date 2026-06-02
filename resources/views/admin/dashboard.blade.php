<x-layouts.admin
    :title="'Dashboard'"
    :header="'Welcome ' . (auth()->user()->name ?? 'Admin')"
    :subheader="'Vehicle Battery Store admin'"
>
    {{-- Metric cards --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <a href="{{ route('admin.products.index') }}" class="card relative block overflow-hidden p-5 transition-transform hover:-translate-y-0.5">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-500">Products</p>
            <p class="mt-2 text-3xl font-bold text-ink-900">{{ $stats['products']['total'] }}</p>
            <p class="mt-1 text-xs text-ink-500">{{ $stats['products']['active'] }} active</p>
            <div class="absolute -right-4 -top-4 grid h-20 w-20 place-items-center rounded-2xl bg-violet-100 text-violet-600">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.7l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.7l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/></svg>
            </div>
        </a>

        <a href="{{ route('admin.categories.index') }}" class="card relative block overflow-hidden p-5 transition-transform hover:-translate-y-0.5">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-500">Categories</p>
            <p class="mt-2 text-3xl font-bold text-ink-900">{{ $stats['categories']['total'] }}</p>
            <p class="mt-1 text-xs text-ink-500">{{ $stats['categories']['active'] }} active</p>
            <div class="absolute -right-4 -top-4 grid h-20 w-20 place-items-center rounded-2xl bg-sky-100 text-sky-600">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 4h7v7H3z M14 4h7v7h-7z M3 14h7v7H3z M14 14h7v7h-7z"/></svg>
            </div>
        </a>

        <a href="{{ route('admin.brands.index') }}" class="card relative block overflow-hidden p-5 transition-transform hover:-translate-y-0.5">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-500">Brands</p>
            <p class="mt-2 text-3xl font-bold text-ink-900">{{ $stats['brands']['total'] }}</p>
            <p class="mt-1 text-xs text-ink-500">{{ $stats['brands']['active'] }} active</p>
            <div class="absolute -right-4 -top-4 grid h-20 w-20 place-items-center rounded-2xl bg-emerald-100 text-emerald-600">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 2 4 5v6c0 5 3.4 9.4 8 10 4.6-.6 8-5 8-10V5l-8-3Z"/></svg>
            </div>
        </a>

        <a href="{{ route('admin.banners.index') }}" class="card relative block overflow-hidden p-5 transition-transform hover:-translate-y-0.5">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-500">Banners</p>
            <p class="mt-2 text-3xl font-bold text-ink-900">{{ $stats['banners'] }}</p>
            <p class="mt-1 text-xs text-ink-500">homepage slides</p>
            <div class="absolute -right-4 -top-4 grid h-20 w-20 place-items-center rounded-2xl bg-amber-100 text-amber-600">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 5h18v14H3z M3 12h18"/></svg>
            </div>
        </a>
    </div>

    <div class="mt-6 grid gap-4 lg:grid-cols-3">
        <div class="card p-6 lg:col-span-2">
            <h2 class="text-base font-semibold text-ink-900">Catalog highlights</h2>
            <p class="mt-1 text-xs text-ink-500">A quick look at what's on the store right now.</p>

            <div class="mt-5 grid grid-cols-2 gap-6 text-center sm:grid-cols-4">
                <div>
                    <p class="text-3xl font-bold text-brand-600">{{ $stats['featured_products'] }}</p>
                    <p class="mt-1 text-[11px] font-semibold uppercase tracking-wider text-ink-500">Featured</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-amber-600">{{ $stats['low_stock'] }}</p>
                    <p class="mt-1 text-[11px] font-semibold uppercase tracking-wider text-ink-500">Low stock</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['out_of_stock'] }}</p>
                    <p class="mt-1 text-[11px] font-semibold uppercase tracking-wider text-ink-500">Out of stock</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-ink-900">{{ $stats['testimonials'] }}</p>
                    <p class="mt-1 text-[11px] font-semibold uppercase tracking-wider text-ink-500">Reviews</p>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <h2 class="text-base font-semibold text-ink-900">Quick actions</h2>
            <div class="mt-4 space-y-2">
                @foreach([
                    ['route' => 'admin.products.create', 'label' => 'Add a new product'],
                    ['route' => 'admin.categories.create', 'label' => 'Add a new category'],
                    ['route' => 'admin.brands.create', 'label' => 'Add a new brand'],
                    ['route' => 'admin.banners.create', 'label' => 'Add a new banner'],
                    ['route' => 'admin.testimonials.create', 'label' => 'Add a testimonial'],
                    ['route' => 'admin.faqs.create', 'label' => 'Add a FAQ'],
                ] as $action)
                    <a href="{{ route($action['route']) }}" class="flex items-center justify-between rounded-lg border border-ink-200 px-4 py-2.5 text-sm font-medium text-ink-700 transition-colors hover:border-brand-300 hover:bg-brand-50 hover:text-brand-700">
                        <span class="flex items-center gap-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                            {{ $action['label'] }}
                        </span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 6 6 6-6 6"/></svg>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    @if($recentProducts->isNotEmpty())
        <div class="mt-6 card overflow-hidden">
            <div class="flex items-center justify-between border-b border-ink-200/60 p-5">
                <h2 class="text-base font-semibold text-ink-900">Recent products</h2>
                <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">View all →</a>
            </div>
            <div class="divide-y divide-ink-200/60">
                @foreach($recentProducts as $product)
                    <a href="{{ route('admin.products.edit', $product) }}" class="flex items-center gap-3 p-4 transition-colors hover:bg-ink-50">
                        <div class="h-10 w-10 shrink-0 rounded-lg bg-gradient-to-br from-slate-50 to-slate-100 overflow-hidden">
                            <x-battery-image :product="$product" class="h-full w-full object-contain p-0.5" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="truncate text-sm font-medium text-ink-900">{{ $product->name }}</p>
                            <p class="text-xs text-ink-500">{{ $product->batteryBrand?->name }} · {{ $product->category?->name ?? '—' }} · ₹{{ number_format((float) $product->effective_price, 0) }}</p>
                        </div>
                        <span class="badge {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-ink-100 text-ink-700' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</x-layouts.admin>
