<x-layouts.account :title="'My Wishlist'">
    <x-slot:header>My wishlist</x-slot:header>
    <x-slot:subheader>Batteries you're keeping an eye on.</x-slot:subheader>

    @if($items->isEmpty())
        <x-card>
            <div class="p-12 text-center">
                <p class="text-base text-ink-700">Your wishlist is empty.</p>
                <p class="mt-1 text-sm text-ink-500">Tap the heart icon on any battery to save it.</p>
                <a href="{{ url('/products') }}" class="mt-4 inline-flex btn btn-primary">Browse batteries</a>
            </div>
        </x-card>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($items as $item)
                @php $product = $item->product; @endphp
                @if(! $product) @continue @endif
                <div class="card flex h-full flex-col overflow-hidden">
                    <a href="{{ route('products.show', $product) }}">
                        <div class="aspect-square bg-gradient-to-br from-slate-50 to-slate-100">
                            <x-battery-image :product="$product" class="h-full w-full object-contain p-2" />
                        </div>
                    </a>
                    <div class="flex flex-1 flex-col p-4">
                        <p class="text-xs font-medium uppercase tracking-wider text-ink-500">{{ $product->batteryBrand?->name }}</p>
                        <h3 class="mt-1 line-clamp-2 text-sm font-semibold text-ink-900">
                            <a href="{{ route('products.show', $product) }}" class="hover:text-brand-600">{{ $product->name }}</a>
                        </h3>
                        <p class="mt-2 text-lg font-bold text-ink-900">₹{{ number_format((float) $product->effective_price, 0) }}</p>

                        <div class="mt-auto flex gap-2 pt-4">
                            <form method="POST" action="{{ route('cart.add', $product) }}" class="flex-1">
                                @csrf
                                <button class="btn btn-primary w-full text-xs">Add to cart</button>
                            </form>
                            <form method="POST" action="{{ route('account.wishlist.destroy', $product) }}" onsubmit="return confirm('Remove from wishlist?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline text-xs">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-layouts.account>
