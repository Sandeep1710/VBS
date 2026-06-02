<x-layouts.auth>
    <div class="card p-8">
        <h1 class="text-xl font-bold text-ink-900">Admin sign in</h1>
        <p class="mt-1 text-sm text-ink-600">Use your admin credentials to continue.</p>

        <form method="POST" action="{{ route('admin.login.store') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <x-label for="email" value="Email" required />
                <x-input name="email" type="email" autocomplete="email" required autofocus />
                <x-input-error for="email" />
            </div>

            <div>
                <x-label for="password" value="Password" required />
                <x-input name="password" type="password" autocomplete="current-password" required />
                <x-input-error for="password" />
            </div>

            <button type="submit" class="btn btn-primary w-full">Sign in</button>
        </form>
    </div>
</x-layouts.auth>
