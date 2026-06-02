<x-layouts.admin :title="'New Banner'" :header="'New Banner'">
    <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @include('admin.banners._form')
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.banners.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Banner</button>
        </div>
    </form>
</x-layouts.admin>
