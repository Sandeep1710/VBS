<?php

namespace App\Http\Controllers\Admin;

use App\Models\BatteryBrand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BatteryBrandController extends AdminController
{
    public function index(): View
    {
        $brands = BatteryBrand::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function create(): View
    {
        return view('admin.brands.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug(BatteryBrand::class, $data['name']);
        $data['logo'] = $this->storeImage($request->file('logo'), 'brands');

        BatteryBrand::create($data);

        return redirect()->route('admin.brands.index')->with('success', 'Brand created.');
    }

    public function edit(BatteryBrand $brand): View
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, BatteryBrand $brand): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $brand->name === $data['name']
            ? $brand->slug
            : $this->uniqueSlug(BatteryBrand::class, $data['name'], $brand->id);
        $data['logo'] = $this->storeImage($request->file('logo'), 'brands', $brand->logo);

        $brand->update($data);

        return redirect()->route('admin.brands.index')->with('success', 'Brand updated.');
    }

    public function destroy(BatteryBrand $brand): RedirectResponse
    {
        $this->deleteImage($brand->logo);
        $brand->delete();
        return back()->with('success', 'Brand deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => (int) $request->input('sort_order', 0),
        ];
    }
}
