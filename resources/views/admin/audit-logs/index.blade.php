<x-layouts.admin :title="'Audit Log'" :header="'Audit Log'" :subheader="$logs->total() . ' events'">
    {{-- Filters --}}
    <form method="GET" class="card mb-4 p-4">
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-5">
            <div>
                <label class="text-xs font-semibold text-ink-600">Event contains</label>
                <input type="text" name="event" value="{{ request('event') }}" class="input mt-1" placeholder="e.g. login, lead">
            </div>
            <div>
                <label class="text-xs font-semibold text-ink-600">IP address</label>
                <input type="text" name="ip" value="{{ request('ip') }}" class="input mt-1" placeholder="e.g. 127.0.0.1">
            </div>
            <div>
                <label class="text-xs font-semibold text-ink-600">User ID</label>
                <input type="number" name="user_id" value="{{ request('user_id') }}" class="input mt-1" placeholder="42">
            </div>
            <div>
                <label class="text-xs font-semibold text-ink-600">From</label>
                <input type="date" name="from" value="{{ request('from') }}" class="input mt-1">
            </div>
            <div>
                <label class="text-xs font-semibold text-ink-600">To</label>
                <input type="date" name="to" value="{{ request('to') }}" class="input mt-1">
            </div>
        </div>
        <div class="mt-3 flex gap-2">
            <button type="submit" class="btn btn-primary text-xs">Filter</button>
            <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-outline text-xs">Reset</a>
        </div>
    </form>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <colgroup>
                    <col style="width: 160px">
                    <col style="width: 220px">
                    <col style="width: 200px">
                    <col style="width: 130px">
                    <col>
                </colgroup>
                <thead>
                    <tr class="border-b border-ink-200 bg-ink-50 text-xs uppercase tracking-wide text-ink-500">
                        <th class="px-4 py-3 text-left">When</th>
                        <th class="px-4 py-3 text-left">Event</th>
                        <th class="px-4 py-3 text-left">Who</th>
                        <th class="px-4 py-3 text-left">IP</th>
                        <th class="px-4 py-3 text-left">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr class="border-b border-ink-100 last:border-b-0 hover:bg-ink-50/50">
                            <td class="whitespace-nowrap px-4 py-3 text-xs text-ink-600">
                                {{ $log->created_at?->format('Y-m-d H:i:s') }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge {{ str_contains($log->event, 'failed') || str_contains($log->event, 'denied') ? 'bg-red-100 text-red-700' : (str_contains($log->event, 'login') ? 'bg-amber-100 text-amber-700' : (str_contains($log->event, 'lead') ? 'bg-green-100 text-green-700' : 'bg-ink-100 text-ink-700')) }}">
                                    {{ $log->event }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-xs">
                                @if($log->user)
                                    <div class="font-semibold text-ink-900">{{ $log->user->name }}</div>
                                    <div class="text-ink-500">{{ $log->user->email }}</div>
                                    <span class="badge {{ $log->user->is_admin ? 'bg-brand-100 text-brand-700' : 'bg-ink-100 text-ink-700' }}">{{ $log->user->is_admin ? 'admin' : 'customer' }}</span>
                                @else
                                    <span class="text-ink-400">guest</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 font-mono text-xs text-ink-700">{{ $log->ip_address ?? '—' }}</td>
                            <td class="px-4 py-3 text-xs text-ink-700">
                                @if($log->url)
                                    <a href="{{ $log->url }}" target="_blank" rel="noopener" class="truncate text-brand-600 hover:underline">{{ \Illuminate\Support\Str::limit($log->url, 60) }}</a>
                                @endif
                                @if($log->auditable_type)
                                    <div class="text-ink-500">→ {{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}</div>
                                @endif
                                @if($log->new_values)
                                    <details class="mt-1">
                                        <summary class="cursor-pointer text-brand-600 hover:underline">meta</summary>
                                        <pre class="mt-1 max-w-md overflow-x-auto rounded bg-ink-50 p-2 text-[10px] leading-tight text-ink-700">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                    </details>
                                @endif
                                @if($log->user_agent)
                                    <div class="mt-1 truncate text-[10px] text-ink-400">{{ \Illuminate\Support\Str::limit($log->user_agent, 90) }}</div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-ink-500">No audit events yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="border-t border-ink-100 px-4 py-3">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
