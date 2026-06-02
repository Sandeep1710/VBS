<x-layouts.app :title="$title ?? 'Coming soon'">
    <div class="grid place-items-center py-16 text-center">
        <div class="max-w-md">
            <h1 class="text-3xl font-bold text-ink-900">{{ $title ?? 'Coming soon' }}</h1>
            <p class="mt-3 text-ink-600">{{ $message ?? 'This page is being built. Check back shortly.' }}</p>
            <a href="{{ url('/') }}" class="mt-6 inline-flex btn btn-primary">Back to home</a>
        </div>
    </div>
</x-layouts.app>
