<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pincode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PincodeController extends AdminController
{
    public function index(Request $request): View
    {
        $query = Pincode::query()->orderBy('pincode');
        if ($q = trim((string) $request->input('q'))) {
            $query->where(function ($b) use ($q) {
                $b->where('pincode', 'like', "%$q%")->orWhere('city', 'like', "%$q%");
            });
        }
        $pincodes = $query->paginate(50)->withQueryString();
        return view('admin.pincodes.index', compact('pincodes'));
    }

    public function create(): View
    {
        return view('admin.pincodes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Pincode::create($this->validated($request));
        return redirect()->route('admin.pincodes.index')->with('success', 'Pincode added.');
    }

    public function edit(Pincode $pincode): View
    {
        return view('admin.pincodes.edit', compact('pincode'));
    }

    public function update(Request $request, Pincode $pincode): RedirectResponse
    {
        $pincode->update($this->validated($request, $pincode->id));
        return redirect()->route('admin.pincodes.index')->with('success', 'Pincode updated.');
    }

    public function destroy(Pincode $pincode): RedirectResponse
    {
        $pincode->delete();
        return back()->with('success', 'Pincode deleted.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'pincode' => ['required', 'string', 'max:10', Rule::unique('pincodes', 'pincode')->ignore($ignoreId)],
            'city' => ['required', 'string', 'max:80'],
            'state' => ['required', 'string', 'max:80'],
            'region' => ['nullable', 'string', 'max:80'],
            'is_serviceable' => ['nullable', 'boolean'],
            'cod_available' => ['nullable', 'boolean'],
            'delivery_charge' => ['nullable', 'numeric', 'min:0'],
            'expected_delivery_days' => ['nullable', 'integer', 'min:0', 'max:30'],
        ]);
        $data['is_serviceable'] = $request->boolean('is_serviceable');
        $data['cod_available'] = $request->boolean('cod_available');
        $data['delivery_charge'] = (float) ($data['delivery_charge'] ?? 0);
        $data['expected_delivery_days'] = (int) ($data['expected_delivery_days'] ?? 3);
        return $data;
    }
}
