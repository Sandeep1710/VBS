<x-layouts.admin :title="'Edit ' . $product->name" :header="'Edit Product'" :subheader="$product->name">
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')
        @include('admin.products._form')
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</x-layouts.admin>
