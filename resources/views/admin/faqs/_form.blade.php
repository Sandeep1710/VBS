@php($faq = $faq ?? null)

<x-card>
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <x-label for="category" value="Category" />
            <x-input name="category" :value="optional($faq)->category" placeholder="e.g. Order, Battery, Payment" />
        </div>

        <div>
            <x-label for="sort_order" value="Sort order" />
            <x-input name="sort_order" type="number" min="0" :value="optional($faq)->sort_order ?? 0" />
        </div>

        <div class="md:col-span-2">
            <x-label for="question" value="Question" required />
            <x-input name="question" :value="optional($faq)->question" required />
            <x-input-error for="question" />
        </div>

        <div class="md:col-span-2">
            <x-label for="answer" value="Answer" required />
            <textarea name="answer" id="answer" rows="5" class="input" required>{{ old('answer', optional($faq)->answer) }}</textarea>
            <x-input-error for="answer" />
        </div>
    </div>

    <div class="mt-5">
        <label class="flex cursor-pointer items-center gap-2 text-sm text-ink-700">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $faq->is_active ?? true)) class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
            Active (visible on site)
        </label>
    </div>
</x-card>
