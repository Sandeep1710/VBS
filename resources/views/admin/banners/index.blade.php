<x-layouts.admin :title="'Banners'" :header="'Banners'" :subheader="$banners->count() . ' total'">
    <x-slot:actions>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">+ New Banner</a>
    </x-slot:actions>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="datatable">
                <colgroup>
                    <col style="width: 110px">
                    <col>
                    <col style="width: 140px">
                    <col style="width: 80px">
                    <col style="width: 200px">
                    <col style="width: 100px">
                    <col style="width: 140px">
                </colgroup>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Position</th>
                        <th class="text-center">Sort</th>
                        <th>Active period</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners as $banner)
                        <tr>
                            <td>
                                @if($banner->image)
                                    <img src="{{ asset('storage/' . $banner->image) }}" alt="" class="h-12 w-20 rounded object-cover">
                                @else
                                    <div class="grid h-12 w-20 place-items-center rounded bg-ink-100 text-ink-400">—</div>
                                @endif
                            </td>
                            <td>
                                <p class="font-medium text-ink-900">{{ $banner->title }}</p>
                                @if($banner->subtitle)<p class="line-clamp-1 text-xs text-ink-500">{{ $banner->subtitle }}</p>@endif
                            </td>
                            <td><span class="badge bg-ink-100 text-ink-700">{{ $banner->position }}</span></td>
                            <td class="text-center">{{ $banner->sort_order }}</td>
                            <td class="whitespace-nowrap text-xs text-ink-500">
                                {{ optional($banner->starts_at)->format('d M Y') ?: 'Always' }}
                                <span class="mx-1 text-ink-300">→</span>
                                {{ optional($banner->ends_at)->format('d M Y') ?: 'Always' }}
                            </td>
                            <td class="text-center">
                                @if($banner->is_active)
                                    <span class="badge bg-green-100 text-green-700">Active</span>
                                @else
                                    <span class="badge bg-ink-100 text-ink-700">Inactive</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="table-actions">
                                    <a href="{{ route('admin.banners.edit', $banner) }}" class="table-action-edit">Edit</a>
                                    <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" class="js-delete-form"
                                          data-confirm-title="Delete this banner?">
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
