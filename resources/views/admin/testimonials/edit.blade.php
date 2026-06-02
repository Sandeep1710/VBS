<x-layouts.admin :title="'Edit Testimonial'" :header="'Edit Testimonial'" :subheader="$testimonial->name">
    <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')
        @include('admin.testimonials._form')
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</x-layouts.admin>
