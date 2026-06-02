<x-layouts.account :title="'Add Address'">
    <x-slot:header>Add a new address</x-slot:header>

    <x-card>
        <form method="POST" action="{{ route('account.addresses.store') }}" class="space-y-5">
            @csrf
            @include('account.addresses._form')

            <div class="flex items-center justify-end gap-3 border-t border-ink-200/60 pt-4">
                <a href="{{ route('account.addresses.index') }}" class="btn btn-outline">Cancel</a>
                <x-button type="submit">Save address</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.account>
