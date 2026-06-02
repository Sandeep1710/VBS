<x-layouts.admin :title="'Products'" :header="'Products'" :subheader="$products->count() . ' total'">
    <x-slot:actions>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ New Product</a>
    </x-slot:actions>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="datatable">
                <colgroup>
                    <col>
                    <col style="width: 130px">
                    <col style="width: 130px">
                    <col style="width: 130px">
                    <col style="width: 110px">
                    <col style="width: 80px">
                    <col style="width: 100px">
                    <col style="width: 180px">
                </colgroup>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>SKU</th>
                        <th class="text-right">Price</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 shrink-0 rounded-lg bg-gradient-to-br from-slate-50 to-slate-100 overflow-hidden">
                                        <x-battery-image :product="$product" class="h-full w-full object-contain p-0.5" />
                                    </div>
                                    <div class="min-w-0">
                                        <p class="line-clamp-1 font-medium text-ink-900">{{ $product->name }}</p>
                                        @if($product->is_featured)<span class="badge mt-0.5 bg-amber-100 text-amber-700">★ Featured</span>@endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-ink-700">{{ $product->batteryBrand?->name ?? '—' }}</td>
                            <td class="text-ink-700">{{ $product->category?->name ?? '—' }}</td>
                            <td class="font-mono text-xs text-ink-500">{{ $product->sku }}</td>
                            <td class="text-right whitespace-nowrap">
                                <p class="font-semibold text-ink-900">₹{{ number_format((float) $product->effective_price, 0) }}</p>
                                @if($product->offer_price && (float) $product->price > (float) $product->offer_price)
                                    <p class="text-xs text-ink-400 line-through">₹{{ number_format((float) $product->price, 0) }}</p>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $product->stock_quantity <= 0 ? 'bg-red-100 text-red-700' : ($product->is_low_stock ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700') }}">{{ $product->stock_quantity }}</span>
                            </td>
                            <td class="text-center">
                                @if($product->is_active)
                                    <span class="badge bg-green-100 text-green-700">Active</span>
                                @else
                                    <span class="badge bg-ink-100 text-ink-700">Inactive</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="table-actions">
                                    <a href="{{ route('products.show', $product) }}" target="_blank" class="table-action-delete" title="View on store">View</a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="table-action-edit">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="js-delete-form"
                                          data-confirm-title="Delete this product?"
                                          data-confirm-text="This will remove the product and all its images.">
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
