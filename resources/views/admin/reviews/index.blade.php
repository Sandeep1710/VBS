<x-layouts.admin :title="'Reviews'" :header="'Product Reviews'" :subheader="$reviews->total() . ' total'">
    <form method="GET" class="card mb-4 p-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.reviews.index') }}" class="btn {{ request('status') ? 'btn-outline' : 'btn-primary' }}">All</a>
            <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" class="btn {{ request('status') === 'pending' ? 'btn-primary' : 'btn-outline' }}">Pending</a>
            <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" class="btn {{ request('status') === 'approved' ? 'btn-primary' : 'btn-outline' }}">Approved</a>
        </div>
    </form>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="datatable" data-no-init>
                <colgroup>
                    <col style="width: 200px">
                    <col style="width: 200px">
                    <col style="width: 110px">
                    <col>
                    <col style="width: 110px">
                    <col style="width: 200px">
                </colgroup>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Customer</th>
                        <th class="text-center">Rating</th>
                        <th>Comment</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td>
                                <p class="line-clamp-2 font-medium text-ink-900">{{ $review->product?->name ?? '—' }}</p>
                                <a href="{{ route('products.show', $review->product) }}" target="_blank" class="text-xs text-brand-600 hover:underline">View PDP →</a>
                            </td>
                            <td>
                                <p class="font-medium text-ink-900">{{ $review->user?->name ?? 'Anonymous' }}</p>
                                @if($review->is_verified_buyer)<span class="badge bg-green-100 text-green-700">Verified buyer</span>@endif
                            </td>
                            <td class="text-center whitespace-nowrap">
                                <span class="text-amber-500">{{ str_repeat('★', $review->rating) }}</span><span class="text-ink-200">{{ str_repeat('★', 5 - $review->rating) }}</span>
                            </td>
                            <td>
                                @if($review->title)<p class="text-sm font-medium text-ink-900">{{ $review->title }}</p>@endif
                                <p class="line-clamp-2 text-sm text-ink-700">{{ $review->comment }}</p>
                                @if($review->images->isNotEmpty())<p class="mt-1 text-xs text-ink-500">{{ $review->images->count() }} photo(s)</p>@endif
                                <p class="mt-1 text-xs text-ink-400">{{ $review->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="text-center">
                                @if($review->is_approved)
                                    <span class="badge bg-green-100 text-green-700">Approved</span>
                                @else
                                    <span class="badge bg-amber-100 text-amber-700">Pending</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="table-actions">
                                    @if($review->is_approved)
                                        <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="table-action-delete">Unapprove</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="table-action-edit">Approve</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" class="js-delete-form" data-confirm-title="Delete this review?">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="table-action-delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-12 text-center text-ink-500">No reviews yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">{{ $reviews->links() }}</div>
    </div>
</x-layouts.admin>
