<x-layouts.account :title="'Edit Address'">
    <x-slot:header>Edit address</x-slot:header>

    <x-card>
        <form method="POST" action="{{ route('account.addresses.update', $address) }}" class="space-y-5">
            @csrf
            @method('PATCH')
            @include('account.addresses._form')

            <div class="flex items-center justify-end gap-3 border-t border-ink-200/60 pt-4">
                <a href="{{ route('account.addresses.index') }}" class="btn btn-outline">Cancel</a>
                <x-button type="submit">Save changes</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.account>
