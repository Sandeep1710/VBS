<x-layouts.admin :title="'Customers'" :header="'Customers'" :subheader="$customers->total() . ' total'">
    <form method="GET" class="card mb-4 p-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name / email / phone" class="input">
    </form>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="datatable" data-no-init>
                <colgroup>
                    <col style="width: 60px">
                    <col>
                    <col style="width: 200px">
                    <col style="width: 140px">
                    <col style="width: 80px">
                    <col style="width: 150px">
                    <col style="width: 100px">
                </colgroup>
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th class="text-center">Orders</th>
                        <th>Joined</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td>
                                <div class="grid h-10 w-10 place-items-center rounded-full bg-brand-100 text-sm font-bold text-brand-700">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                            </td>
                            <td>
                                <p class="font-medium text-ink-900">{{ $customer->name }}</p>
                                @if($customer->email_verified_at)
                                    <span class="badge bg-green-100 text-green-700">Verified</span>
                                @else
                                    <span class="badge bg-amber-100 text-amber-700">Unverified</span>
                                @endif
                            </td>
                            <td class="text-ink-700">{{ $customer->email }}</td>
                            <td class="text-ink-700">{{ $customer->phone ?? '—' }}</td>
                            <td class="text-center font-semibold">{{ $customer->orders_count }}</td>
                            <td class="whitespace-nowrap text-xs text-ink-500">{{ $customer->created_at->format('d M Y') }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.customers.show', $customer) }}" class="table-action-edit">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-12 text-center text-ink-500">No customers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">{{ $customers->links() }}</div>
    </div>
</x-layouts.admin>
