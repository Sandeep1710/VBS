<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends AdminController
{
    public function index(): View
    {
        $faqs = Faq::orderBy('category')->orderBy('sort_order')->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create(): View
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Faq::create($this->validated($request));
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created.');
    }

    public function edit(Faq $faq): View
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $faq->update($this->validated($request));
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();
        return back()->with('success', 'FAQ deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'category' => ['nullable', 'string', 'max:80'],
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
            'sort_order' => (int) $request->input('sort_order', 0),
        ];
    }
}
