<x-layouts.admin :title="'Categories'" :header="'Categories'" :subheader="$categories->count() . ' total'">
    <x-slot:actions>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ New Category</a>
    </x-slot:actions>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="datatable">
                <colgroup>
                    <col style="width: 70px">
                    <col>
                    <col style="width: 200px">
                    <col style="width: 80px">
                    <col style="width: 130px">
                    <col style="width: 100px">
                    <col style="width: 140px">
                </colgroup>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th class="text-center">Sort</th>
                        <th class="text-center">Featured</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $cat)
                        <tr>
                            <td>
                                @if($cat->image)
                                    <img src="{{ asset('storage/' . $cat->image) }}" alt="" class="h-10 w-10 rounded-lg object-cover">
                                @else
                                    <div class="grid h-10 w-10 place-items-center rounded-lg bg-ink-100 text-ink-400">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v16H4z"/></svg>
                                    </div>
                                @endif
                            </td>
                            <td class="font-medium text-ink-900">{{ $cat->name }}</td>
                            <td class="font-mono text-xs text-ink-500">{{ $cat->slug }}</td>
                            <td class="text-center">{{ $cat->sort_order }}</td>
                            <td class="text-center">
                                @if($cat->is_featured)
                                    <span class="badge bg-amber-100 text-amber-700">★ Featured</span>
                                @else
                                    <span class="text-ink-300">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($cat->is_active)
                                    <span class="badge bg-green-100 text-green-700">Active</span>
                                @else
                                    <span class="badge bg-ink-100 text-ink-700">Inactive</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="table-actions">
                                    <a href="{{ route('admin.categories.edit', $cat) }}" class="table-action-edit">Edit</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" class="js-delete-form"
                                          data-confirm-title="Delete this category?">
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
