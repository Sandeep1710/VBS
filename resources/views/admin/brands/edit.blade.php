<x-layouts.admin :title="'Edit ' . $brand->name" :header="'Edit Brand'" :subheader="$brand->name">
    <form method="POST" action="{{ route('admin.brands.update', $brand) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')
        @include('admin.brands._form')
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.brands.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</x-layouts.admin>
