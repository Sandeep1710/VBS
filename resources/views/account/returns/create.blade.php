<x-layouts.account :title="'Request return — ' . $order->order_number">
    <x-slot:header>Request a return</x-slot:header>
    <x-slot:subheader>Order #{{ $order->order_number }} · placed {{ $order->created_at->format('d M Y') }}</x-slot:subheader>

    <x-validation-errors class="mb-4" />

    <x-card>
        <form method="POST" action="{{ route('account.returns.store', $order) }}" class="space-y-5">
            @csrf

            <div>
                <x-label value="Which item are you returning?" required />
                <div class="mt-2 space-y-2">
                    @foreach($order->items as $item)
                        <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-ink-200 p-3 has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50/40">
                            <input type="radio" name="order_item_id" value="{{ $item->id }}" required class="mt-1 h-4 w-4 border-ink-300 text-brand-600 focus:ring-brand-500">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-ink-900">{{ $item->product_name }}</p>
                                <p class="text-xs text-ink-500">SKU {{ $item->product_sku }} · Qty {{ $item->quantity }} · ₹{{ number_format((float) $item->total, 2) }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>
                <x-input-error for="order_item_id" />
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-label for="quantity" value="Quantity to return" required />
                    <x-input name="quantity" type="number" min="1" value="1" required />
                    <x-input-error for="quantity" />
                </div>
                <div>
                    <x-label for="reason" value="Reason" required />
                    <select name="reason" id="reason" required class="input">
                        <option value="">Select a reason</option>
                        @foreach(\App\Models\OrderReturn::REASONS as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="reason" />
                </div>
            </div>

            <div>
                <x-label for="details" value="Tell us more (optional)" />
                <textarea name="details" id="details" rows="4" maxlength="2000" class="input" placeholder="What happened? When did you notice the issue?"></textarea>
                <x-input-error for="details" />
            </div>

            <div class="rounded-lg bg-amber-50 p-3 text-xs text-amber-800 ring-1 ring-amber-200">
                We'll respond within 2 business days. Approved returns are picked up at no cost.
            </div>

            <div class="flex justify-end gap-3 border-t border-ink-200/60 pt-4">
                <a href="{{ route('account.orders.show', $order) }}" class="btn btn-outline">Cancel</a>
                <x-button type="submit">Submit return request</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.account>
