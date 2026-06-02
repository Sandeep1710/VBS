<?php

namespace App\Http\Controllers\Admin;

use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends AdminController
{
    public function index(): View
    {
        $testimonials = Testimonial::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['avatar'] = $this->storeImage($request->file('avatar'), 'testimonials');

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created.');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $this->validated($request);
        $data['avatar'] = $this->storeImage($request->file('avatar'), 'testimonials', $testimonial->avatar);

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $this->deleteImage($testimonial->avatar);
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'designation' => ['nullable', 'string', 'max:120'],
            'city' => ['nullable', 'string', 'max:80'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
            'sort_order' => (int) $request->input('sort_order', 0),
        ];
    }
}
