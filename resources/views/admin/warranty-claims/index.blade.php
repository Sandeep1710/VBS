<x-layouts.admin :title="'Warranty Claims'" :header="'Warranty Claims'" :subheader="$claims->total() . ' total'">
    <form method="GET" class="card mb-4 p-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.warranty-claims.index') }}" class="btn {{ request('status') ? 'btn-outline' : 'btn-primary' }}">All</a>
            @foreach($statuses as $s)
                <a href="{{ route('admin.warranty-claims.index', ['status' => $s]) }}" class="btn {{ request('status') === $s ? 'btn-primary' : 'btn-outline' }}">{{ ucfirst(str_replace('_', ' ', $s)) }}</a>
            @endforeach
        </div>
    </form>

    <div class="space-y-3">
        @forelse($claims as $claim)
            <x-card>
                <div class="grid gap-4 md:grid-cols-[1fr_300px]">
                    <div>
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs text-ink-500">Order <a href="{{ route('admin.orders.show', $claim->order) }}" class="font-mono font-semibold text-brand-600 hover:underline">{{ $claim->order?->order_number }}</a></p>
                                <p class="mt-1 text-base font-semibold text-ink-900">{{ $claim->orderItem?->product_name ?? '—' }}</p>
                                <p class="text-xs text-ink-500">Issue: {{ \App\Models\WarrantyClaim::ISSUE_TYPES[$claim->issue_type] ?? $claim->issue_type }}</p>
                            </div>
                            <span class="badge {{ match($claim->status) {
                                'submitted' => 'bg-amber-100 text-amber-700',
                                'under_review' => 'bg-blue-100 text-blue-700',
                                'approved' => 'bg-indigo-100 text-indigo-700',
                                'rejected' => 'bg-red-100 text-red-700',
                                'resolved' => 'bg-green-100 text-green-700',
                                default => 'bg-ink-100',
                            } }}">{{ ucfirst(str_replace('_', ' ', $claim->status)) }}</span>
                        </div>
                        <p class="mt-3 rounded-lg bg-ink-50 p-3 text-sm text-ink-700">{{ $claim->description }}</p>
                        <p class="mt-3 text-xs text-ink-500">
                            By <span class="font-medium">{{ $claim->user?->name ?? '—' }}</span> · {{ $claim->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('admin.warranty-claims.update', $claim) }}" class="space-y-2 border-l border-ink-200 pl-4">
                        @csrf @method('PATCH')
                        <x-label value="Update status" />
                        <select name="status" class="input">
                            @foreach($statuses as $s)
                                <option value="{{ $s }}" @selected($claim->status === $s)>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                            @endforeach
                        </select>
                        <select name="resolution" class="input">
                            <option value="">— Resolution (if resolved) —</option>
                            @foreach($resolutions as $key => $label)
                                <option value="{{ $key }}" @selected($claim->resolution === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <textarea name="admin_notes" rows="2" placeholder="Admin notes" class="input">{{ $claim->admin_notes }}</textarea>
                        <button type="submit" class="btn btn-primary w-full">Save</button>
                    </form>
                </div>
            </x-card>
        @empty
            <x-card><p class="text-center text-sm text-ink-500">No warranty claims.</p></x-card>
        @endforelse
    </div>

    <div class="mt-4">{{ $claims->links() }}</div>
</x-layouts.admin>
