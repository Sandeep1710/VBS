<x-layouts.admin :title="'Edit ' . $category->name" :header="'Edit Category'" :subheader="$category->name">
    <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')
        @include('admin.categories._form')
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</x-layouts.admin>
