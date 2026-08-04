@php
    $phone    = \App\Models\Setting::get('support_phone', '+91 9920971479');
    $whatsapp = \App\Models\Setting::get('whatsapp_number', '+919920971479');
    $email    = \App\Models\Setting::get('support_email', 'vbs622026@gmail.com');
    $address  = \App\Models\Setting::get('address', 'R-30, MIDC Area Rd, MIDC Industrial Area, Rabale, Navi Mumbai, Maharashtra 400701');
    $phoneTel = preg_replace('/[^0-9+]/', '', $phone);
    $waNumber = preg_replace('/[^0-9]/', '', $whatsapp);
@endphp

<x-layouts.app :title="$page->meta_title ?? ($page->title . ' | Trikuti Battery')" :metaDescription="$page->meta_description">

    {{-- ============ HERO ============ --}}
    <section class="relative overflow-hidden rounded-2xl shadow-2xl" style="background:#0f172a;">
        <div class="absolute pointer-events-none" style="left:-160px; top:50%; transform:translateY(-50%); width:640px; height:640px; background:radial-gradient(circle, rgba(220,38,38,.5), transparent 60%); filter:blur(70px);"></div>
        <div class="absolute pointer-events-none" style="right:-160px; top:30%; width:520px; height:520px; background:radial-gradient(circle, rgba(20,184,166,.28), transparent 60%); filter:blur(80px);"></div>

        <div class="relative px-6 py-14 text-center sm:px-10 sm:py-20">
            <p class="text-[10px] font-bold uppercase tracking-[0.4em]" style="color:rgba(255,255,255,0.7);">About Trikuti Battery</p>
            <h1 class="mt-4 text-4xl font-extrabold leading-tight text-white sm:text-5xl lg:text-6xl">
                Mumbai's trusted <span style="background:linear-gradient(90deg,#f87171,#dc2626); -webkit-background-clip:text; background-clip:text; color:transparent;">battery delivery</span> team
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-sm leading-relaxed sm:text-base" style="color:rgba(255,255,255,0.75);">
                Genuine car and bike batteries delivered to your doorstep across Mumbai, Thane and Navi Mumbai — with free installation, old-battery exchange, and full manufacturer warranty.
            </p>

            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ url('/products') }}" class="btn btn-primary">Browse batteries →</a>
                <a href="tel:{{ $phoneTel }}" class="btn text-white" style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.35);">📞 Call {{ $phone }}</a>
            </div>
        </div>
    </section>

    {{-- ============ STATS STRIP ============ --}}
    <section class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-4">
        @foreach([
            ['value' => '4+', 'label' => 'Years serving Mumbai'],
            ['value' => '5,000+', 'label' => 'Batteries delivered'],
            ['value' => '4.9★', 'label' => 'Average rating'],
            ['value' => '100%', 'label' => 'Genuine + warranty'],
        ] as $stat)
            <div class="card p-5 text-center">
                <p class="text-2xl font-extrabold text-brand-600 sm:text-3xl">{{ $stat['value'] }}</p>
                <p class="mt-1 text-xs text-ink-600 sm:text-sm">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </section>

    {{-- ============ OUR STORY ============ --}}
    <section class="mt-14 grid gap-8 lg:grid-cols-2 lg:items-center">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-brand-600">Our story</p>
            <h2 class="mt-2 text-2xl font-extrabold text-ink-900 sm:text-3xl">Built around one promise — no wasted time.</h2>
            <div class="prose prose-ink mt-4 max-w-none text-sm leading-relaxed text-ink-700">
                <p>
                    A dead battery always strikes at the worst possible moment — a Monday morning, in the middle of a downpour, or right before an important meeting. We started Trikuti Battery in Navi Mumbai because we were tired of watching people lose half their day chasing quotes, hauling out old batteries, and being sold whatever the local shop had in stock.
                </p>
                <p>
                    Today we deliver genuine <strong>Exide, Amaron</strong> and <strong>Bosch</strong> batteries across Mumbai, Thane and Navi Mumbai — usually same day, and always by the next working day. Our technicians handle the swap, cart away your old battery, and register the manufacturer warranty on the spot. No paperwork. No back-and-forth. No surprises.
                </p>
            </div>
        </div>

        <div class="card overflow-hidden p-6 sm:p-8" style="background:linear-gradient(135deg, #fef2f2, #fff);">
            <div class="grid gap-4 sm:grid-cols-2">
                @foreach([
                    ['title' => 'Free installation', 'desc' => 'Certified technician swaps your battery in under 15 minutes.', 'icon' => 'M12 2 4 5v6c0 5 3.4 9.4 8 10 4.6-.6 8-5 8-10V5l-8-3Z M9 12l2 2 4-4'],
                    ['title' => 'Old battery pickup', 'desc' => 'We haul away your dead battery and give you up to ₹800 off.', 'icon' => 'M3 12a9 9 0 1 0 3-6.7M3 4v5h5'],
                    ['title' => 'Fast delivery', 'desc' => 'Delivered the same day or by the next working day in Mumbai.', 'icon' => 'M3 7h13a4 4 0 0 1 0 8H10 M7 11l-4 4 4 4'],
                    ['title' => 'Real warranty', 'desc' => 'Full manufacturer warranty — we handle any claim for you.', 'icon' => 'M9 12l2 2 4-4 M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z'],
                ] as $card)
                    <div class="flex items-start gap-3">
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-brand-600 text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $card['icon'] }}"/></svg>
                        </span>
                        <div>
                            <p class="text-sm font-bold text-ink-900">{{ $card['title'] }}</p>
                            <p class="mt-0.5 text-xs leading-relaxed text-ink-600">{{ $card['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ WHY US ============ --}}
    <section class="mt-14">
        <div class="text-center">
            <p class="text-xs font-bold uppercase tracking-widest text-brand-600">Why choose us</p>
            <h2 class="mt-2 text-2xl font-extrabold text-ink-900 sm:text-3xl">A shop, delivered.</h2>
            <p class="mx-auto mt-2 max-w-2xl text-sm text-ink-600">Everything you'd expect at a good battery shop — brought to your driveway, at the same price or better.</p>
        </div>

        <div class="mt-8 grid gap-5 md:grid-cols-3">
            @foreach([
                ['title' => 'Only authorised stock', 'desc' => 'We buy direct from Exide, Amaron and SF Sonic authorised dealers. No refurbished. No grey market. Serial numbers match the box.'],
                ['title' => 'Transparent pricing', 'desc' => 'MRP shown upfront. Old battery discount calculated on the spot. No hidden delivery, installation, or "handling" charges.'],
                ['title' => 'Local team', 'desc' => 'Every technician is on our payroll — no random agencies. We know our routes, and we call before we arrive.'],
            ] as $card)
                <div class="card p-5">
                    <div class="grid h-10 w-10 place-items-center rounded-lg bg-brand-100 text-brand-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m5 13 4 4L19 7"/></svg>
                    </div>
                    <h3 class="mt-3 text-sm font-bold text-ink-900">{{ $card['title'] }}</h3>
                    <p class="mt-1 text-xs leading-relaxed text-ink-600">{{ $card['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ SERVICE AREA ============ --}}
    <section class="mt-14">
        <div class="card overflow-hidden p-6 sm:p-10">
            <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_360px] lg:items-center">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-brand-600">Service area</p>
                    <h2 class="mt-2 text-2xl font-extrabold text-ink-900 sm:text-3xl">Where we deliver</h2>
                    <p class="mt-3 text-sm text-ink-600 sm:text-base">Flat ₹99 delivery across our home zone (Navi Mumbai + Thane + Mulund–Kanjurmarg belt). ₹199 for the extended Central Railway line. <strong>Free delivery on orders above ₹12,000.</strong></p>

                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-lg border-2 border-brand-200 bg-brand-50/40 p-3">
                            <p class="text-sm font-bold text-ink-900">Zone A — Home base</p>
                            <p class="mt-1 text-xs text-ink-600 leading-relaxed">Rabale · Airoli · Ghansoli · Kopar Khairane · Turbhe · Vashi · Sanpada · Juinagar · Nerul · Thane (West + East) · Kalwa · Mulund · Nahur · Bhandup · Kanjurmarg</p>
                            <p class="mt-2 text-xs font-bold text-green-700">₹99 · Same or next day</p>
                        </div>
                        <div class="rounded-lg border border-ink-200 p-3">
                            <p class="text-sm font-bold text-ink-900">Zone B — Central Railway</p>
                            <p class="mt-1 text-xs text-ink-600 leading-relaxed">Mumbra · Diva · Dombivli (East + West) · Kalyan (East + West)</p>
                            <p class="mt-2 text-xs font-bold text-green-700">₹199 · 1–2 business days</p>
                        </div>
                    </div>
                    <p class="mt-3 text-xs italic text-ink-500">Any pincode outside these zones? Sorry — we're not delivering there yet. We're focused on getting our home zones perfectly right first.</p>
                </div>

                <div class="rounded-xl bg-ink-50 p-5 text-center ring-1 ring-ink-200">
                    <p class="text-xs font-bold uppercase tracking-widest text-brand-600">Not sure?</p>
                    <h3 class="mt-2 text-lg font-bold text-ink-900">Check your pincode</h3>
                    <p class="mt-1 text-xs text-ink-600">Get instant confirmation of delivery availability and charges.</p>
                    <a href="{{ url('/products') }}" class="btn btn-primary mt-4 w-full">Check now →</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ CTA ============ --}}
    <section class="mt-14 mb-8">
        <div class="rounded-2xl px-6 py-10 text-center sm:px-10 sm:py-14" style="background:linear-gradient(135deg,#dc2626,#991b1b);">
            <h2 class="text-2xl font-extrabold text-white sm:text-3xl">Need a battery today?</h2>
            <p class="mx-auto mt-2 max-w-md text-sm text-white/85 sm:text-base">Call us, WhatsApp us, or browse the catalog. Our Mumbai team is standing by.</p>
            <div class="mt-6 flex flex-wrap justify-center gap-3">
                <a href="tel:{{ $phoneTel }}" class="btn text-brand-700" style="background:#fff;">📞 Call {{ $phone }}</a>
                <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" class="btn text-white" style="background:rgba(0,0,0,0.25); border:1px solid rgba(255,255,255,0.35);">💬 WhatsApp us</a>
                <a href="{{ url('/products') }}" class="btn text-white" style="background:transparent; border:1px solid rgba(255,255,255,0.55);">Browse batteries</a>
            </div>
        </div>
    </section>

</x-layouts.app>
