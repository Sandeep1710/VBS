<x-layouts.admin :title="'Coupons'" :header="'Coupons'" :subheader="$coupons->count() . ' total'">
    <x-slot:actions>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">+ New Coupon</a>
    </x-slot:actions>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="datatable">
                <colgroup>
                    <col style="width: 130px">
                    <col>
                    <col style="width: 110px">
                    <col style="width: 130px">
                    <col style="width: 110px">
                    <col style="width: 130px">
                    <col style="width: 100px">
                    <col style="width: 140px">
                </colgroup>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th class="text-center">Type</th>
                        <th class="text-right">Value</th>
                        <th class="text-center">Used</th>
                        <th>Validity</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $coupon)
                        <tr>
                            <td class="font-mono text-sm font-bold text-brand-700">{{ $coupon->code }}</td>
                            <td class="font-medium text-ink-900">{{ $coupon->name }}</td>
                            <td class="text-center"><span class="badge bg-ink-100 text-ink-700">{{ ucfirst($coupon->type) }}</span></td>
                            <td class="text-right font-semibold">
                                {{ $coupon->type === 'percentage' ? rtrim(rtrim($coupon->value, '0'), '.') . '%' : '₹' . number_format((float) $coupon->value, 0) }}
                            </td>
                            <td class="text-center">{{ $coupon->used_count }}{{ $coupon->usage_limit ? '/' . $coupon->usage_limit : '' }}</td>
                            <td class="whitespace-nowrap text-xs text-ink-500">
                                {{ optional($coupon->starts_at)->format('d M Y') ?: 'Always' }}<br>
                                {{ optional($coupon->expires_at)->format('d M Y') ?: 'No expiry' }}
                            </td>
                            <td class="text-center">
                                @if($coupon->is_active)
                                    <span class="badge bg-green-100 text-green-700">Active</span>
                                @else
                                    <span class="badge bg-ink-100 text-ink-700">Inactive</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="table-actions">
                                    <a href="{{ route('admin.coupons.edit', $coupon) }}" class="table-action-edit">Edit</a>
                                    <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}" class="js-delete-form" data-confirm-title="Delete this coupon?">
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
    </div>
</x-layouts.admin>
