<x-layouts.app :title="$page->meta_title ?? $page->title">
    <article class="mx-auto max-w-3xl">
        <h1 class="text-3xl font-bold text-ink-900">{{ $page->title }}</h1>
        <div class="prose prose-ink mt-6 max-w-none text-ink-700">
            {!! $page->content !!}
        </div>
    </article>
</x-layouts.app>
