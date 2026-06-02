@props(['product'])

<article class="card flex h-full flex-col overflow-hidden transition-transform hover:-translate-y-0.5">
    <a href="{{ route('products.show', $product) }}" class="block">
        <div class="aspect-square relative bg-gradient-to-br from-slate-50 to-slate-100">
            <x-battery-image :product="$product" class="absolute inset-0 h-full w-full object-contain p-2" />
            @if($product->offer_price && (float) $product->price > (float) $product->offer_price)
                <span class="absolute left-2 top-2 badge bg-brand-600 text-white">{{ $product->discount_percent }}% OFF</span>
            @endif
            @if(! $product->in_stock)
                <span class="absolute right-2 top-2 badge bg-ink-900 text-white">Out of stock</span>
            @endif
        </div>
    </a>

    <div class="flex flex-1 flex-col p-4">
        <p class="text-xs font-medium uppercase tracking-wider text-ink-500">{{ $product->batteryBrand?->name }}</p>
        <h3 class="mt-1 line-clamp-2 text-sm font-semibold text-ink-900">
            <a href="{{ route('products.show', $product) }}" class="hover:text-brand-600">{{ $product->name }}</a>
        </h3>

        @if($product->capacity_ah || $product->warranty_months)
            <p class="mt-1 text-xs text-ink-500">
                @if($product->capacity_ah)<span>{{ rtrim(rtrim($product->capacity_ah, '0'), '.') }} Ah</span>@endif
                @if($product->capacity_ah && $product->warranty_months) · @endif
                @if($product->warranty_months)<span>{{ $product->warranty_months }}mo warranty</span>@endif
            </p>
        @endif

        @if($product->rating_count > 0)
            <div class="mt-1 flex items-center gap-1 text-xs text-ink-600">
                <svg class="h-3.5 w-3.5 fill-amber-500" viewBox="0 0 20 20"><path d="m10 1 2.6 6 6.4.5-4.9 4.3 1.5 6.3L10 14.8 4.4 18.1 5.9 11.8 1 7.5 7.4 7z"/></svg>
                <span>{{ number_format((float) $product->rating_avg, 1) }} ({{ $product->rating_count }})</span>
            </div>
        @endif

        <div class="mt-3 flex flex-wrap items-baseline gap-2">
            <span class="text-lg font-bold text-ink-900">₹{{ number_format((float) $product->effective_price, 0) }}</span>
            @if($product->offer_price && (float) $product->price > (float) $product->offer_price)
                <span class="text-xs text-ink-400 line-through">₹{{ number_format((float) $product->price, 0) }}</span>
            @endif
        </div>

        @if($product->exchange_available && (float) $product->exchange_discount > 0)
            <p class="mt-1 text-xs font-medium text-green-700">+ ₹{{ number_format((float) $product->exchange_discount, 0) }} off on old battery exchange</p>
        @endif

        <div class="mt-auto pt-4">
            <a href="{{ route('products.show', $product) }}" class="btn btn-outline w-full text-xs">View details</a>
        </div>
    </div>
</article>
