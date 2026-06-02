<x-layouts.admin :title="'New Product'" :header="'New Product'">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @include('admin.products._form')
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Product</button>
        </div>
    </form>
</x-layouts.admin>
