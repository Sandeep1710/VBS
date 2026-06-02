<x-layouts.auth :title="'Reset password - ' . config('app.name')">
    <div class="card p-7">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-ink-900">Set a new password</h1>
            <p class="mt-1 text-sm text-ink-600">Choose a strong password you'll remember.</p>
        </div>

        <x-validation-errors class="mt-5" />

        <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <x-label for="email" value="Email address" required />
                <x-input name="email" type="email" :value="$email" autocomplete="email" required readonly />
                <x-input-error for="email" />
            </div>

            <div>
                <x-label for="password" value="New password" required />
                <x-input name="password" type="password" autocomplete="new-password" required autofocus />
                <p class="mt-1 text-xs text-ink-500">Minimum 8 characters with letters and numbers.</p>
                <x-input-error for="password" />
            </div>

            <div>
                <x-label for="password_confirmation" value="Confirm password" required />
                <x-input name="password_confirmation" type="password" autocomplete="new-password" required />
            </div>

            <x-button type="submit" class="w-full">Reset password</x-button>
        </form>
    </div>
</x-layouts.auth>
