<x-layouts.account :title="'Change Password'">
    <x-slot:header>Change password</x-slot:header>
    <x-slot:subheader>Use a strong password unique to this site.</x-slot:subheader>

    <x-card title="Update password">
        <form method="POST" action="{{ route('account.password.update') }}" class="space-y-5">
            @csrf
            @method('PATCH')

            <div>
                <x-label for="current_password" value="Current password" required />
                <x-input name="current_password" type="password" autocomplete="current-password" required />
                <x-input-error for="current_password" />
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-label for="password" value="New password" required />
                    <x-input name="password" type="password" autocomplete="new-password" required />
                    <p class="mt-1 text-xs text-ink-500">Minimum 8 characters with letters and numbers.</p>
                    <x-input-error for="password" />
                </div>
                <div>
                    <x-label for="password_confirmation" value="Confirm new password" required />
                    <x-input name="password_confirmation" type="password" autocomplete="new-password" required />
                </div>
            </div>

            <div class="flex justify-end">
                <x-button type="submit">Update password</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.account>
