<x-layouts.app :title="'Unsubscribed'">
    <div class="mx-auto max-w-md">
        <x-card padding="p-8">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-ink-900">You're unsubscribed</h1>
                <p class="mt-2 text-sm text-ink-600"><strong>{{ $email }}</strong> will no longer receive marketing emails.</p>
                <p class="mt-1 text-xs text-ink-500">You'll still get transactional emails (orders, password resets).</p>
                <a href="{{ url('/') }}" class="mt-5 inline-flex btn btn-primary">Back to home</a>
            </div>
        </x-card>
    </div>
</x-layouts.app>
