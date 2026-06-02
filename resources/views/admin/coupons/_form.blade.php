@php($coupon = $coupon ?? null)

<x-card>
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <x-label for="code" value="Coupon code" required />
            <x-input name="code" :value="optional($coupon)->code" placeholder="e.g. WELCOME200" required class="uppercase font-mono" />
            <x-input-error for="code" />
        </div>
        <div>
            <x-label for="name" value="Display name" required />
            <x-input name="name" :value="optional($coupon)->name" required />
            <x-input-error for="name" />
        </div>
        <div class="md:col-span-2">
            <x-label for="description" value="Description (optional)" />
            <textarea name="description" id="description" rows="2" class="input">{{ old('description', optional($coupon)->description) }}</textarea>
        </div>
        <div>
            <x-label for="type" value="Discount type" required />
            <select name="type" id="type" class="input" required>
                <option value="flat" @selected(old('type', optional($coupon)->type) === 'flat')>Flat (₹)</option>
                <option value="percentage" @selected(old('type', optional($coupon)->type) === 'percentage')>Percentage (%)</option>
            </select>
        </div>
        <div>
            <x-label for="value" value="Value" required />
            <x-input name="value" type="number" step="0.01" min="0" :value="optional($coupon)->value" required />
            <x-input-error for="value" />
        </div>
        <div>
            <x-label for="max_discount" value="Max discount cap (₹)" />
            <x-input name="max_discount" type="number" step="0.01" min="0" :value="optional($coupon)->max_discount" placeholder="Only for % coupons" />
        </div>
        <div>
            <x-label for="min_order_amount" value="Minimum order amount (₹)" />
            <x-input name="min_order_amount" type="number" step="0.01" min="0" :value="optional($coupon)->min_order_amount ?? 0" />
        </div>
        <div>
            <x-label for="usage_limit" value="Total usage limit" />
            <x-input name="usage_limit" type="number" min="1" :value="optional($coupon)->usage_limit" placeholder="No limit" />
        </div>
        <div>
            <x-label for="per_user_limit" value="Per-user limit" />
            <x-input name="per_user_limit" type="number" min="1" :value="optional($coupon)->per_user_limit ?? 1" />
        </div>
        <div>
            <x-label for="starts_at" value="Starts at" />
            <x-input name="starts_at" type="datetime-local" :value="optional($coupon?->starts_at)->format('Y-m-d\TH:i')" />
        </div>
        <div>
            <x-label for="expires_at" value="Expires at" />
            <x-input name="expires_at" type="datetime-local" :value="optional($coupon?->expires_at)->format('Y-m-d\TH:i')" />
            <x-input-error for="expires_at" />
        </div>
    </div>

    <div class="mt-5 flex flex-wrap items-center gap-6 text-sm text-ink-700">
        <label class="flex cursor-pointer items-center gap-2">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $coupon->is_active ?? true)) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
            Active
        </label>
        <label class="flex cursor-pointer items-center gap-2">
            <input type="checkbox" name="is_first_order_only" value="1" @checked(old('is_first_order_only', optional($coupon)->is_first_order_only)) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
            First order only
        </label>
    </div>
</x-card>
