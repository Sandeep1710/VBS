<x-layouts.auth :title="'Create account - ' . config('app.name')">
    <div class="card p-7">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-ink-900">Create your account</h1>
            <p class="mt-1 text-sm text-ink-600">Start shopping for batteries with warranty and free delivery.</p>
        </div>

        <x-validation-errors class="mt-5" />

        <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <x-label for="name" value="Full name" required />
                <x-input name="name" autocomplete="name" required autofocus placeholder="Your name" />
                <x-input-error for="name" />
            </div>

            <div>
                <x-label for="email" value="Email address" required />
                <x-input name="email" type="email" autocomplete="email" required placeholder="you@example.com" />
                <x-input-error for="email" />
            </div>

            <div>
                <x-label for="phone" value="Phone number" />
                <x-input name="phone" type="tel" autocomplete="tel" placeholder="9876543210" />
                <x-input-error for="phone" />
            </div>

            <div>
                <x-label for="password" value="Password" required />
                <x-input name="password" type="password" autocomplete="new-password" required />
                <p class="mt-1 text-xs text-ink-500">Minimum 8 characters with letters and numbers.</p>
                <x-input-error for="password" />
            </div>

            <div>
                <x-label for="password_confirmation" value="Confirm password" required />
                <x-input name="password_confirmation" type="password" autocomplete="new-password" required />
            </div>

            <label class="flex items-start gap-2 text-sm text-ink-700">
                <input type="checkbox" name="terms" value="1" class="mt-0.5 h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
                <span>
                    I agree to the
                    <a href="{{ url('/cms/terms-and-conditions') }}" class="font-semibold text-brand-600 hover:text-brand-700">Terms</a>
                    and
                    <a href="{{ url('/cms/privacy-policy') }}" class="font-semibold text-brand-600 hover:text-brand-700">Privacy Policy</a>.
                </span>
            </label>
            <x-input-error for="terms" />

            <x-button type="submit" class="w-full">Create account</x-button>
        </form>

        <p class="mt-6 text-center text-sm text-ink-600">
            Already have an account?
            <a href="{{ route('login') }}" class="font-semibold text-brand-600 hover:text-brand-700">Sign in</a>
        </p>
    </div>
</x-layouts.auth>
