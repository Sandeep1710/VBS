<x-layouts.admin :title="'New Testimonial'" :header="'New Testimonial'">
    <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @include('admin.testimonials._form')
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Testimonial</button>
        </div>
    </form>
</x-layouts.admin>
