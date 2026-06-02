<x-layouts.admin :title="'New Brand'" :header="'New Battery Brand'">
    <form method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @include('admin.brands._form')
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.brands.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Brand</button>
        </div>
    </form>
</x-layouts.admin>
