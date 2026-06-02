<x-layouts.auth :title="'Sign in - ' . config('app.name')">
    <div class="card p-7">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-ink-900">Welcome back</h1>
            <p class="mt-1 text-sm text-ink-600">Sign in to your account to continue.</p>
        </div>

        <x-validation-errors class="mt-5" />

        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <x-label for="email" value="Email address" required />
                <x-input name="email" type="email" autocomplete="email" required autofocus />
                <x-input-error for="email" />
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <x-label for="password" value="Password" required />
                    @if(\Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-medium text-brand-600 hover:text-brand-700">Forgot password?</a>
                    @endif
                </div>
                <x-input name="password" type="password" autocomplete="current-password" required />
                <x-input-error for="password" />
            </div>

            <label class="flex items-center gap-2 text-sm text-ink-700">
                <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
                Remember me
            </label>

            <x-button type="submit" class="w-full">Sign in</x-button>
        </form>

        <div class="mt-4 flex items-center gap-3 text-xs text-ink-500">
            <span class="h-px flex-1 bg-ink-200"></span>
            <span>or</span>
            <span class="h-px flex-1 bg-ink-200"></span>
        </div>
        <a href="{{ route('otp.request') }}" class="btn btn-outline mt-4 w-full">Sign in with OTP</a>

        <p class="mt-6 text-center text-sm text-ink-600">
            New to Vehicle Battery Store?
            <a href="{{ route('register') }}" class="font-semibold text-brand-600 hover:text-brand-700">Create an account</a>
        </p>
    </div>
</x-layouts.auth>
