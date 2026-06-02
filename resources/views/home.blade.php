<x-layouts.app>
    {{-- Hero --}}
    @if($banners->isNotEmpty())
        <section class="overflow-hidden rounded-2xl bg-gradient-to-br from-brand-600 to-brand-800 text-white">
            <div class="grid gap-8 p-8 md:grid-cols-2 md:p-14">
                <div class="flex flex-col justify-center">
                    <p class="text-sm font-semibold uppercase tracking-wider text-brand-100">{{ \App\Models\Setting::get('site_tagline') }}</p>
                    <h1 class="mt-3 text-3xl font-bold leading-tight md:text-4xl lg:text-5xl">{{ $banners->first()->title }}</h1>
                    @if($banners->first()->subtitle)
                        <p class="mt-3 text-base text-brand-100">{{ $banners->first()->subtitle }}</p>
                    @endif
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ url('/products') }}" class="btn bg-white text-brand-700 hover:bg-brand-50">Shop batteries</a>
                        <a href="{{ url('/finder') }}" class="btn border border-white/40 bg-white/10 text-white hover:bg-white/20">Find my battery</a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="rounded-xl bg-white/10 p-6 backdrop-blur">
                        <div class="grid grid-cols-2 gap-3 text-center">
                            <div class="rounded-lg bg-white/10 p-4"><p class="text-2xl font-bold">₹800</p><p class="text-xs text-brand-100">Max exchange off</p></div>
                            <div class="rounded-lg bg-white/10 p-4"><p class="text-2xl font-bold">60mo</p><p class="text-xs text-brand-100">Up to warranty</p></div>
                            <div class="rounded-lg bg-white/10 p-4"><p class="text-2xl font-bold">Free</p><p class="text-xs text-brand-100">Doorstep delivery</p></div>
                            <div class="rounded-lg bg-white/10 p-4"><p class="text-2xl font-bold">100%</p><p class="text-xs text-brand-100">Genuine products</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Why choose us --}}
    <section class="mt-12">
        <h2 class="text-2xl font-bold text-ink-900">Why choose us</h2>
        <div class="mt-5 grid gap-4 md:grid-cols-4">
            @foreach([
                ['Genuine batteries', 'Direct from authorized dealers.'],
                ['Free delivery', 'Doorstep delivery to your address.'],
                ['Warranty support', 'Manufacturer warranty on every battery.'],
                ['Old battery exchange', 'Get instant value for your old battery.'],
            ] as [$title, $desc])
                <div class="card p-5">
                    <h3 class="font-semibold text-ink-900">{{ $title }}</h3>
                    <p class="mt-1 text-sm text-ink-600">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Featured brands --}}
    @if($featuredBrands->isNotEmpty())
        <section class="mt-12">
            <h2 class="text-2xl font-bold text-ink-900">Featured battery brands</h2>
            <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-6">
                @foreach($featuredBrands as $brand)
                    <a href="#" class="card flex h-20 items-center justify-center p-4 transition-transform hover:-translate-y-0.5">
                        <span class="font-display font-bold text-ink-900">{{ $brand->name }}</span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Featured products --}}
    @if($featuredProducts->isNotEmpty())
        <section class="mt-12">
            <div class="flex items-end justify-between">
                <h2 class="text-2xl font-bold text-ink-900">Best selling batteries</h2>
                <a href="{{ url('/products') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">View all →</a>
            </div>
            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- Testimonials --}}
    @if($testimonials->isNotEmpty())
        <section class="mt-12">
            <h2 class="text-2xl font-bold text-ink-900">What customers say</h2>
            <div class="mt-5 grid gap-4 md:grid-cols-3">
                @foreach($testimonials->take(3) as $t)
                    <div class="card p-5">
                        <div class="flex gap-0.5 text-amber-500">
                            @for($i = 0; $i < $t->rating; $i++)<svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="m10 1 2.6 6 6.4.5-4.9 4.3 1.5 6.3L10 14.8 4.4 18.1 5.9 11.8 1 7.5 7.4 7z"/></svg>@endfor
                        </div>
                        <p class="mt-3 text-sm text-ink-700">"{{ $t->comment }}"</p>
                        <p class="mt-3 text-xs font-semibold text-ink-900">{{ $t->name }}</p>
                        <p class="text-xs text-ink-500">{{ $t->city }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- FAQs --}}
    @if($faqs->isNotEmpty())
        <section class="mt-12">
            <h2 class="text-2xl font-bold text-ink-900">Frequently asked questions</h2>
            <div class="mt-5 space-y-3">
                @foreach($faqs as $f)
                    <details class="card overflow-hidden">
                        <summary class="flex cursor-pointer items-center justify-between p-4 font-medium text-ink-900">
                            {{ $f->question }}
                            <svg class="h-4 w-4 text-ink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"/></svg>
                        </summary>
                        <div class="border-t border-ink-200/60 p-4 text-sm text-ink-700">{{ $f->answer }}</div>
                    </details>
                @endforeach
            </div>
        </section>
    @endif
</x-layouts.app>
