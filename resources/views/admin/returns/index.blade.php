<x-layouts.admin :title="'Returns'" :header="'Order Returns'" :subheader="$returns->total() . ' total'">
    <form method="GET" class="card mb-4 p-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.returns.index') }}" class="btn {{ request('status') ? 'btn-outline' : 'btn-primary' }}">All</a>
            @foreach($statuses as $s)
                <a href="{{ route('admin.returns.index', ['status' => $s]) }}" class="btn {{ request('status') === $s ? 'btn-primary' : 'btn-outline' }}">{{ ucfirst(str_replace('_', ' ', $s)) }}</a>
            @endforeach
        </div>
    </form>

    <div class="space-y-3">
        @forelse($returns as $return)
            <x-card>
                <div class="grid gap-4 md:grid-cols-[1fr_300px]">
                    <div>
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs text-ink-500">Order <a href="{{ route('admin.orders.show', $return->order) }}" class="font-mono font-semibold text-brand-600 hover:underline">{{ $return->order?->order_number }}</a></p>
                                <p class="mt-1 text-base font-semibold text-ink-900">{{ $return->orderItem?->product_name ?? '—' }}</p>
                                <p class="text-xs text-ink-500">Qty: {{ $return->quantity }} · Reason: {{ \App\Models\OrderReturn::REASONS[$return->reason] ?? $return->reason }}</p>
                            </div>
                            <span class="badge {{ match($return->status) {
                                'requested' => 'bg-amber-100 text-amber-700',
                                'approved' => 'bg-blue-100 text-blue-700',
                                'rejected' => 'bg-red-100 text-red-700',
                                'picked_up' => 'bg-indigo-100 text-indigo-700',
                                'refunded' => 'bg-green-100 text-green-700',
                                default => 'bg-ink-100',
                            } }}">{{ ucfirst(str_replace('_', ' ', $return->status)) }}</span>
                        </div>
                        @if($return->details)
                            <p class="mt-3 rounded-lg bg-ink-50 p-3 text-sm text-ink-700">{{ $return->details }}</p>
                        @endif
                        <p class="mt-3 text-xs text-ink-500">
                            By <span class="font-medium">{{ $return->user?->name ?? '—' }}</span> · {{ $return->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('admin.returns.update', $return) }}" class="space-y-2 border-l border-ink-200 pl-4">
                        @csrf @method('PATCH')
                        <x-label value="Update status" />
                        <select name="status" class="input">
                            @foreach($statuses as $s)
                                <option value="{{ $s }}" @selected($return->status === $s)>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                            @endforeach
                        </select>
                        <textarea name="admin_notes" rows="2" placeholder="Admin notes" class="input">{{ $return->admin_notes }}</textarea>
                        <x-input name="refund_amount" type="number" step="0.01" min="0" :value="$return->refund_amount" placeholder="Refund amount (if refunding)" />
                        <button type="submit" class="btn btn-primary w-full">Save</button>
                    </form>
                </div>
            </x-card>
        @empty
            <x-card><p class="text-center text-sm text-ink-500">No return requests.</p></x-card>
        @endforelse
    </div>

    <div class="mt-4">{{ $returns->links() }}</div>
</x-layouts.admin>
