<x-layouts.account :title="'My Addresses'">
    <x-slot:header>Saved addresses</x-slot:header>
    <x-slot:subheader>Manage delivery addresses for faster checkout.</x-slot:subheader>
    <x-slot:actions>
        <x-button :href="route('account.addresses.create')">+ Add address</x-button>
    </x-slot:actions>

    @if($addresses->isEmpty())
        <x-card>
            <div class="p-8 text-center">
                <p class="text-sm text-ink-600">You haven't saved any addresses yet.</p>
                <x-button :href="route('account.addresses.create')" class="mt-3">Add your first address</x-button>
            </div>
        </x-card>
    @else
        <div class="grid gap-4 md:grid-cols-2">
            @foreach($addresses as $address)
                <x-card padding="p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-base font-semibold text-ink-900">{{ $address->label }}</h3>
                                @if($address->is_default)
                                    <span class="badge bg-green-100 text-green-700">Default</span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm font-medium text-ink-800">{{ $address->name }}</p>
                            <p class="text-sm text-ink-600">{{ $address->phone }}</p>
                            <p class="mt-2 text-sm text-ink-600">{{ $address->full_address }}</p>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-ink-200/60 pt-3">
                        <a href="{{ route('account.addresses.edit', $address) }}" class="btn btn-secondary text-xs">Edit</a>
                        @if(! $address->is_default)
                            <form method="POST" action="{{ route('account.addresses.default', $address) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline text-xs">Set as default</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('account.addresses.destroy', $address) }}" class="inline" onsubmit="return confirm('Remove this address?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger text-xs">Remove</button>
                        </form>
                    </div>
                </x-card>
            @endforeach
        </div>
    @endif
</x-layouts.account>
