<x-layouts.auth :title="'Forgot password - ' . config('app.name')">
    <div class="card p-7">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-ink-900">Forgot your password?</h1>
            <p class="mt-1 text-sm text-ink-600">Enter your email and we'll send you a reset link.</p>
        </div>

        <x-validation-errors class="mt-5" />

        <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <x-label for="email" value="Email address" required />
                <x-input name="email" type="email" autocomplete="email" required autofocus placeholder="you@example.com" />
                <x-input-error for="email" />
            </div>

            <x-button type="submit" class="w-full">Send reset link</x-button>
        </form>

        <p class="mt-6 text-center text-sm text-ink-600">
            Remembered? <a href="{{ route('login') }}" class="font-semibold text-brand-600 hover:text-brand-700">Sign in</a>
        </p>
    </div>
</x-layouts.auth>
