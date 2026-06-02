<x-layouts.admin :title="'Edit Pincode'" :header="'Edit Pincode'" :subheader="$pincode->pincode">
    <form method="POST" action="{{ route('admin.pincodes.update', $pincode) }}" class="space-y-5">
        @csrf @method('PUT')
        @include('admin.pincodes._form')
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.pincodes.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</x-layouts.admin>
