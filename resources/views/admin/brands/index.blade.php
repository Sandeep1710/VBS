<x-layouts.admin :title="'Battery Brands'" :header="'Battery Brands'" :subheader="$brands->count() . ' total'">
    <x-slot:actions>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">+ New Brand</a>
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
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th class="text-center">Sort</th>
                        <th class="text-center">Featured</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($brands as $brand)
                        <tr>
                            <td>
                                @if($brand->logo)
                                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="" class="h-10 w-10 rounded-lg object-contain bg-ink-50 p-1">
                                @else
                                    <div class="grid h-10 w-10 place-items-center rounded-lg bg-ink-100 text-xs font-bold text-ink-500">
                                        {{ strtoupper(substr($brand->name, 0, 2)) }}
                                    </div>
                                @endif
                            </td>
                            <td class="font-medium text-ink-900">{{ $brand->name }}</td>
                            <td class="font-mono text-xs text-ink-500">{{ $brand->slug }}</td>
                            <td class="text-center">{{ $brand->sort_order }}</td>
                            <td class="text-center">
                                @if($brand->is_featured)
                                    <span class="badge bg-amber-100 text-amber-700">★ Featured</span>
                                @else
                                    <span class="text-ink-300">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($brand->is_active)
                                    <span class="badge bg-green-100 text-green-700">Active</span>
                                @else
                                    <span class="badge bg-ink-100 text-ink-700">Inactive</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="table-actions">
                                    <a href="{{ route('admin.brands.edit', $brand) }}" class="table-action-edit">Edit</a>
                                    <form method="POST" action="{{ route('admin.brands.destroy', $brand) }}" class="js-delete-form"
                                          data-confirm-title="Delete this brand?">
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
