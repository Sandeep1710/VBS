<x-layouts.account :title="'My Profile'">
    <x-slot:header>My profile</x-slot:header>
    <x-slot:subheader>Keep your details up to date.</x-slot:subheader>

    <x-card title="Personal information">
        <form method="POST" action="{{ route('account.profile.update') }}" class="space-y-5">
            @csrf
            @method('PATCH')

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-label for="name" value="Full name" required />
                    <x-input name="name" :value="$user->name" required />
                    <x-input-error for="name" />
                </div>
                <div>
                    <x-label for="email" value="Email address" required />
                    <x-input name="email" type="email" :value="$user->email" required />
                    <x-input-error for="email" />
                </div>
                <div>
                    <x-label for="phone" value="Phone number" />
                    <x-input name="phone" type="tel" :value="$user->phone" />
                    <x-input-error for="phone" />
                </div>
                <div>
                    <x-label for="dob" value="Date of birth" />
                    <x-input name="dob" type="date" :value="optional($user->dob)->format('Y-m-d')" />
                    <x-input-error for="dob" />
                </div>
                <div>
                    <x-label for="gender" value="Gender" />
                    <select name="gender" id="gender" class="input">
                        <option value="">Prefer not to say</option>
                        <option value="male" @selected(old('gender', $user->gender) === 'male')>Male</option>
                        <option value="female" @selected(old('gender', $user->gender) === 'female')>Female</option>
                        <option value="other" @selected(old('gender', $user->gender) === 'other')>Other</option>
                    </select>
                    <x-input-error for="gender" />
                </div>
            </div>

            <div class="flex items-center justify-end">
                <x-button type="submit">Save changes</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.account>
