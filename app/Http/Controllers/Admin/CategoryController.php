<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends AdminController
{
    public function index(): View
    {
        $categories = Category::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug(Category::class, $data['name']);
        $data['image'] = $this->storeImage($request->file('image'), 'categories');

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $category->name === $data['name']
            ? $category->slug
            : $this->uniqueSlug(Category::class, $data['name'], $category->id);
        $data['image'] = $this->storeImage($request->file('image'), 'categories', $category->image);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->deleteImage($category->image);
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
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
