<x-layouts.admin :title="'Pincodes'" :header="'Serviceable Pincodes'" :subheader="$pincodes->total() . ' total'">
    <x-slot:actions>
        <a href="{{ route('admin.pincodes.create') }}" class="btn btn-primary">+ New Pincode</a>
    </x-slot:actions>

    <form method="GET" class="card mb-4 p-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search pincode / city" class="input">
    </form>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="datatable" data-no-init>
                <colgroup>
                    <col style="width: 120px">
                    <col>
                    <col style="width: 130px">
                    <col style="width: 110px">
                    <col style="width: 100px">
                    <col style="width: 100px">
                    <col style="width: 140px">
                </colgroup>
                <thead>
                    <tr>
                        <th>Pincode</th>
                        <th>City / State</th>
                        <th class="text-right">Delivery charge</th>
                        <th class="text-center">Days</th>
                        <th class="text-center">COD</th>
                        <th class="text-center">Active</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pincodes as $p)
                        <tr>
                            <td class="font-mono text-sm font-bold text-ink-900">{{ $p->pincode }}</td>
                            <td class="text-ink-700">{{ $p->city }}, {{ $p->state }}</td>
                            <td class="text-right">{{ (float) $p->delivery_charge > 0 ? '₹' . number_format((float) $p->delivery_charge, 0) : 'Free' }}</td>
                            <td class="text-center">{{ $p->expected_delivery_days }}</td>
                            <td class="text-center">@if($p->cod_available)<span class="text-green-600">✓</span>@else<span class="text-ink-300">—</span>@endif</td>
                            <td class="text-center">
                                @if($p->is_serviceable)
                                    <span class="badge bg-green-100 text-green-700">Yes</span>
                                @else
                                    <span class="badge bg-red-100 text-red-700">No</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="table-actions">
                                    <a href="{{ route('admin.pincodes.edit', $p) }}" class="table-action-edit">Edit</a>
                                    <form method="POST" action="{{ route('admin.pincodes.destroy', $p) }}" class="js-delete-form" data-confirm-title="Delete pincode?">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="table-action-delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">{{ $pincodes->links() }}</div>
    </div>
</x-layouts.admin>
