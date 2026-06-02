<x-layouts.admin :title="'Testimonials'" :header="'Testimonials'" :subheader="$testimonials->count() . ' total'">
    <x-slot:actions>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">+ New Testimonial</a>
    </x-slot:actions>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="datatable">
                <colgroup>
                    <col style="width: 64px">
                    <col style="width: 200px">
                    <col style="width: 120px">
                    <col style="width: 130px">
                    <col>
                    <col style="width: 70px">
                    <col style="width: 100px">
                    <col style="width: 140px">
                </colgroup>
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>City</th>
                        <th class="text-center">Rating</th>
                        <th>Comment</th>
                        <th class="text-center">Sort</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($testimonials as $t)
                        <tr>
                            <td>
                                @if($t->avatar)
                                    <img src="{{ asset('storage/' . $t->avatar) }}" alt="" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <div class="grid h-10 w-10 place-items-center rounded-full bg-brand-100 text-sm font-bold text-brand-700">
                                        {{ strtoupper(substr($t->name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <p class="font-medium text-ink-900">{{ $t->name }}</p>
                                @if($t->designation)<p class="text-xs text-ink-500">{{ $t->designation }}</p>@endif
                            </td>
                            <td class="text-ink-700">{{ $t->city ?? '—' }}</td>
                            <td class="text-center whitespace-nowrap">
                                <span class="text-amber-500">{{ str_repeat('★', $t->rating) }}</span><span class="text-ink-200">{{ str_repeat('★', 5 - $t->rating) }}</span>
                            </td>
                            <td>
                                <p class="line-clamp-2 max-w-md text-ink-700">{{ $t->comment }}</p>
                            </td>
                            <td class="text-center">{{ $t->sort_order }}</td>
                            <td class="text-center">
                                @if($t->is_active)
                                    <span class="badge bg-green-100 text-green-700">Active</span>
                                @else
                                    <span class="badge bg-ink-100 text-ink-700">Inactive</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="table-actions">
                                    <a href="{{ route('admin.testimonials.edit', $t) }}" class="table-action-edit">Edit</a>
                                    <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" class="js-delete-form"
                                          data-confirm-title="Delete this testimonial?">
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
