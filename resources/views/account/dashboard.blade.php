<x-layouts.account :title="'My Account'">
    <x-slot:header>Welcome back, {{ Str::before(auth()->user()->name, ' ') }}</x-slot:header>
    <x-slot:subheader>Here's a quick look at your account activity.</x-slot:subheader>

    @if(! auth()->user()->hasVerifiedEmail())
        <div class="mb-5 flex flex-col gap-3 rounded-lg bg-amber-50 p-4 ring-1 ring-amber-200 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-3">
                <svg class="h-5 w-5 shrink-0 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                <div>
                    <p class="text-sm font-semibold text-amber-900">Please verify your email to place orders</p>
                    <p class="text-xs text-amber-700">We sent a link to {{ auth()->user()->email }}. Check your inbox.</p>
                </div>
            </div>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button class="btn bg-amber-600 text-white hover:bg-amber-700 focus:ring-amber-500 text-xs">Resend email</button>
            </form>
        </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="card p-5">
            <p class="text-sm font-medium text-ink-500">Total orders</p>
            <p class="mt-2 text-3xl font-bold text-ink-900">{{ $stats['orders_total'] }}</p>
        </div>
        <div class="card p-5">
            <p class="text-sm font-medium text-ink-500">In progress</p>
            <p class="mt-2 text-3xl font-bold text-amber-600">{{ $stats['orders_pending'] }}</p>
        </div>
        <div class="card p-5">
            <p class="text-sm font-medium text-ink-500">Completed</p>
            <p class="mt-2 text-3xl font-bold text-green-600">{{ $stats['orders_completed'] }}</p>
        </div>
        <div class="card p-5">
            <p class="text-sm font-medium text-ink-500">Saved addresses</p>
            <p class="mt-2 text-3xl font-bold text-ink-900">{{ $stats['addresses'] }}</p>
        </div>
    </div>

    <div class="mt-8">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-ink-900">Recent orders</h2>
            <a href="{{ route('account.orders.index') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">View all →</a>
        </div>

        <div class="mt-4 card overflow-hidden">
            @if($recentOrders->isEmpty())
                <div class="p-12 text-center">
                    <p class="text-sm text-ink-600">You haven't placed any orders yet.</p>
                    <a href="{{ url('/products') }}" class="mt-3 inline-flex btn btn-primary">Shop batteries</a>
                </div>
            @else
                <div class="divide-y divide-ink-200/60">
                    @foreach($recentOrders as $order)
                        <div class="flex flex-col gap-3 p-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-semibold text-ink-900">{{ $order->order_number }}</p>
                                <p class="text-xs text-ink-500">{{ $order->created_at->format('d M Y, h:i A') }} · {{ $order->items->sum('quantity') }} item(s)</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="badge bg-ink-100 text-ink-800">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                                <p class="text-sm font-semibold text-ink-900">₹{{ number_format((float) $order->total, 2) }}</p>
                                <a href="{{ route('account.orders.show', $order) }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">View →</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts.account>
