@php($pincode = $pincode ?? null)

<x-card>
    <div class="grid gap-4 md:grid-cols-3">
        <div>
            <x-label for="pincode" value="Pincode" required />
            <x-input name="pincode" :value="optional($pincode)->pincode" required />
            <x-input-error for="pincode" />
        </div>
        <div>
            <x-label for="city" value="City" required />
            <x-input name="city" :value="optional($pincode)->city" required />
        </div>
        <div>
            <x-label for="state" value="State" required />
            <x-input name="state" :value="optional($pincode)->state" required />
        </div>
        <div>
            <x-label for="region" value="Region (optional)" />
            <x-input name="region" :value="optional($pincode)->region" />
        </div>
        <div>
            <x-label for="delivery_charge" value="Delivery charge (₹)" />
            <x-input name="delivery_charge" type="number" step="0.01" min="0" :value="optional($pincode)->delivery_charge ?? 0" />
        </div>
        <div>
            <x-label for="expected_delivery_days" value="Expected delivery (days)" />
            <x-input name="expected_delivery_days" type="number" min="0" max="30" :value="optional($pincode)->expected_delivery_days ?? 3" />
        </div>
    </div>

    <div class="mt-5 flex flex-wrap items-center gap-6 text-sm text-ink-700">
        <label class="flex cursor-pointer items-center gap-2">
            <input type="checkbox" name="is_serviceable" value="1" @checked(old('is_serviceable', $pincode->is_serviceable ?? true)) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
            Serviceable
        </label>
        <label class="flex cursor-pointer items-center gap-2">
            <input type="checkbox" name="cod_available" value="1" @checked(old('cod_available', $pincode->cod_available ?? true)) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
            COD available
        </label>
    </div>
</x-card>
