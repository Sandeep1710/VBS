@php($testimonial = $testimonial ?? null)

<x-card>
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <x-label for="name" value="Customer name" required />
            <x-input name="name" :value="optional($testimonial)->name" required />
            <x-input-error for="name" />
        </div>

        <div>
            <x-label for="designation" value="Designation" />
            <x-input name="designation" :value="optional($testimonial)->designation" placeholder="e.g. Software Engineer" />
        </div>

        <div>
            <x-label for="city" value="City" />
            <x-input name="city" :value="optional($testimonial)->city" />
        </div>

        <div>
            <x-label for="rating" value="Rating" required />
            <select name="rating" id="rating" class="input" required>
                @for($r = 5; $r >= 1; $r--)
                    <option value="{{ $r }}" @selected(old('rating', optional($testimonial)->rating ?? 5) == $r)>{{ str_repeat('★', $r) }} ({{ $r }} stars)</option>
                @endfor
            </select>
            <x-input-error for="rating" />
        </div>

        <div class="md:col-span-2">
            <x-label for="comment" value="Comment" required />
            <textarea name="comment" id="comment" rows="4" class="input" required>{{ old('comment', optional($testimonial)->comment) }}</textarea>
            <x-input-error for="comment" />
        </div>

        <div>
            <x-label for="avatar" value="Avatar" />
            <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/webp"
                   class="block w-full text-sm text-ink-700 file:mr-3 file:rounded-lg file:border-0 file:bg-ink-100 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-ink-700 hover:file:bg-ink-200">
            <x-input-error for="avatar" />
            @if(optional($testimonial)->avatar)
                <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="" class="mt-2 h-14 w-14 rounded-full object-cover ring-1 ring-ink-200">
            @endif
        </div>

        <div>
            <x-label for="sort_order" value="Sort order" />
            <x-input name="sort_order" type="number" min="0" :value="optional($testimonial)->sort_order ?? 0" />
        </div>
    </div>

    <div class="mt-5">
        <label class="flex cursor-pointer items-center gap-2 text-sm text-ink-700">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $testimonial->is_active ?? true)) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
            Active (shown on homepage)
        </label>
    </div>
</x-card>
