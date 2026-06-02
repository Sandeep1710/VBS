<x-layouts.admin :title="'Edit Coupon'" :header="'Edit Coupon'" :subheader="$coupon->code">
    <form method="POST" action="{{ route('admin.coupons.update', $coupon) }}" class="space-y-5">
        @csrf @method('PUT')
        @include('admin.coupons._form')
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</x-layouts.admin>
