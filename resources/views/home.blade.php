<x-layouts.app>
    {{-- ============ HERO (cinematic dark, vape-shop style) ============ --}}
    @if($banners->isNotEmpty())
        @php
            $hero = $banners->first();
            $showcase = $bestSellers->take(3);
        @endphp

        {{-- Cinematic button styles — both start with the same glass look --}}
        <style>
            .btn-cine-primary,
            .btn-cine-secondary {
                background: rgba(255,255,255,0.08);
                color: #ffffff;
                border: 1px solid rgba(255,255,255,0.35);
                backdrop-filter: blur(8px);
                transition: background 0.35s ease, color 0.35s ease, border-color 0.35s ease, box-shadow 0.35s ease, transform 0.35s ease;
            }
            .btn-cine-primary:hover {
                background: #dc2626;
                color: #ffffff;
                border-color: #dc2626;
                box-shadow: 0 16px 50px rgba(220,38,38,0.55);
                transform: translateY(-2px) scale(1.03);
            }
            .btn-cine-primary:hover .cine-arrow {
                transform: translateX(5px);
            }
            .btn-cine-secondary:hover {
                background: #ffffff;
                color: #000000;
                border-color: #ffffff;
                box-shadow: 0 16px 40px rgba(255,255,255,0.3);
                transform: translateY(-2px) scale(1.03);
            }
            .cine-arrow {
                transition: transform 0.35s ease;
            }
        </style>

        <section class="relative overflow-hidden rounded-2xl shadow-2xl" style="background: #000;">
            {{-- Big red atmospheric glow on left (smoke effect) --}}
            <div class="absolute pointer-events-none"
                 style="left: -200px; top: 50%; transform: translateY(-50%); width: 800px; height: 800px; background: radial-gradient(circle, rgba(220,38,38,0.55), transparent 60%); filter: blur(80px);"></div>
            {{-- Teal/cyan atmospheric glow on right --}}
            <div class="absolute pointer-events-none"
                 style="right: -200px; top: 50%; transform: translateY(-50%); width: 800px; height: 800px; background: radial-gradient(circle, rgba(20,184,166,0.35), transparent 60%); filter: blur(100px);"></div>
            {{-- Purple accent in middle --}}
            <div class="absolute pointer-events-none"
                 style="left: 50%; top: 30%; transform: translate(-50%, 0); width: 600px; height: 600px; background: radial-gradient(circle, rgba(168,85,247,0.18), transparent 65%); filter: blur(80px);"></div>
            {{-- Subtle noise/grain --}}
            <div class="absolute inset-0 pointer-events-none opacity-30"
                 style="background-image: radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 3px 3px;"></div>

            <div class="relative grid gap-8 px-6 py-12 sm:px-10 sm:py-16 md:grid-cols-2 md:px-14 md:py-20 lg:px-16">
                {{-- LEFT: Bold cinematic text --}}
                <div class="flex flex-col justify-center">
                    <p class="text-[10px] font-bold uppercase tracking-[0.35em]" style="color: rgba(255,255,255,0.7);">
                        Mumbai's #1 Battery Delivery
                    </p>

                    <h1 class="mt-4 text-4xl font-extrabold leading-[0.95] tracking-tight text-white sm:text-5xl lg:text-6xl"
                        style="text-shadow: 0 4px 24px rgba(0,0,0,0.5);">
                        Your Trusted<br>
                        <span style="background: linear-gradient(90deg, #f87171, #dc2626); -webkit-background-clip: text; background-clip: text; color: transparent;">Battery Shop</span>
                    </h1>

                    @if($hero->subtitle)
                        <p class="mt-5 max-w-md text-sm leading-relaxed sm:text-base" style="color: rgba(255,255,255,0.7);">
                            {{ $hero->subtitle }}
                        </p>
                    @endif

                    {{-- Cinematic pill CTAs with hover transitions --}}
                    <div class="mt-10 flex flex-wrap items-center gap-3">
                        <a href="{{ url('/products') }}"
                           class="btn-cine-primary inline-flex items-center gap-2 rounded-full px-7 py-3 text-sm font-bold">
                            Shop Now
                            <svg class="cine-arrow h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="m9 6 6 6-6 6"/></svg>
                        </a>
                        <a href="{{ url('/finder') }}"
                           class="btn-cine-secondary inline-flex items-center gap-2 rounded-full px-7 py-3 text-sm font-semibold">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            Find my battery
                        </a>
                    </div>

                    {{-- Trust signals --}}
                    <div class="mt-6 flex flex-wrap gap-x-4 gap-y-2 text-xs font-medium" style="color: rgba(255,255,255,0.6);">
                        @foreach(['Same-day delivery', 'Free installation', 'COD available'] as $signal)
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20" style="color: #f87171;">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.7-9.3a1 1 0 0 0-1.4-1.4L9 10.6 7.7 9.3a1 1 0 0 0-1.4 1.4l2 2a1 1 0 0 0 1.4 0l4-4Z" clip-rule="evenodd"/>
                                </svg>
                                {{ $signal }}
                            </span>
                        @endforeach
                    </div>
                </div>

                {{-- RIGHT: Floating product showcase (3 batteries with colored glows) --}}
                <div class="relative hidden min-h-[400px] md:block">
                    @if($showcase->isNotEmpty())
                        @php $colors = ['#0ea5e9', '#dc2626', '#a855f7']; @endphp
                        <div class="absolute inset-0 flex items-center justify-center gap-2 lg:gap-4">
                            @foreach($showcase as $i => $product)
                                @php $glow = $colors[$i] ?? '#dc2626'; @endphp
                                <a href="{{ route('products.show', $product) }}"
                                   class="group relative flex-1 max-w-[180px] transition-all hover:-translate-y-3"
                                   style="transform: translateY({{ $i === 1 ? '-20px' : ($i === 2 ? '10px' : '0') }});">
                                    {{-- Glow under product --}}
                                    <div class="absolute -inset-4 rounded-3xl pointer-events-none"
                                         style="background: radial-gradient(circle, {{ $glow }}aa, transparent 70%); filter: blur(20px); opacity: 0.6;"></div>
                                    {{-- Product card --}}
                                    <div class="relative rounded-2xl p-3 backdrop-blur-md"
                                         style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15);">
                                        <div class="aspect-square overflow-hidden rounded-xl"
                                             style="background: linear-gradient(135deg, rgba(255,255,255,0.04), rgba(255,255,255,0.01));">
                                            <x-battery-image :product="$product" class="h-full w-full object-contain p-2" />
                                        </div>
                                        <div class="mt-2 px-1">
                                            <p class="text-[9px] font-bold uppercase tracking-wider" style="color: {{ $glow }};">{{ $product->batteryBrand?->name }}</p>
                                            <p class="mt-0.5 line-clamp-1 text-xs font-bold text-white">{{ $product->name }}</p>
                                            <p class="mt-1 text-sm font-extrabold text-white">₹{{ number_format((float) $product->effective_price, 0) }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- ============ SHOP BY CATEGORY ============ --}}
    @if($categories->isNotEmpty())
        @php $catCount = $categories->count(); @endphp
        <section class="mt-10">
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-brand-600">Shop by</p>
                    <h2 class="mt-1 text-xl font-extrabold text-ink-900 sm:text-2xl">Battery categories</h2>
                </div>
                <a href="{{ url('/products') }}" class="hidden text-sm font-semibold text-brand-600 hover:text-brand-700 sm:inline">View all →</a>
            </div>
            <div @class([
                'mt-5 grid gap-4',
                'grid-cols-2 sm:grid-cols-3 lg:grid-cols-6' => $catCount >= 6,
                'mx-auto max-w-5xl grid-cols-2 sm:grid-cols-3 lg:grid-cols-5' => $catCount === 5,
                'mx-auto max-w-3xl grid-cols-2 lg:grid-cols-4' => $catCount === 4,
                'mx-auto max-w-2xl grid-cols-2 sm:grid-cols-3' => $catCount === 3,
                'mx-auto max-w-md grid-cols-2' => $catCount === 2,
                'mx-auto max-w-[220px] grid-cols-1' => $catCount === 1,
            ])>
                @foreach($categories as $cat)
                    <a href="{{ route('categories.show', $cat) }}"
                       class="group card flex flex-col items-center gap-2 p-4 text-center transition-all hover:-translate-y-1 hover:shadow-md">
                        <div class="grid h-14 w-14 place-items-center rounded-xl bg-brand-100 text-brand-700 transition-transform group-hover:scale-110">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M7 4h10a1 1 0 0 1 1 1v1h1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h1V5a1 1 0 0 1 1-1Z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-bold text-ink-900 sm:text-sm">{{ $cat->name }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ============ STATS STRIP ============ --}}
    <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-4">
        @foreach([
            ['label' => 'Max exchange off', 'value' => '₹800', 'symbol' => '₹'],
            ['label' => 'Up to warranty', 'value' => '60 mo', 'icon' => 'M9 12l2 2 4-4M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z'],
            ['label' => 'Doorstep delivery', 'value' => 'Free', 'icon' => 'M3 7h13a4 4 0 0 1 0 8H10 M7 11l-4 4 4 4'],
            ['label' => 'Genuine products', 'value' => '100%', 'icon' => 'M12 2 4 5v6c0 5 3.4 9.4 8 10 4.6-.6 8-5 8-10V5l-8-3Z'],
        ] as $stat)
            <div class="card p-4 transition-transform hover:-translate-y-0.5">
                <div class="flex items-center gap-3">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-brand-100 text-brand-700">
                        @if(isset($stat['symbol']))
                            <span class="text-xl font-extrabold leading-none">{{ $stat['symbol'] }}</span>
                        @else
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $stat['icon'] }}"/></svg>
                        @endif
                    </span>
                    <div>
                        <p class="text-lg font-extrabold leading-none text-ink-900">{{ $stat['value'] }}</p>
                        <p class="mt-1 text-xs text-ink-500">{{ $stat['label'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ============ BEST SELLERS (high priority — show products early) ============ --}}
    @if($featuredProducts->isNotEmpty())
        @php $fpCount = $featuredProducts->count(); @endphp
        <section class="mt-14">
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-brand-600">Best sellers</p>
                    <h2 class="mt-1 text-2xl font-extrabold text-ink-900 sm:text-3xl">Most popular in Mumbai</h2>
                </div>
                <a href="{{ url('/products') }}" class="hidden text-sm font-semibold text-brand-600 hover:text-brand-700 sm:inline">View all →</a>
            </div>
            <div @class([
                'mt-6 grid gap-5',
                'sm:grid-cols-2 lg:grid-cols-4' => $fpCount >= 4,
                'mx-auto max-w-5xl sm:grid-cols-2 lg:grid-cols-3' => $fpCount === 3,
                'mx-auto max-w-3xl sm:grid-cols-2' => $fpCount === 2,
                'mx-auto max-w-sm' => $fpCount === 1,
            ])>
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- ============ TRUSTED BRANDS ============ --}}
    @if($featuredBrands->isNotEmpty())
        <section class="mt-14">
            <div class="text-center">
                <p class="text-xs font-bold uppercase tracking-widest text-brand-600">Trusted brands</p>
                <h2 class="mt-2 text-2xl font-extrabold text-ink-900 sm:text-3xl">Shop by battery brand</h2>
            </div>
            <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                @foreach($featuredBrands as $brand)
                    <a href="#" class="card flex h-20 items-center justify-center p-4 transition-all hover:-translate-y-0.5 hover:shadow-md">
                        <span class="text-center font-display text-base font-bold text-ink-900">{{ $brand->name }}</span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ============ WHY CHOOSE US ============ --}}
    <section class="mt-14">
        <div class="text-center">
            <p class="text-xs font-bold uppercase tracking-widest text-brand-600">Why choose us</p>
            <h2 class="mt-2 text-2xl font-extrabold text-ink-900 sm:text-3xl">The Mumbai battery service you can trust</h2>
        </div>
        <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
            @foreach([
                ['title' => 'Genuine batteries', 'desc' => 'Direct from authorised dealers, sealed with manufacturer warranty.', 'icon' => 'M12 2 4 5v6c0 5 3.4 9.4 8 10 4.6-.6 8-5 8-10V5l-8-3Z M9 12l2 2 4-4'],
                ['title' => 'Same-day delivery', 'desc' => 'Order before 2 PM in Mumbai — delivered the same evening.', 'icon' => 'M3 7h13a4 4 0 0 1 0 8H10 M7 11l-4 4 4 4'],
                ['title' => 'Warranty support', 'desc' => 'Up to 60 months. We handle warranty claims for you.', 'icon' => 'M9 12l2 2 4-4 M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z'],
                ['title' => 'Battery exchange', 'desc' => 'Save up to ₹800 instantly. We pick up your old battery.', 'icon' => 'M3 12a9 9 0 1 0 3-6.7M3 4v5h5'],
            ] as $card)
                <div class="card group p-5 transition-transform hover:-translate-y-1">
                    <div class="grid h-11 w-11 place-items-center rounded-xl bg-brand-100 text-brand-700 transition-transform group-hover:scale-110">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $card['icon'] }}"/></svg>
                    </div>
                    <h3 class="mt-3 text-sm font-bold text-ink-900">{{ $card['title'] }}</h3>
                    <p class="mt-1 text-xs leading-relaxed text-ink-600">{{ $card['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ TESTIMONIALS ============ --}}
    @if($testimonials->isNotEmpty())
        <section class="mt-14">
            <div class="text-center">
                <p class="text-xs font-bold uppercase tracking-widest text-brand-600">Customer love</p>
                <h2 class="mt-2 text-2xl font-extrabold text-ink-900 sm:text-3xl">Trusted by Mumbai customers</h2>
            </div>
            <div class="mt-8 grid gap-5 md:grid-cols-3">
                @foreach($testimonials->take(3) as $t)
                    <div class="card p-5 transition-transform hover:-translate-y-1">
                        <div class="flex gap-0.5 text-amber-500">
                            @for($i = 0; $i < $t->rating; $i++)
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path d="m10 1 2.6 6 6.4.5-4.9 4.3 1.5 6.3L10 14.8 4.4 18.1 5.9 11.8 1 7.5 7.4 7z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="mt-3 text-sm leading-relaxed text-ink-700">"{{ $t->comment }}"</p>
                        <div class="mt-4 flex items-center gap-3 border-t border-ink-200 pt-3">
                            <span class="grid h-9 w-9 place-items-center rounded-full bg-brand-100 text-xs font-bold text-brand-700">
                                {{ strtoupper(substr($t->name, 0, 1)) }}
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-ink-900">{{ $t->name }}</p>
                                <p class="text-xs text-ink-500">{{ $t->city }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ============ CONTACT / CTA SECTION ============ --}}
    @php
        $phone = \App\Models\Setting::get('support_phone', '+91 9920971479');
        $whatsapp = \App\Models\Setting::get('whatsapp_number', '+919920971479');
        $email = \App\Models\Setting::get('support_email', 'vbs622026@gmail.com');
        $phoneTel = preg_replace('/[^0-9+]/', '', $phone);
        $waNumber = preg_replace('/[^0-9]/', '', $whatsapp);
    @endphp
    <section class="mt-14">
        <div class="card overflow-hidden p-6 sm:p-10">
            <div class="grid gap-8 md:grid-cols-2 md:items-center">
                {{-- LEFT: Heading --}}
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-brand-600">Get in touch</p>
                    <h2 class="mt-2 text-2xl font-extrabold leading-tight text-ink-900 sm:text-3xl">
                        Need help choosing<br class="hidden sm:block"> the right battery?
                    </h2>
                    <p class="mt-3 max-w-md text-sm leading-relaxed text-ink-600 sm:text-base">
                        Our Mumbai team is available <strong class="text-ink-900">Mon–Sat, 9 AM – 8 PM</strong>.
                        Same-day delivery, free installation, old battery exchange.
                    </p>

                    {{-- Hours strip --}}
                    <div class="mt-5 inline-flex items-center gap-2 rounded-full bg-green-50 px-3 py-1.5 ring-1 ring-green-200">
                        <span class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-500 opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-green-500"></span>
                        </span>
                        <span class="text-xs font-semibold text-green-700">We're online now — quick reply</span>
                    </div>
                </div>

                {{-- RIGHT: Contact cards --}}
                <div class="space-y-3">
                    {{-- Call card --}}
                    <a href="tel:{{ $phoneTel }}"
                       class="group flex items-center gap-4 rounded-xl bg-white p-4 ring-1 ring-ink-200 transition-all hover:-translate-y-0.5 hover:shadow-md hover:ring-brand-300">
                        <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-brand-100 text-brand-700 transition-transform group-hover:scale-110">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-ink-500">Call us</p>
                            <p class="truncate text-sm font-bold text-ink-900">{{ $phone }}</p>
                        </div>
                        <svg class="h-5 w-5 shrink-0 text-ink-400 transition-transform group-hover:translate-x-1 group-hover:text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 6 6 6-6 6"/></svg>
                    </a>

                    {{-- WhatsApp card --}}
                    <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener"
                       class="group flex items-center gap-4 rounded-xl bg-white p-4 ring-1 ring-ink-200 transition-all hover:-translate-y-0.5 hover:shadow-md"
                       style="--hover-ring: rgba(34,197,94,0.4);"
                       onmouseover="this.style.boxShadow='0 8px 24px rgba(34,197,94,0.15)'; this.style.borderColor='#86efac';"
                       onmouseout="this.style.boxShadow=''; this.style.borderColor='';">
                        <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl transition-transform group-hover:scale-110"
                              style="background: #dcfce7; color: #15803d;">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 0 1 8.413 3.488 11.824 11.824 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-ink-500">WhatsApp us</p>
                            <p class="truncate text-sm font-bold text-ink-900">{{ $whatsapp }}</p>
                        </div>
                        <svg class="h-5 w-5 shrink-0 text-ink-400 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: #15803d;"><path d="m9 6 6 6-6 6"/></svg>
                    </a>

                    {{-- Email card --}}
                    <a href="mailto:{{ $email }}"
                       class="group flex items-center gap-4 rounded-xl bg-white p-4 ring-1 ring-ink-200 transition-all hover:-translate-y-0.5 hover:shadow-md hover:ring-ink-300">
                        <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl transition-transform group-hover:scale-110"
                              style="background: #e0e7ff; color: #4338ca;">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2Z M22 6l-10 7L2 6"/></svg>
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-ink-500">Email us</p>
                            <p class="truncate text-sm font-bold text-ink-900">{{ $email }}</p>
                        </div>
                        <svg class="h-5 w-5 shrink-0 text-ink-400 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 6 6 6-6 6"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ FAQs (last content section before footer) ============ --}}
    @if($faqs->isNotEmpty())
        <section class="mt-14 mb-8">
            <div class="text-center">
                <p class="text-xs font-bold uppercase tracking-widest text-brand-600">Got questions?</p>
                <h2 class="mt-2 text-2xl font-extrabold text-ink-900 sm:text-3xl">Frequently asked questions</h2>
            </div>
            <div class="mx-auto mt-8 max-w-3xl space-y-3">
                @foreach($faqs as $f)
                    <details class="card group overflow-hidden">
                        <summary class="flex cursor-pointer items-center justify-between p-4 text-sm font-semibold text-ink-900 hover:bg-ink-50">
                            <span>{{ $f->question }}</span>
                            <svg class="h-5 w-5 shrink-0 text-brand-600 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"/></svg>
                        </summary>
                        <div class="border-t border-ink-200 p-4 text-sm leading-relaxed text-ink-700">{{ $f->answer }}</div>
                    </details>
                @endforeach
            </div>
        </section>
    @endif
</x-layouts.app>
