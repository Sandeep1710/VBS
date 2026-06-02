<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /** Slugs this admin module manages. */
    private const MANAGED_SLUGS = ['about-us', 'contact-us'];

    public function index(Request $request): View
    {
        $pages = CmsPage::whereIn('slug', self::MANAGED_SLUGS)
            ->get()
            ->keyBy('slug');

        // Auto-create missing rows so the form always has something to bind to
        foreach (self::MANAGED_SLUGS as $slug) {
            if (! $pages->has($slug)) {
                $pages[$slug] = CmsPage::create([
                    'slug' => $slug,
                    'title' => $slug === 'about-us' ? 'About Us' : 'Contact Us',
                    'content' => '',
                    'is_active' => true,
                ]);
            }
        }

        $activeTab = in_array($request->query('tab'), self::MANAGED_SLUGS, true)
            ? $request->query('tab')
            : 'about-us';

        return view('admin.pages.index', [
            'about' => $pages['about-us'],
            'contact' => $pages['contact-us'],
            'activeTab' => $activeTab,
        ]);
    }

    public function update(Request $request, string $slug): RedirectResponse
    {
        abort_unless(in_array($slug, self::MANAGED_SLUGS, true), 404);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'content' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $page = CmsPage::firstOrNew(['slug' => $slug]);
        $page->title = $data['title'];
        $page->content = $data['content'] ?? '';
        $page->is_active = $request->boolean('is_active');
        $page->save();

        return redirect()->route('admin.pages.index', ['tab' => $slug])
            ->with('success', $page->title . ' updated.');
    }
}
