<x-layouts.admin :title="'Edit FAQ'" :header="'Edit FAQ'" :subheader="\Illuminate\Support\Str::limit($faq->question, 60)">
    <form method="POST" action="{{ route('admin.faqs.update', $faq) }}" class="space-y-5">
        @csrf @method('PUT')
        @include('admin.faqs._form')
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</x-layouts.admin>
