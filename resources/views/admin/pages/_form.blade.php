@props(['page', 'slug', 'label', 'placeholder' => '', 'previewUrl' => null])

<form method="POST" action="{{ route('admin.pages.update', $slug) }}" class="mt-6 space-y-5">
    @csrf
    @method('PUT')

    <x-card>
        <div class="space-y-4">
            <div>
                <x-label for="{{ $slug }}-title" value="Page title" required />
                <x-input
                    id="{{ $slug }}-title"
                    name="title"
                    :value="$page->title"
                    required
                />
                <x-input-error for="title" />
                <p class="mt-1 text-xs text-ink-500">Shown as the page heading and browser tab title.</p>
            </div>

            <div>
                <x-label for="{{ $slug }}-content" value="Content (HTML allowed)" />
                <textarea
                    id="{{ $slug }}-content"
                    name="content"
                    rows="14"
                    class="input font-mono text-xs"
                    placeholder="{{ $placeholder }}"
                >{{ old('content', $page->content) }}</textarea>
                <x-input-error for="content" />
                <p class="mt-1 text-xs text-ink-500">
                    Use HTML tags like <code>&lt;p&gt;</code>, <code>&lt;h2&gt;</code>, <code>&lt;a href=&quot;...&quot;&gt;</code>, <code>&lt;strong&gt;</code>, <code>&lt;ul&gt;&lt;li&gt;</code>.
                </p>
            </div>

            <label class="flex cursor-pointer items-center gap-2 text-sm text-ink-700">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $page->is_active))
                       class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
                Visible on the website
            </label>
        </div>
    </x-card>

    <div class="flex items-center justify-between">
        @if($previewUrl)
            <a href="{{ $previewUrl }}" target="_blank" rel="noopener" class="text-sm font-medium text-brand-600 hover:text-brand-700">
                Preview on site →
            </a>
        @else
            <span></span>
        @endif
        <button type="submit" class="btn btn-primary">Save {{ $label }}</button>
    </div>
</form>
