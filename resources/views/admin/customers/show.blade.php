<x-layouts.admin :title="$customer->name" :header="$customer->name" :subheader="$customer->email">
    <x-slot:actions>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline">← Back</a>
    </x-slot:actions>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
        <div class="space-y-6">
            <x-card title="Recent orders">
                @if($customer->orders->isEmpty())
                    <p class="text-sm text-ink-500">No orders placed yet.</p>
                @else
                    <div class="-m-6">
                        <table class="w-full text-sm">
                            <thead class="bg-ink-50 text-left text-xs uppercase text-ink-500">
                                <tr>
                                    <th class="px-6 py-3">Order #</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-right">Total</th>
                                    <th class="px-6 py-3">Date</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-ink-200/60">
                                @foreach($customer->orders as $order)
                                    <tr>
                                        <td class="px-6 py-3 font-mono text-xs">{{ $order->order_number }}</td>
                                        <td class="px-6 py-3"><span class="badge bg-ink-100 text-ink-700">{{ ucfirst($order->status) }}</span></td>
                                        <td class="px-6 py-3 text-right font-semibold">₹{{ number_format((float) $order->total, 0) }}</td>
                                        <td class="px-6 py-3 text-xs text-ink-500">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-3 text-right"><a href="{{ route('admin.orders.show', $order) }}" class="text-sm text-brand-600 hover:underline">View →</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </x-card>

            <x-card title="Addresses">
                @if($customer->addresses->isEmpty())
                    <p class="text-sm text-ink-500">No saved addresses.</p>
                @else
                    <div class="grid gap-3 sm:grid-cols-2">
                        @foreach($customer->addresses as $addr)
                            <div class="rounded-lg border border-ink-200 p-3 text-sm">
                                <p class="font-medium text-ink-900">{{ $addr->label ?? '—' }}@if($addr->is_default)<span class="badge ml-2 bg-brand-100 text-brand-700">Default</span>@endif</p>
                                <p class="text-xs text-ink-600">{{ $addr->name }} · {{ $addr->phone }}</p>
                                <p class="mt-1 text-xs text-ink-600">
                                    {{ $addr->line1 }}@if($addr->line2), {{ $addr->line2 }}@endif<br>
                                    {{ $addr->city }}, {{ $addr->state }} {{ $addr->pincode }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-card>
        </div>

        <div class="space-y-4">
            <x-card title="Profile">
                <dl class="space-y-2 text-sm">
                    <div><dt class="text-xs text-ink-500">Name</dt><dd class="font-medium text-ink-900">{{ $customer->name }}</dd></div>
                    <div><dt class="text-xs text-ink-500">Email</dt><dd>{{ $customer->email }}</dd></div>
                    <div><dt class="text-xs text-ink-500">Phone</dt><dd>{{ $customer->phone ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-ink-500">Status</dt><dd><span class="badge {{ $customer->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ ucfirst($customer->status) }}</span></dd></div>
                    <div><dt class="text-xs text-ink-500">Email verified</dt><dd>{{ $customer->email_verified_at?->format('d M Y') ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-ink-500">Joined</dt><dd>{{ $customer->created_at->format('d M Y') }}</dd></div>
                    <div><dt class="text-xs text-ink-500">Last login</dt><dd>{{ optional($customer->last_login_at)->diffForHumans() ?? 'Never' }}</dd></div>
                </dl>
            </x-card>

            <x-card title="Spending">
                <p class="text-xs text-ink-500">Lifetime spend</p>
                <p class="mt-1 text-2xl font-bold text-ink-900">₹{{ number_format((float) $totalSpent, 0) }}</p>
                <p class="mt-1 text-xs text-ink-500">across {{ $customer->orders->count() }} order(s)</p>
            </x-card>
        </div>
    </div>
</x-layouts.admin>
