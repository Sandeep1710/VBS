@php
    $phone    = \App\Models\Setting::get('support_phone', '+91 9920971479');
    $whatsapp = \App\Models\Setting::get('whatsapp_number', '+919920971479');
    $email    = \App\Models\Setting::get('support_email', 'vbs622026@gmail.com');
    $address  = \App\Models\Setting::get('address', 'R-30, MIDC Area Rd, MIDC Industrial Area, Rabale, Navi Mumbai, Maharashtra 400701');
    $phoneTel = preg_replace('/[^0-9+]/', '', $phone);
    $waNumber = preg_replace('/[^0-9]/', '', $whatsapp);
    $mapsQuery = urlencode('R-30 MIDC Area Rd, MIDC Industrial Area, Rabale, Navi Mumbai, Maharashtra 400701');
@endphp

<x-layouts.app :title="$page->meta_title ?? ($page->title . ' | Trikuti Battery')" :metaDescription="$page->meta_description">

    {{-- ============ HERO ============ --}}
    <section class="relative overflow-hidden rounded-2xl shadow-2xl" style="background:#0f172a;">
        <div class="absolute pointer-events-none" style="left:-160px; top:50%; transform:translateY(-50%); width:640px; height:640px; background:radial-gradient(circle, rgba(220,38,38,.5), transparent 60%); filter:blur(70px);"></div>
        <div class="absolute pointer-events-none" style="right:-160px; top:30%; width:520px; height:520px; background:radial-gradient(circle, rgba(20,184,166,.28), transparent 60%); filter:blur(80px);"></div>

        <div class="relative px-6 py-14 text-center sm:px-10 sm:py-20">
            <p class="text-[10px] font-bold uppercase tracking-[0.4em]" style="color:rgba(255,255,255,0.7);">Get in touch</p>
            <h1 class="mt-4 text-4xl font-extrabold leading-tight text-white sm:text-5xl">
                We're a call, chat or email away
            </h1>
            <p class="mx-auto mt-4 max-w-2xl text-sm leading-relaxed sm:text-base" style="color:rgba(255,255,255,0.75);">
                Our Mumbai team is available <strong class="text-white">Monday to Saturday, 9 AM – 8 PM</strong>. Typical reply on WhatsApp: within 15 minutes.
            </p>

            <div class="mt-3 inline-flex items-center gap-2 rounded-full bg-green-500/15 px-3 py-1.5 ring-1 ring-green-500/30">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-green-400"></span>
                </span>
                <span class="text-xs font-semibold text-green-300">We're online now</span>
            </div>
        </div>
    </section>

    {{-- ============ 3 CONTACT CARDS ============ --}}
    <section class="-mt-8 relative z-10 grid gap-4 px-2 sm:grid-cols-3 sm:px-4">
        {{-- Call --}}
        <a href="tel:{{ $phoneTel }}" class="group card p-5 transition-all hover:-translate-y-1 hover:shadow-lg">
            <span class="grid h-12 w-12 place-items-center rounded-xl bg-brand-100 text-brand-700 transition-transform group-hover:scale-110">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
            </span>
            <p class="mt-4 text-xs font-bold uppercase tracking-wider text-brand-600">Call us</p>
            <p class="mt-1 text-lg font-extrabold text-ink-900">{{ $phone }}</p>
            <p class="mt-1 text-xs text-ink-500">Mon–Sat · 9 AM – 8 PM</p>
            <p class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-brand-600 group-hover:gap-2 transition-all">
                Tap to call
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 6 6 6-6 6"/></svg>
            </p>
        </a>

        {{-- WhatsApp --}}
        <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" class="group card p-5 transition-all hover:-translate-y-1 hover:shadow-lg">
            <span class="grid h-12 w-12 place-items-center rounded-xl transition-transform group-hover:scale-110" style="background:#dcfce7; color:#15803d;">
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 0 1 8.413 3.488 11.824 11.824 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
            </span>
            <p class="mt-4 text-xs font-bold uppercase tracking-wider" style="color:#15803d;">WhatsApp us</p>
            <p class="mt-1 text-lg font-extrabold text-ink-900">{{ $whatsapp }}</p>
            <p class="mt-1 text-xs text-ink-500">Fastest reply · ~15 min</p>
            <p class="mt-3 inline-flex items-center gap-1 text-xs font-semibold group-hover:gap-2 transition-all" style="color:#15803d;">
                Start chat
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 6 6 6-6 6"/></svg>
            </p>
        </a>

        {{-- Email --}}
        <a href="mailto:{{ $email }}" class="group card p-5 transition-all hover:-translate-y-1 hover:shadow-lg">
            <span class="grid h-12 w-12 place-items-center rounded-xl transition-transform group-hover:scale-110" style="background:#e0e7ff; color:#4338ca;">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2Z M22 6l-10 7L2 6"/></svg>
            </span>
            <p class="mt-4 text-xs font-bold uppercase tracking-wider" style="color:#4338ca;">Email us</p>
            <p class="mt-1 truncate text-lg font-extrabold text-ink-900">{{ $email }}</p>
            <p class="mt-1 text-xs text-ink-500">Reply within 4 working hours</p>
            <p class="mt-3 inline-flex items-center gap-1 text-xs font-semibold group-hover:gap-2 transition-all" style="color:#4338ca;">
                Send email
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 6 6 6-6 6"/></svg>
            </p>
        </a>
    </section>

    {{-- ============ ADDRESS + HOURS + MAP ============ --}}
    <section class="mt-10 grid gap-6 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.4fr)]">

        {{-- Left: Address + hours + brands --}}
        <div class="space-y-6">
            <div class="card p-6">
                <p class="text-xs font-bold uppercase tracking-widest text-brand-600">Visit us</p>
                <h3 class="mt-2 text-lg font-bold text-ink-900">Our shop &amp; warehouse</h3>
                <div class="mt-3 flex gap-3">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-brand-100 text-brand-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z M12 10a2 2 0 1 1 0-4 2 2 0 0 1 0 4Z"/></svg>
                    </span>
                    <p class="text-sm leading-relaxed text-ink-700">{{ $address }}</p>
                </div>
                <a href="https://www.google.com/maps/search/?api=1&query={{ $mapsQuery }}" target="_blank" rel="noopener" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-600 hover:text-brand-700">
                    Get directions →
                </a>
            </div>

            <div class="card p-6">
                <p class="text-xs font-bold uppercase tracking-widest text-brand-600">Business hours</p>
                <h3 class="mt-2 text-lg font-bold text-ink-900">When we're online</h3>
                <ul class="mt-3 divide-y divide-ink-200/60 text-sm">
                    @foreach([
                        ['Monday – Friday', '9:00 AM – 8:00 PM', true],
                        ['Saturday',         '9:00 AM – 8:00 PM', true],
                        ['Sunday',           'Closed',            false],
                    ] as [$day, $hours, $open])
                        <li class="flex items-center justify-between py-2.5">
                            <span class="text-ink-700">{{ $day }}</span>
                            <span class="font-semibold {{ $open ? 'text-green-700' : 'text-ink-400' }}">{{ $hours }}</span>
                        </li>
                    @endforeach
                </ul>
                <p class="mt-3 rounded-lg bg-blue-50 p-3 text-xs text-blue-800 ring-1 ring-blue-200">
                    💡 <strong>WhatsApp us anytime</strong> — we reply first thing the next working morning if you message outside hours.
                </p>
            </div>

            <div class="card p-6">
                <p class="text-xs font-bold uppercase tracking-widest text-brand-600">Brands we stock</p>
                <h3 class="mt-2 text-lg font-bold text-ink-900">Genuine, authorised, warranty-backed</h3>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach(['Exide', 'Amaron', 'Luminous', 'SF Sonic', 'Bosch'] as $brand)
                        <span class="badge bg-ink-100 text-ink-800">{{ $brand }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right: Map --}}
        <div class="card overflow-hidden">
            <div class="aspect-[4/3] w-full bg-ink-50">
                <iframe
                    title="Trikuti Battery — Rabale, Navi Mumbai"
                    src="https://www.google.com/maps?q={{ $mapsQuery }}&output=embed"
                    class="h-full w-full border-0"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="border-t border-ink-200/60 p-4">
                <div class="flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-ink-900">R-30, MIDC Rabale</p>
                        <p class="truncate text-xs text-ink-500">Navi Mumbai · 400701</p>
                    </div>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $mapsQuery }}" target="_blank" rel="noopener" class="btn btn-outline text-xs">Directions →</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ CTA STRIP ============ --}}
    <section class="mt-14 mb-8">
        <div class="rounded-2xl px-6 py-10 text-center sm:px-10 sm:py-14" style="background:linear-gradient(135deg,#dc2626,#991b1b);">
            <h2 class="text-2xl font-extrabold text-white sm:text-3xl">Ready to order?</h2>
            <p class="mx-auto mt-2 max-w-md text-sm text-white/85 sm:text-base">Browse the catalog, pick your battery, and our team will call you back to confirm.</p>
            <div class="mt-6 flex flex-wrap justify-center gap-3">
                <a href="{{ url('/products') }}" class="btn text-brand-700" style="background:#fff;">Browse batteries →</a>
                <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" class="btn text-white" style="background:rgba(0,0,0,0.25); border:1px solid rgba(255,255,255,0.35);">💬 WhatsApp us</a>
            </div>
        </div>
    </section>

</x-layouts.app>
