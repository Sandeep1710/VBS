<x-layouts.admin
    :title="'Dashboard'"
    :header="'Welcome ' . (auth()->user()->name ?? 'Admin')"
    :subheader="'Trikuti Battery admin'"
>
    {{-- Revenue strip --}}
    <div class="grid gap-4 sm:grid-cols-3">
        <div class="card p-5">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-500">Revenue today</p>
            <p class="mt-2 text-3xl font-bold text-ink-900">₹{{ number_format($stats['orders']['revenue_today'], 0) }}</p>
            <p class="mt-1 text-xs text-ink-500">{{ $stats['orders']['today'] }} orders placed today</p>
        </div>
        <div class="card p-5">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-500">Revenue this month</p>
            <p class="mt-2 text-3xl font-bold text-ink-900">₹{{ number_format($stats['orders']['revenue_month'], 0) }}</p>
            <p class="mt-1 text-xs text-ink-500">from completed orders</p>
        </div>
        <div class="card p-5">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-500">Lifetime revenue</p>
            <p class="mt-2 text-3xl font-bold text-ink-900">₹{{ number_format($stats['orders']['revenue_total'], 0) }}</p>
            <p class="mt-1 text-xs text-ink-500">{{ $stats['orders']['total'] }} total orders</p>
        </div>
    </div>

    {{-- Metric cards --}}
    <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="card relative block overflow-hidden p-5 transition-transform hover:-translate-y-0.5">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-500">Pending orders</p>
            <p class="mt-2 text-3xl font-bold text-amber-600">{{ $stats['orders']['pending'] }}</p>
            <p class="mt-1 text-xs text-ink-500">needs confirmation</p>
            <div class="absolute -right-4 -top-4 grid h-20 w-20 place-items-center rounded-2xl bg-amber-100 text-amber-600">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 7h18v13H3z M8 7V4h8v3"/></svg>
            </div>
        </a>

        <a href="{{ route('admin.products.index') }}" class="card relative block overflow-hidden p-5 transition-transform hover:-translate-y-0.5">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-500">Products</p>
            <p class="mt-2 text-3xl font-bold text-ink-900">{{ $stats['products']['total'] }}</p>
            <p class="mt-1 text-xs text-ink-500">{{ $stats['products']['active'] }} active</p>
            <div class="absolute -right-4 -top-4 grid h-20 w-20 place-items-center rounded-2xl bg-violet-100 text-violet-600">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.7l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.7l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/></svg>
            </div>
        </a>

        <a href="{{ route('admin.customers.index') }}" class="card relative block overflow-hidden p-5 transition-transform hover:-translate-y-0.5">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-500">Customers</p>
            <p class="mt-2 text-3xl font-bold text-ink-900">{{ $stats['customers'] }}</p>
            <p class="mt-1 text-xs text-ink-500">registered users</p>
            <div class="absolute -right-4 -top-4 grid h-20 w-20 place-items-center rounded-2xl bg-sky-100 text-sky-600">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0Zm-8 8h8a4 4 0 0 1 4 4v2H4v-2a4 4 0 0 1 4-4Z"/></svg>
            </div>
        </a>

        <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" class="card relative block overflow-hidden p-5 transition-transform hover:-translate-y-0.5">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-500">Pending reviews</p>
            <p class="mt-2 text-3xl font-bold text-{{ $stats['pending_reviews'] > 0 ? 'amber' : 'ink' }}-{{ $stats['pending_reviews'] > 0 ? '600' : '900' }}">{{ $stats['pending_reviews'] }}</p>
            <p class="mt-1 text-xs text-ink-500">awaiting moderation</p>
            <div class="absolute -right-4 -top-4 grid h-20 w-20 place-items-center rounded-2xl bg-emerald-100 text-emerald-600">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m12 2 3 7h7l-5.5 4.5L18 21l-6-4-6 4 1.5-7.5L2 9h7z"/></svg>
            </div>
        </a>
    </div>

    {{-- Action items --}}
    <div class="mt-6 grid gap-4 lg:grid-cols-3">
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="card flex items-center gap-3 bg-amber-50 p-5 ring-1 ring-amber-200 transition-colors hover:bg-amber-100">
            <svg class="h-8 w-8 shrink-0 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
            <div class="flex-1">
                <p class="font-semibold text-amber-900">{{ $stats['orders']['pending'] }} pending order(s)</p>
                <p class="text-xs text-amber-700">Confirm or cancel →</p>
            </div>
        </a>
        <a href="{{ route('admin.returns.index', ['status' => 'requested']) }}" class="card flex items-center gap-3 bg-blue-50 p-5 ring-1 ring-blue-200 transition-colors hover:bg-blue-100">
            <svg class="h-8 w-8 shrink-0 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 7h13a4 4 0 0 1 0 8H10 M7 11l-4 4 4 4"/></svg>
            <div class="flex-1">
                <p class="font-semibold text-blue-900">{{ $stats['pending_returns'] }} return request(s)</p>
                <p class="text-xs text-blue-700">Review →</p>
            </div>
        </a>
        <a href="{{ route('admin.products.index') }}" class="card flex items-center gap-3 bg-red-50 p-5 ring-1 ring-red-200 transition-colors hover:bg-red-100">
            <svg class="h-8 w-8 shrink-0 text-red-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01M5 4l-3 6 10 12L22 10l-3-6Z"/></svg>
            <div class="flex-1">
                <p class="font-semibold text-red-900">{{ $stats['low_stock'] + $stats['out_of_stock'] }} stock alert(s)</p>
                <p class="text-xs text-red-700">{{ $stats['low_stock'] }} low · {{ $stats['out_of_stock'] }} out →</p>
            </div>
        </a>
    </div>

    {{-- Recent orders --}}
    <div class="mt-6 grid gap-4 lg:grid-cols-3">
        <div class="card overflow-hidden lg:col-span-2">
            <div class="flex items-center justify-between border-b border-ink-200/60 p-5">
                <h2 class="text-base font-semibold text-ink-900">Recent orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">View all →</a>
            </div>
            @if($recentOrders->isEmpty())
                <div class="p-12 text-center text-sm text-ink-500">No orders yet.</div>
            @else
                <div class="divide-y divide-ink-200/60">
                    @foreach($recentOrders as $order)
                        <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between p-4 transition-colors hover:bg-ink-50">
                            <div>
                                <p class="font-mono text-xs font-semibold text-ink-900">{{ $order->order_number }}</p>
                                <p class="text-xs text-ink-500">{{ $order->billing_name }} · {{ $order->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="badge {{ match($order->status) {
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    'delivered', 'completed' => 'bg-green-100 text-green-700',
                                    default => 'bg-ink-100 text-ink-700',
                                } }}">{{ ucfirst($order->status) }}</span>
                                <p class="text-sm font-semibold text-ink-900">₹{{ number_format((float) $order->total, 0) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="card p-6">
            <h2 class="text-base font-semibold text-ink-900">Quick actions</h2>
            <div class="mt-4 space-y-2">
                @foreach([
                    ['route' => 'admin.products.create', 'label' => 'Add a new product'],
                    ['route' => 'admin.coupons.create', 'label' => 'Create a coupon'],
                    ['route' => 'admin.banners.create', 'label' => 'Add a banner'],
                    ['route' => 'admin.pincodes.create', 'label' => 'Add a pincode'],
                ] as $action)
                    <a href="{{ route($action['route']) }}" class="flex items-center justify-between rounded-lg border border-ink-200 px-4 py-2.5 text-sm font-medium text-ink-700 transition-colors hover:border-brand-300 hover:bg-brand-50 hover:text-brand-700">
                        <span class="flex items-center gap-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                            {{ $action['label'] }}
                        </span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 6 6 6-6 6"/></svg>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.admin>
