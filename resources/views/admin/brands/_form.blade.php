@php($brand = $brand ?? null)

<x-card>
    <div class="grid gap-4 md:grid-cols-2">
        <div class="md:col-span-2">
            <x-label for="name" value="Brand name" required />
            <x-input name="name" :value="optional($brand)->name" required />
            <x-input-error for="name" />
        </div>

        <div class="md:col-span-2">
            <x-label for="description" value="Description" />
            <textarea name="description" id="description" rows="3" class="input">{{ old('description', optional($brand)->description) }}</textarea>
        </div>

        <div>
            <x-label for="logo" value="Logo" />
            <input type="file" name="logo" id="logo" accept="image/jpeg,image/png,image/webp,image/svg+xml"
                   class="block w-full text-sm text-ink-700 file:mr-3 file:rounded-lg file:border-0 file:bg-ink-100 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-ink-700 hover:file:bg-ink-200">
            <x-input-error for="logo" />
            @if(optional($brand)->logo)
                <img src="{{ asset('storage/' . $brand->logo) }}" alt="" class="mt-2 h-14 w-14 rounded-lg object-contain bg-ink-50 p-1 ring-1 ring-ink-200">
            @endif
        </div>

        <div>
            <x-label for="sort_order" value="Sort order" />
            <x-input name="sort_order" type="number" min="0" :value="optional($brand)->sort_order ?? 0" />
        </div>
    </div>

    <div class="mt-5 flex flex-wrap items-center gap-6 text-sm text-ink-700">
        <label class="flex cursor-pointer items-center gap-2">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $brand->is_active ?? true)) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
            Active
        </label>
        <label class="flex cursor-pointer items-center gap-2">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $brand->is_featured ?? false)) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
            Featured (shown on homepage)
        </label>
    </div>
</x-card>
