<x-layouts.account :title="'Warranty claim — ' . $order->order_number">
    <x-slot:header>Submit a warranty claim</x-slot:header>
    <x-slot:subheader>Order #{{ $order->order_number }} · placed {{ $order->created_at->format('d M Y') }}</x-slot:subheader>

    <x-validation-errors class="mb-4" />

    <x-card>
        <form method="POST" action="{{ route('account.warranty-claims.store', $order) }}" class="space-y-5">
            @csrf

            <div>
                <x-label value="Which battery has an issue?" required />
                <div class="mt-2 space-y-2">
                    @foreach($order->items as $item)
                        @php
                            $expired = $item->warranty_ends_at && $item->warranty_ends_at->isPast();
                        @endphp
                        <label class="flex cursor-pointer items-start gap-3 rounded-lg border p-3 {{ $expired ? 'border-ink-200 bg-ink-50 opacity-60' : 'border-ink-200 has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50/40' }}">
                            <input type="radio" name="order_item_id" value="{{ $item->id }}" {{ $expired ? 'disabled' : '' }} required class="mt-1 h-4 w-4 border-ink-300 text-brand-600 focus:ring-brand-500">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-ink-900">{{ $item->product_name }}</p>
                                <p class="text-xs text-ink-500">
                                    Warranty: {{ $item->warranty_months }} months
                                    @if($item->warranty_ends_at)
                                        · ends {{ $item->warranty_ends_at->format('d M Y') }}
                                        @if($expired)<span class="text-red-600 font-semibold">(expired)</span>@endif
                                    @endif
                                </p>
                            </div>
                        </label>
                    @endforeach
                </div>
                <x-input-error for="order_item_id" />
            </div>

            <div>
                <x-label for="issue_type" value="Issue type" required />
                <select name="issue_type" id="issue_type" required class="input">
                    <option value="">Select an issue type</option>
                    @foreach(\App\Models\WarrantyClaim::ISSUE_TYPES as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                <x-input-error for="issue_type" />
            </div>

            <div>
                <x-label for="description" value="Describe the issue" required />
                <textarea name="description" id="description" rows="6" minlength="20" maxlength="5000" required class="input" placeholder="When did the issue start? What symptoms? Have you tried anything?"></textarea>
                <p class="mt-1 text-xs text-ink-500">Minimum 20 characters. Be specific — it speeds up our review.</p>
                <x-input-error for="description" />
            </div>

            <div class="flex justify-end gap-3 border-t border-ink-200/60 pt-4">
                <a href="{{ route('account.orders.show', $order) }}" class="btn btn-outline">Cancel</a>
                <x-button type="submit">Submit warranty claim</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.account>
