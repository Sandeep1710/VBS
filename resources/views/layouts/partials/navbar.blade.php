@php
    $cartCount = app(\App\Services\Cart\CartService::class)->itemsCount();
@endphp

<header class="sticky top-0 z-40 border-b border-ink-200/60 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80">
    <div class="container-page flex h-16 items-center justify-between gap-4">
        <div class="flex items-center gap-6">
            <x-logo size="md" />
            <nav class="hidden items-center gap-6 text-sm font-medium text-ink-700 md:flex">
                <a href="{{ url('/') }}" class="hover:text-brand-600">Home</a>
                <a href="{{ url('/products') }}" class="hover:text-brand-600">Batteries</a>
                <a href="{{ url('/finder') }}" class="hover:text-brand-600">Find My Battery</a>
                <a href="{{ url('/cms/about-us') }}" class="hover:text-brand-600">About</a>
                <a href="{{ url('/cms/contact-us') }}" class="hover:text-brand-600">Contact</a>
            </nav>
        </div>

        <div class="flex items-center gap-3">
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
        </div>
    </div>
</header>
