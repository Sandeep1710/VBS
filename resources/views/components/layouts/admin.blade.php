@props(['title' => 'Admin', 'header' => null, 'subheader' => null, 'actions' => null])

@php
    $user = auth()->user();
    $initials = collect(explode(' ', trim((string) $user?->name)))
        ->take(2)
        ->map(fn ($p) => strtoupper(substr($p, 0, 1)))
        ->implode('');

    $sections = [
        [
            'heading' => 'General',
            'items' => [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'icon' => 'M3 12 12 3l9 9M5 10v10h14V10'],
            ],
        ],
        [
            'heading' => 'Sales',
            'items' => [
                ['label' => 'Orders', 'route' => 'admin.orders.index', 'match' => 'admin.orders.*', 'icon' => 'M3 7h18v13H3z M8 7V4h8v3'],
                ['label' => 'Coupons', 'route' => 'admin.coupons.index', 'match' => 'admin.coupons.*', 'icon' => 'M20.6 11.4 12.4 3.2A2 2 0 0 0 11 2.6L4 3a2 2 0 0 0-2 2v6a2 2 0 0 0 .6 1.4l8.2 8.2a2 2 0 0 0 2.8 0l7-7a2 2 0 0 0 0-2.2zM7 7a1 1 0 1 0 0 2 1 1 0 0 0 0-2z'],
                ['label' => 'Returns', 'route' => 'admin.returns.index', 'match' => 'admin.returns.*', 'icon' => 'M3 7h13a4 4 0 0 1 0 8H10 M7 11l-4 4 4 4'],
                ['label' => 'Warranty Claims', 'route' => 'admin.warranty-claims.index', 'match' => 'admin.warranty-claims.*', 'icon' => 'M9 12l2 2 4-4 M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z'],
            ],
        ],
        [
            'heading' => 'Catalog',
            'items' => [
                ['label' => 'Products', 'route' => 'admin.products.index', 'match' => 'admin.products.*', 'icon' => 'M21 16V8a2 2 0 0 0-1-1.7l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.7l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z M3.3 7 12 12l8.7-5 M12 22V12'],
                ['label' => 'Categories', 'route' => 'admin.categories.index', 'match' => 'admin.categories.*', 'icon' => 'M3 4h7v7H3z M14 4h7v7h-7z M3 14h7v7H3z M14 14h7v7h-7z'],
                ['label' => 'Battery Brands', 'route' => 'admin.brands.index', 'match' => 'admin.brands.*', 'icon' => 'M12 2 4 5v6c0 5 3.4 9.4 8 10 4.6-.6 8-5 8-10V5l-8-3Z M9 12l2 2 4-4'],
                ['label' => 'Reviews', 'route' => 'admin.reviews.index', 'match' => 'admin.reviews.*', 'icon' => 'm12 2 3 7h7l-5.5 4.5L18 21l-6-4-6 4 1.5-7.5L2 9h7z'],
            ],
        ],
        [
            'heading' => 'Customers',
            'items' => [
                ['label' => 'Customers', 'route' => 'admin.customers.index', 'match' => 'admin.customers.*', 'icon' => 'M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0Zm-8 8h8a4 4 0 0 1 4 4v2H4v-2a4 4 0 0 1 4-4Z'],
            ],
        ],
        [
            'heading' => 'Home Page',
            'items' => [
                ['label' => 'Banners', 'route' => 'admin.banners.index', 'match' => 'admin.banners.*', 'icon' => 'M3 5h18v14H3z M3 12h18'],
                ['label' => 'Testimonials', 'route' => 'admin.testimonials.index', 'match' => 'admin.testimonials.*', 'icon' => 'm12 2 3 7h7l-5.5 4.5L18 21l-6-4-6 4 1.5-7.5L2 9h7z'],
                ['label' => 'FAQs', 'route' => 'admin.faqs.index', 'match' => 'admin.faqs.*', 'icon' => 'M9.1 9a3 3 0 1 1 5.8 1c0 2-3 3-3 3 M12 17h.01 M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z'],
            ],
        ],
        [
            'heading' => 'Pages',
            'items' => [
                ['label' => 'About Us', 'href' => route('admin.pages.index', ['tab' => 'about-us']),
                 'match' => fn () => request()->routeIs('admin.pages.*') && (request()->query('tab', 'about-us') === 'about-us'),
                 'icon' => 'M12 14a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z M4 22a8 8 0 0 1 16 0'],
                ['label' => 'Contact Us', 'href' => route('admin.pages.index', ['tab' => 'contact-us']),
                 'match' => fn () => request()->routeIs('admin.pages.*') && request()->query('tab') === 'contact-us',
                 'icon' => 'M4 4h16v12H5l-1 4z'],
            ],
        ],
        [
            'heading' => 'Settings',
            'items' => [
                ['label' => 'Delivery Pincodes', 'route' => 'admin.pincodes.index', 'match' => 'admin.pincodes.*', 'icon' => 'M12 2a8 8 0 0 0-8 8c0 6 8 12 8 12s8-6 8-12a8 8 0 0 0-8-8Zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z'],
            ],
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    @include('layouts.partials.head')

    {{-- DataTables (admin-only) --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <style>
        /* Base styles that apply BEFORE and AFTER DataTables initializes */
        table.datatable, table.dataTable { width: 100% !important; border-collapse: separate; border-spacing: 0; }
        table.datatable thead th, table.dataTable thead th {
            font-weight: 600; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.06em; color: #64748b;
            padding: 0.875rem 1.25rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc; text-align: left; white-space: nowrap;
        }
        table.datatable tbody td, table.dataTable tbody td {
            padding: 1rem 1.25rem; font-size: 0.875rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; color: #334155;
        }
        table.datatable tbody tr:hover, table.dataTable tbody tr:hover { background-color: #f8fafc; }
        table.datatable tbody tr:last-child td, table.dataTable tbody tr:last-child td { border-bottom: 0; }

        /* DataTables search + paging + info */
        .dt-search input, .dt-length select { border: 1px solid #cbd5e1; border-radius: 0.5rem; padding: 0.5rem 0.875rem; font-size: 0.875rem; background: white; }
        .dt-search input:focus, .dt-length select:focus { outline: none; border-color: #dc2626; box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1); }
        .dt-paging .dt-paging-button { padding: 0.5rem 0.875rem; margin: 0 0.125rem; border-radius: 0.5rem; font-size: 0.8125rem; background: white; border: 1px solid #e2e8f0; color: #475569; }
        .dt-paging .dt-paging-button.current { background-color: #dc2626 !important; color: white !important; border-color: #dc2626 !important; }
        .dt-paging .dt-paging-button:hover:not(.current):not(.disabled) { background-color: #f1f5f9 !important; }
        .dt-info { font-size: 0.8125rem; color: #64748b; }
        .dt-layout-row { padding: 0.75rem 1rem; gap: 0.75rem; }
        .dt-layout-cell { padding: 0 !important; }

        /* Action button pills */
        .table-action-edit { display: inline-flex; align-items: center; padding: 0.375rem 0.75rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 600; background: #fee2e2; color: #b91c1c; transition: background 0.15s; }
        .table-action-edit:hover { background: #fecaca; }
        .table-action-delete { display: inline-flex; align-items: center; padding: 0.375rem 0.75rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 600; background: #f1f5f9; color: #475569; border: 0; cursor: pointer; transition: background 0.15s; }
        .table-action-delete:hover { background: #e2e8f0; color: #b91c1c; }
        .table-actions { display: inline-flex; align-items: center; gap: 0.5rem; white-space: nowrap; }
    </style>
</head>
<body class="min-h-full bg-ink-50">
    <div class="flex min-h-screen">
        <aside class="hidden w-64 shrink-0 flex-col bg-ink-900 text-ink-100 md:flex">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 border-b border-ink-800 px-5 py-5 transition-colors hover:bg-ink-800/40">
                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-brand-600 text-white">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M7 4h10a1 1 0 0 1 1 1v1h1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h1V5a1 1 0 0 1 1-1Zm1 2v0Zm-1 6h3v-2H7v2Zm7 0h3v-2h-3v2Z"/></svg>
                </span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold leading-none text-white">{{ \App\Models\Setting::get('site_name', 'Trikuti Battery') }}</p>
                    <p class="mt-1 text-[10px] font-medium uppercase tracking-wider text-ink-400">Admin panel</p>
                </div>
            </a>

            <nav class="flex-1 overflow-y-auto px-3 py-5">
                @foreach($sections as $section)
                    <p class="px-3 pb-2 pt-3 text-[10px] font-semibold uppercase tracking-wider text-ink-500">{{ $section['heading'] }}</p>
                    <div class="space-y-0.5">
                        @foreach($section['items'] as $item)
                            @php
                                $href = $item['href'] ?? route($item['route']);
                                $active = isset($item['match']) && (is_callable($item['match']) ? $item['match']() : request()->routeIs($item['match']));
                            @endphp
                            <a href="{{ $href }}"
                               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ $active ? 'bg-brand-600 text-white shadow-sm' : 'text-ink-300 hover:bg-ink-800 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $item['icon'] }}"/></svg>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </nav>

            <div class="border-t border-ink-800 px-3 py-4">
                <a href="{{ url('/') }}" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-lg px-3 py-2 text-xs font-medium text-ink-400 hover:bg-ink-800 hover:text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M14 3h7v7M10 14 21 3M21 14v7H3V3h7"/></svg>
                    View site
                </a>
            </div>
        </aside>

        <div class="flex flex-1 flex-col">
            <header class="sticky top-0 z-30 border-b border-ink-200 bg-white">
                <div class="flex items-center justify-between gap-4 px-6 py-3">
                    <div class="min-w-0 flex-1">
                        @if($header)
                            <h1 class="truncate text-base font-semibold text-ink-900 sm:text-lg">{{ $header }}</h1>
                            @if($subheader)
                                <p class="truncate text-xs text-ink-500">{{ $subheader }}</p>
                            @endif
                        @endif
                    </div>

                    <div class="flex items-center gap-3">
                        @if($actions)
                            {{ $actions }}
                        @endif
                        <div class="relative">
                            <button type="button" data-toggle="dropdown" data-target="#admin-user-menu" class="flex items-center gap-3 rounded-lg px-2 py-1.5 hover:bg-ink-100">
                                <div class="grid h-9 w-9 place-items-center rounded-full bg-brand-100 text-sm font-bold text-brand-700">{{ $initials ?: 'A' }}</div>
                                <div class="hidden text-left sm:block">
                                    <p class="text-sm font-semibold leading-none text-ink-900">{{ $user?->name }}</p>
                                    <p class="mt-1 text-[10px] font-medium uppercase tracking-wider text-ink-500">Admin</p>
                                </div>
                                <svg class="h-4 w-4 text-ink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                            <div id="admin-user-menu" data-dropdown-menu class="absolute right-0 z-50 mt-2 hidden w-52 overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-ink-200">
                                <div class="border-b border-ink-100 px-4 py-3">
                                    <p class="text-sm font-semibold text-ink-900">{{ $user?->name }}</p>
                                    <p class="text-xs text-ink-500">{{ $user?->email }}</p>
                                </div>
                                <a href="{{ url('/') }}" target="_blank" rel="noopener" class="block px-4 py-2 text-sm text-ink-700 hover:bg-ink-50">View site ↗</a>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50">Sign out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1">
                <div class="mx-auto max-w-7xl px-6 py-6">
                    <x-flash />
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: @json(session('success')),
                    showConfirmButton: false, timer: 2400, timerProgressBar: true });
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: @json(session('error')),
                    showConfirmButton: false, timer: 3500, timerProgressBar: true });
            });
        </script>
    @endif

    <script>
        $(function () {
            $('table.datatable').each(function () {
                $(this).DataTable({ pageLength: 25, order: [], autoWidth: false });
            });

            $(document).on('submit', '.js-delete-form', function (e) {
                e.preventDefault();
                const form = this;
                Swal.fire({
                    title: form.dataset.confirmTitle || 'Delete this record?',
                    text: form.dataset.confirmText || 'This action cannot be undone.',
                    icon: 'warning', showCancelButton: true,
                    confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, delete it', cancelButtonText: 'Cancel',
                }).then((r) => { if (r.isConfirmed) form.submit(); });
            });
        });
    </script>

    @stack('page-scripts')
</body>
</html>
