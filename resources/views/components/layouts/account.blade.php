@php
    $accountNav = [
        ['label' => 'Dashboard', 'route' => 'account.dashboard', 'icon' => 'M3 12 12 3l9 9M5 10v10h14V10'],
        ['label' => 'My Orders', 'route' => 'account.orders.index', 'icon' => 'M3 6h18M3 12h18M3 18h18'],
        ['label' => 'Wishlist', 'route' => 'account.wishlist.index', 'icon' => 'M12 21s-7-4.5-9.5-9A5 5 0 0 1 12 5.7 5 5 0 0 1 21.5 12c-2.5 4.5-9.5 9-9.5 9z'],
        ['label' => 'Addresses', 'route' => 'account.addresses.index', 'icon' => 'M12 2a8 8 0 0 0-8 8c0 6 8 12 8 12s8-6 8-12a8 8 0 0 0-8-8Zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z'],
        ['label' => 'Profile', 'route' => 'account.profile.edit', 'icon' => 'M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0Zm-8 8h8a4 4 0 0 1 4 4v2H4v-2a4 4 0 0 1 4-4Z'],
        ['label' => 'Change Password', 'route' => 'account.password.edit', 'icon' => 'M12 15v2m-6-7V8a6 6 0 0 1 12 0v2M5 10h14v10H5z'],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    @include('layouts.partials.head')
</head>
<body class="flex min-h-full flex-col">
    @include('layouts.partials.navbar')

    <main class="flex-1">
        <div class="container-page py-8">
            <x-flash />

            <div class="grid gap-6 lg:grid-cols-[260px_minmax(0,1fr)]">
                <aside class="card overflow-hidden">
                    <div class="border-b border-ink-200/60 p-5">
                        <p class="text-xs font-medium uppercase tracking-wider text-ink-500">Signed in as</p>
                        <p class="mt-1 truncate text-sm font-semibold text-ink-900">{{ auth()->user()->name }}</p>
                        <p class="truncate text-xs text-ink-500">{{ auth()->user()->email }}</p>
                    </div>
                    <nav class="p-2">
                        @foreach($accountNav as $item)
                            @php $active = request()->routeIs($item['route']); @endphp
                            <a href="{{ route($item['route']) }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ $active ? 'bg-brand-50 text-brand-700' : 'text-ink-700 hover:bg-ink-100' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="{{ $item['icon'] }}"/>
                                </svg>
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                        <form method="POST" action="{{ route('logout') }}" class="mt-2 border-t border-ink-100 pt-2">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                                Log out
                            </button>
                        </form>
                    </nav>
                </aside>

                <section>
                    @if(isset($header))
                        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-ink-900">{{ $header }}</h1>
                                @isset($subheader)
                                    <p class="mt-1 text-sm text-ink-600">{{ $subheader }}</p>
                                @endisset
                            </div>
                            @isset($actions)
                                <div>{{ $actions }}</div>
                            @endisset
                        </div>
                    @endif
                    {{ $slot }}
                </section>
            </div>
        </div>
    </main>

    @include('layouts.partials.footer')
</body>
</html>
