<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AddressRequest;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AddressController extends Controller
{
    public function index(Request $request): View
    {
        $addresses = $request->user()->addresses()->latest('is_default')->latest()->get();
        return view('account.addresses.index', compact('addresses'));
    }

    public function create(): View
    {
        return view('account.addresses.create');
    }

    public function store(AddressRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['country'] = $data['country'] ?? 'India';
        $data['user_id'] = $request->user()->id;
        $isDefault = (bool) ($data['is_default'] ?? false);

        DB::transaction(function () use ($request, $data, $isDefault) {
            if ($isDefault || $request->user()->addresses()->doesntExist()) {
                $request->user()->addresses()->update(['is_default' => false]);
                $data['is_default'] = true;
            }
            Address::create($data);
        });

        return redirect()->route('account.addresses.index')
            ->with('success', 'Address added.');
    }

    public function edit(Request $request, Address $address): View
    {
        abort_unless($address->user_id === $request->user()->id, 403);
        return view('account.addresses.edit', compact('address'));
    }

    public function update(AddressRequest $request, Address $address): RedirectResponse
    {
        abort_unless($address->user_id === $request->user()->id, 403);

        $data = $request->validated();
        $data['country'] = $data['country'] ?? 'India';
        $isDefault = (bool) ($data['is_default'] ?? false);

        DB::transaction(function () use ($request, $address, $data, $isDefault) {
            if ($isDefault) {
                $request->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
                $data['is_default'] = true;
            }
            $address->update($data);
        });

        return redirect()->route('account.addresses.index')
            ->with('success', 'Address updated.');
    }

    public function destroy(Request $request, Address $address): RedirectResponse
    {
        abort_unless($address->user_id === $request->user()->id, 403);
        $wasDefault = $address->is_default;
        $address->delete();

        if ($wasDefault) {
            $next = $request->user()->addresses()->latest()->first();
            $next?->update(['is_default' => true]);
        }

        return back()->with('success', 'Address removed.');
    }

    public function setDefault(Request $request, Address $address): RedirectResponse
    {
        abort_unless($address->user_id === $request->user()->id, 403);

        DB::transaction(function () use ($request, $address) {
            $request->user()->addresses()->update(['is_default' => false]);
            $address->update(['is_default' => true]);
        });

        return back()->with('success', 'Default address updated.');
    }
}
