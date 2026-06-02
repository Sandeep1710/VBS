<x-layouts.admin :title="'Edit Banner'" :header="'Edit Banner'" :subheader="$banner->title">
    <form method="POST" action="{{ route('admin.banners.update', $banner) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')
        @include('admin.banners._form')
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.banners.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</x-layouts.admin>
