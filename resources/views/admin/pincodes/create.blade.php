<x-layouts.admin :title="'New Pincode'" :header="'New Pincode'">
    <form method="POST" action="{{ route('admin.pincodes.store') }}" class="space-y-5">
        @csrf
        @include('admin.pincodes._form')
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.pincodes.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</x-layouts.admin>
