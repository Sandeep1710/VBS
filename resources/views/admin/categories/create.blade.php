<x-layouts.admin :title="'New Category'" :header="'New Category'" :subheader="'Add a product category'">
    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @include('admin.categories._form')
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Category</button>
        </div>
    </form>
</x-layouts.admin>
