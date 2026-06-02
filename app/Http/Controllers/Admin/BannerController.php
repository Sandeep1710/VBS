<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BannerController extends AdminController
{
    private const POSITIONS = ['home_hero', 'home_promo', 'category_top', 'sidebar'];

    public function index(): View
    {
        $banners = Banner::orderBy('position')->orderBy('sort_order')->get();
        return view('admin.banners.index', [
            'banners' => $banners,
            'positions' => self::POSITIONS,
        ]);
    }

    public function create(): View
    {
        return view('admin.banners.create', ['positions' => self::POSITIONS]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request, true);
        $data['image'] = $this->storeImage($request->file('image'), 'banners');
        $data['mobile_image'] = $this->storeImage($request->file('mobile_image'), 'banners');

        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created.');
    }

    public function edit(Banner $banner): View
    {
        return view('admin.banners.edit', ['banner' => $banner, 'positions' => self::POSITIONS]);
    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $data = $this->validated($request, false);
        $data['image'] = $this->storeImage($request->file('image'), 'banners', $banner->image);
        $data['mobile_image'] = $this->storeImage($request->file('mobile_image'), 'banners', $banner->mobile_image);

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated.');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        $this->deleteImage($banner->image);
        $this->deleteImage($banner->mobile_image);
        $banner->delete();
        return back()->with('success', 'Banner deleted.');
    }

    private function validated(Request $request, bool $imageRequired): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'mobile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'link_url' => ['nullable', 'url', 'max:500'],
            'link_text' => ['nullable', 'string', 'max:80'],
            'position' => ['required', Rule::in(self::POSITIONS)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
            'sort_order' => (int) $request->input('sort_order', 0),
        ];
    }
}
