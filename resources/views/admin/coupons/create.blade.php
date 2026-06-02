<x-layouts.admin :title="'New Coupon'" :header="'New Coupon'">
    <form method="POST" action="{{ route('admin.coupons.store') }}" class="space-y-5">
        @csrf
        @include('admin.coupons._form')
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Coupon</button>
        </div>
    </form>
</x-layouts.admin>
