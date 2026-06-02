@php($address = $address ?? null)

<div class="grid gap-4 md:grid-cols-2">
    <div>
        <x-label for="label" value="Label" />
        <x-input name="label" :value="optional($address)->label ?? 'Home'" placeholder="Home / Office" />
        <x-input-error for="label" />
    </div>
    <div>
        <x-label for="name" value="Recipient name" required />
        <x-input name="name" :value="optional($address)->name" required />
        <x-input-error for="name" />
    </div>
    <div>
        <x-label for="phone" value="Phone number" required />
        <x-input name="phone" type="tel" :value="optional($address)->phone" required />
        <x-input-error for="phone" />
    </div>
    <div>
        <x-label for="pincode" value="Pincode" required />
        <x-input name="pincode" :value="optional($address)->pincode" required />
        <x-input-error for="pincode" />
    </div>
    <div class="md:col-span-2">
        <x-label for="line1" value="Address line 1" required />
        <x-input name="line1" :value="optional($address)->line1" required placeholder="House/flat no, building, street" />
        <x-input-error for="line1" />
    </div>
    <div class="md:col-span-2">
        <x-label for="line2" value="Address line 2" />
        <x-input name="line2" :value="optional($address)->line2" placeholder="Area, locality" />
        <x-input-error for="line2" />
    </div>
    <div class="md:col-span-2">
        <x-label for="landmark" value="Landmark" />
        <x-input name="landmark" :value="optional($address)->landmark" placeholder="Near..." />
        <x-input-error for="landmark" />
    </div>
    <div>
        <x-label for="city" value="City" required />
        <x-input name="city" :value="optional($address)->city" required />
        <x-input-error for="city" />
    </div>
    <div>
        <x-label for="state" value="State" required />
        <x-input name="state" :value="optional($address)->state" required />
        <x-input-error for="state" />
    </div>
    <div>
        <x-label for="country" value="Country" />
        <x-input name="country" :value="optional($address)->country ?? 'India'" />
        <x-input-error for="country" />
    </div>
</div>

<label class="mt-4 flex items-center gap-2 text-sm text-ink-700">
    <input type="checkbox" name="is_default" value="1" @checked(old('is_default', optional($address)->is_default)) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
    Set as default address
</label>
