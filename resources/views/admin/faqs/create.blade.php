<x-layouts.admin :title="'New FAQ'" :header="'New FAQ'">
    <form method="POST" action="{{ route('admin.faqs.store') }}" class="space-y-5">
        @csrf
        @include('admin.faqs._form')
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save FAQ</button>
        </div>
    </form>
</x-layouts.admin>
