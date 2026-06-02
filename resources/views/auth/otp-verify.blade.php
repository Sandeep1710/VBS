<x-layouts.auth :title="'Verify code'">
    <div class="card p-7">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-ink-900">Enter your code</h1>
            <p class="mt-1 text-sm text-ink-600">We sent a 6-digit code to <strong>{{ $identifier }}</strong>.</p>
        </div>

        <x-validation-errors class="mt-5" />

        <form method="POST" action="{{ route('otp.verify.submit') }}" class="mt-6 space-y-4">
            @csrf
            <input type="hidden" name="identifier" value="{{ $identifier }}">
            <input type="hidden" name="channel" value="{{ $channel }}">

            <div>
                <x-label for="code" value="Code" required />
                <x-input name="code" required autofocus inputmode="numeric" pattern="[0-9]{6}" maxlength="6" placeholder="123456" class="text-center text-2xl tracking-widest font-mono" />
                <x-input-error for="code" />
            </div>

            <x-button type="submit" class="w-full">Sign in</x-button>
        </form>

        <div class="mt-6 flex items-center justify-between text-sm">
            <a href="{{ route('otp.request') }}" class="text-ink-600 hover:text-ink-900">← Use different account</a>
            <form method="POST" action="{{ route('otp.send') }}">
                @csrf
                <input type="hidden" name="identifier" value="{{ $identifier }}">
                <input type="hidden" name="channel" value="{{ $channel }}">
                <button class="font-medium text-brand-600 hover:text-brand-700">Resend code</button>
            </form>
        </div>
    </div>
</x-layouts.auth>
