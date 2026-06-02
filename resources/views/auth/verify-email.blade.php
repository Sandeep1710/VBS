<x-layouts.auth :title="'Verify your email'">
    <div class="card p-7">
        <div class="text-center">
            <div class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-amber-100 text-amber-700">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-10 5L2 7"/></svg>
            </div>
            <h1 class="mt-3 text-2xl font-bold text-ink-900">Verify your email</h1>
            <p class="mt-1 text-sm text-ink-600">We just sent a verification link to <strong>{{ auth()->user()->email }}</strong>.</p>
            <p class="mt-3 text-xs text-ink-500">Click the link in the email to confirm your address. If you didn't get one, request a new link below.</p>
        </div>

        <div class="mt-6 space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary w-full">Resend verification link</button>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline w-full">Sign out</button>
            </form>
        </div>

        <p class="mt-4 text-center text-xs text-ink-500">
            Wrong email? <a href="{{ route('account.profile.edit') }}" class="font-medium text-brand-600 hover:underline">Update your profile</a>
        </p>
    </div>
</x-layouts.auth>
