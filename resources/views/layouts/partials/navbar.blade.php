@php
    $cartCount = app(\App\Services\Cart\CartService::class)->itemsCount();
@endphp

<header class="sticky top-0 z-40 border-b border-ink-200/60 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80">
    <div class="container-page flex h-16 items-center justify-between gap-4">
        <div class="flex items-center gap-6">
            <x-logo size="md" />
            {{-- Desktop nav (md+) --}}
            <nav class="hidden items-center gap-6 text-sm font-medium text-ink-700 md:flex">
                <a href="{{ url('/') }}" class="hover:text-brand-600">Home</a>
                <a href="{{ url('/products') }}" class="hover:text-brand-600">Batteries</a>
                <a href="{{ url('/finder') }}" class="hover:text-brand-600">Find My Battery</a>
                <a href="{{ url('/cms/about-us') }}" class="hover:text-brand-600">About</a>
                <a href="{{ url('/cms/contact-us') }}" class="hover:text-brand-600">Contact</a>
            </nav>
        </div>

        <div class="flex items-center gap-2 sm:gap-3">
            <a href="{{ route('cart.index') }}" class="relative inline-flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium text-ink-700 hover:bg-ink-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/>
                </svg>
                @if($cartCount > 0)
                    <span class="absolute -right-1 -top-1 grid h-5 min-w-5 place-items-center rounded-full bg-brand-600 px-1 text-[10px] font-bold text-white">{{ $cartCount }}</span>
                @endif
                <span class="hidden sm:inline">Cart</span>
            </a>

            {{-- Mobile hamburger button (visible below md) --}}
            <button type="button"
                    id="mobile-menu-button"
                    aria-label="Open menu"
                    aria-controls="mobile-menu-panel"
                    aria-expanded="false"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-ink-700 hover:bg-ink-100 md:hidden">
                {{-- Hamburger icon (shown when closed) --}}
                <svg id="mobile-menu-icon-open" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/>
                </svg>
                {{-- Close icon (shown when open) --}}
                <svg id="mobile-menu-icon-close" class="hidden h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <line x1="6" y1="6" x2="18" y2="18"/><line x1="6" y1="18" x2="18" y2="6"/>
                </svg>
            </button>

            {{-- LEAD-GEN MODE: Login / Signup / My Account hidden. --}}
            {{-- Uncomment the @auth ... @endauth block below to restore full customer accounts. --}}
            {{--
            @auth
                <div class="relative">
                    <button type="button" data-toggle="dropdown" data-target="#user-menu" class="inline-flex items-center gap-2 rounded-lg bg-ink-100 px-3 py-2 text-sm font-medium text-ink-800 hover:bg-ink-200">
                        <span class="grid h-7 w-7 place-items-center rounded-full bg-brand-100 text-xs font-bold text-brand-700">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="hidden md:inline">{{ Str::limit(auth()->user()->name, 14) }}</span>
                    </button>
                    <div id="user-menu" data-dropdown-menu class="absolute right-0 z-50 mt-2 hidden w-52 overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-ink-200">
                        <a href="{{ route('account.dashboard') }}" class="block px-4 py-2 text-sm text-ink-700 hover:bg-ink-50">My Account</a>
                        <a href="{{ route('account.orders.index') }}" class="block px-4 py-2 text-sm text-ink-700 hover:bg-ink-50">My Orders</a>
                        <a href="{{ route('account.addresses.index') }}" class="block px-4 py-2 text-sm text-ink-700 hover:bg-ink-50">Addresses</a>
                        <a href="{{ route('account.profile.edit') }}" class="block px-4 py-2 text-sm text-ink-700 hover:bg-ink-50">Profile</a>
                        <div class="border-t border-ink-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50">Log out</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="hidden text-sm font-medium text-ink-700 hover:text-brand-600 sm:inline">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Sign up</a>
            @endauth
            --}}
        </div>
    </div>

    {{-- Mobile menu panel (slides down below the header when open) --}}
    <div id="mobile-menu-panel" class="hidden border-t border-ink-200/60 bg-white md:hidden">
        <nav class="container-page flex flex-col divide-y divide-ink-100 py-2 text-sm font-medium text-ink-800">
            <a href="{{ url('/') }}" class="flex items-center gap-3 px-2 py-3 hover:bg-ink-50">
                <svg class="h-5 w-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 12 12 3l9 9M5 10v10h14V10"/></svg>
                Home
            </a>
            <a href="{{ url('/products') }}" class="flex items-center gap-3 px-2 py-3 hover:bg-ink-50">
                <svg class="h-5 w-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M7 4h10a1 1 0 0 1 1 1v1h1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h1V5a1 1 0 0 1 1-1Z"/></svg>
                Batteries
            </a>
            <a href="{{ url('/finder') }}" class="flex items-center gap-3 px-2 py-3 hover:bg-ink-50">
                <svg class="h-5 w-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                Find My Battery
            </a>
            <a href="{{ url('/cms/about-us') }}" class="flex items-center gap-3 px-2 py-3 hover:bg-ink-50">
                <svg class="h-5 w-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                About
            </a>
            <a href="{{ url('/cms/contact-us') }}" class="flex items-center gap-3 px-2 py-3 hover:bg-ink-50">
                <svg class="h-5 w-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M4 4h16v12H5l-1 4z"/></svg>
                Contact
            </a>

            {{-- Quick-call CTA at the bottom of the mobile menu --}}
            @php
                $phone = \App\Models\Setting::get('support_phone', '+91 9920971479');
                $whatsapp = \App\Models\Setting::get('whatsapp_number', '+919920971479');
                $waNumber = preg_replace('/[^0-9]/', '', $whatsapp);
                $phoneTel = preg_replace('/[^0-9+]/', '', $phone);
            @endphp
            <div class="flex gap-2 px-2 py-3">
                <a href="tel:{{ $phoneTel }}" class="flex-1 rounded-lg bg-brand-600 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-brand-700">
                    📞 Call
                </a>
                <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" class="flex-1 rounded-lg bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-green-700">
                    💬 WhatsApp
                </a>
            </div>
        </nav>
    </div>
</header>

<script>
    (function () {
        var btn = document.getElementById('mobile-menu-button');
        var panel = document.getElementById('mobile-menu-panel');
        var iconOpen = document.getElementById('mobile-menu-icon-open');
        var iconClose = document.getElementById('mobile-menu-icon-close');
        if (!btn || !panel) return;

        btn.addEventListener('click', function () {
            var isOpen = !panel.classList.contains('hidden');
            panel.classList.toggle('hidden', isOpen);
            iconOpen.classList.toggle('hidden', !isOpen);
            iconClose.classList.toggle('hidden', isOpen);
            btn.setAttribute('aria-expanded', String(!isOpen));
            btn.setAttribute('aria-label', isOpen ? 'Open menu' : 'Close menu');
        });

        // Close on route change / any link click inside the panel
        panel.addEventListener('click', function (e) {
            if (e.target.closest('a')) {
                panel.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
                btn.setAttribute('aria-expanded', 'false');
                btn.setAttribute('aria-label', 'Open menu');
            }
        });

        // Close if window is resized past md breakpoint
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 768) {
                panel.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
                btn.setAttribute('aria-expanded', 'false');
            }
        });
    })();
</script>
