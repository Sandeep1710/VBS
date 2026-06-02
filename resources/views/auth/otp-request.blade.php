<x-layouts.auth :title="'Sign in with OTP'">
    <div class="card p-7">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-ink-900">Sign in with OTP</h1>
            <p class="mt-1 text-sm text-ink-600">We'll send you a 6-digit code to your email or phone.</p>
        </div>

        <x-validation-errors class="mt-5" />

        <form method="POST" action="{{ route('otp.send') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <x-label value="Send code to" required />
                <div class="grid grid-cols-2 gap-2">
                    <label class="cursor-pointer">
                        <input type="radio" name="channel" value="email" checked class="peer sr-only">
                        <div class="grid h-12 place-items-center rounded-lg border border-ink-200 bg-white text-sm font-medium text-ink-700 peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:text-brand-800">
                            Email
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="channel" value="sms" class="peer sr-only">
                        <div class="grid h-12 place-items-center rounded-lg border border-ink-200 bg-white text-sm font-medium text-ink-700 peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:text-brand-800">
                            Phone (SMS)
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <x-label for="identifier" value="Email or phone" required />
                <x-input name="identifier" required autofocus placeholder="you@example.com or 9876543210" />
                <x-input-error for="identifier" />
            </div>

            <x-button type="submit" class="w-full">Send code</x-button>
        </form>

        <p class="mt-6 text-center text-sm text-ink-600">
            Use password instead?
            <a href="{{ route('login') }}" class="font-semibold text-brand-600 hover:text-brand-700">Sign in</a>
        </p>
    </div>
</x-layouts.auth>
