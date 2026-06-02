@php($banner = $banner ?? null)

<x-card>
    <div class="grid gap-4 md:grid-cols-2">
        <div class="md:col-span-2">
            <x-label for="title" value="Title" required />
            <x-input name="title" :value="optional($banner)->title" required />
            <x-input-error for="title" />
        </div>

        <div class="md:col-span-2">
            <x-label for="subtitle" value="Subtitle" />
            <x-input name="subtitle" :value="optional($banner)->subtitle" />
        </div>

        <div>
            <x-label for="image" value="Desktop image" :required="!$banner" />
            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp"
                   class="block w-full text-sm text-ink-700 file:mr-3 file:rounded-lg file:border-0 file:bg-ink-100 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-ink-700 hover:file:bg-ink-200">
            <x-input-error for="image" />
            @if(optional($banner)->image)
                <img src="{{ asset('storage/' . $banner->image) }}" alt="" class="mt-2 h-20 w-32 rounded object-cover ring-1 ring-ink-200">
            @endif
        </div>

        <div>
            <x-label for="mobile_image" value="Mobile image (optional)" />
            <input type="file" name="mobile_image" id="mobile_image" accept="image/jpeg,image/png,image/webp"
                   class="block w-full text-sm text-ink-700 file:mr-3 file:rounded-lg file:border-0 file:bg-ink-100 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-ink-700 hover:file:bg-ink-200">
            <x-input-error for="mobile_image" />
            @if(optional($banner)->mobile_image)
                <img src="{{ asset('storage/' . $banner->mobile_image) }}" alt="" class="mt-2 h-20 w-32 rounded object-cover ring-1 ring-ink-200">
            @endif
        </div>

        <div>
            <x-label for="position" value="Position" required />
            <select name="position" id="position" class="input" required>
                @foreach($positions as $pos)
                    <option value="{{ $pos }}" @selected(old('position', optional($banner)->position) === $pos)>{{ $pos }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <x-label for="sort_order" value="Sort order" />
            <x-input name="sort_order" type="number" min="0" :value="optional($banner)->sort_order ?? 0" />
        </div>

        <div>
            <x-label for="link_url" value="Link URL" />
            <x-input name="link_url" type="url" :value="optional($banner)->link_url" placeholder="https://..." />
            <x-input-error for="link_url" />
        </div>

        <div>
            <x-label for="link_text" value="Link text" />
            <x-input name="link_text" :value="optional($banner)->link_text" placeholder="Shop now" />
        </div>

        <div>
            <x-label for="starts_at" value="Start date (optional)" />
            <x-input name="starts_at" type="datetime-local" :value="optional($banner?->starts_at)->format('Y-m-d\TH:i')" />
        </div>

        <div>
            <x-label for="ends_at" value="End date (optional)" />
            <x-input name="ends_at" type="datetime-local" :value="optional($banner?->ends_at)->format('Y-m-d\TH:i')" />
            <x-input-error for="ends_at" />
        </div>
    </div>

    <div class="mt-5">
        <label class="flex cursor-pointer items-center gap-2 text-sm text-ink-700">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $banner->is_active ?? true)) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
            Active
        </label>
    </div>
</x-card>
