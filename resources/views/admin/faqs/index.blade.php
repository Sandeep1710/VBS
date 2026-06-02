<x-layouts.admin :title="'FAQs'" :header="'FAQs'" :subheader="$faqs->count() . ' total'">
    <x-slot:actions>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">+ New FAQ</a>
    </x-slot:actions>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="datatable">
                <colgroup>
                    <col style="width: 130px">
                    <col style="width: 320px">
                    <col>
                    <col style="width: 70px">
                    <col style="width: 100px">
                    <col style="width: 140px">
                </colgroup>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th class="text-center">Sort</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faqs as $faq)
                        <tr>
                            <td>
                                @if($faq->category)
                                    <span class="badge bg-ink-100 text-ink-700">{{ $faq->category }}</span>
                                @else
                                    <span class="text-ink-300">—</span>
                                @endif
                            </td>
                            <td class="font-medium text-ink-900">
                                <p class="line-clamp-2">{{ $faq->question }}</p>
                            </td>
                            <td>
                                <p class="line-clamp-2 text-ink-600">{{ $faq->answer }}</p>
                            </td>
                            <td class="text-center">{{ $faq->sort_order }}</td>
                            <td class="text-center">
                                @if($faq->is_active)
                                    <span class="badge bg-green-100 text-green-700">Active</span>
                                @else
                                    <span class="badge bg-ink-100 text-ink-700">Inactive</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="table-actions">
                                    <a href="{{ route('admin.faqs.edit', $faq) }}" class="table-action-edit">Edit</a>
                                    <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" class="js-delete-form"
                                          data-confirm-title="Delete this FAQ?">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="table-action-delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
