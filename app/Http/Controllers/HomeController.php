<?php

namespace App\Http\Controllers;

use App\Models\BatteryBrand;
use App\Models\Banner;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\Faq;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $banners = Banner::active()->where('position', 'home_hero')->orderBy('sort_order')->get();
        // Categories still loaded for other views (footer/filters) — homepage now
        // features Shop by Brand instead, since car customers think in brands.
        $categories = Category::where('is_active', true)
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->limit(6)
            ->get();
        $featuredBrands = BatteryBrand::where('is_featured', true)->where('is_active', true)->orderBy('sort_order')->get();

        // Shop-by-Brand tiles: one big tile per active brand, with live product
        // count and Ah range pulled from the catalog.
        $shopBrands = BatteryBrand::where('is_active', true)
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get()
            ->filter(fn ($b) => $b->products_count > 0)
            ->map(function ($b) {
                $range = Product::where('is_active', true)
                    ->where('battery_brand_id', $b->id)
                    ->selectRaw('MIN(capacity_ah) as min_ah, MAX(capacity_ah) as max_ah')
                    ->first();
                $b->min_ah = (int) ($range->min_ah ?? 0);
                $b->max_ah = (int) ($range->max_ah ?? 0);
                return $b;
            })
            ->values();
        $featuredProducts = Product::active()->featured()->with('batteryBrand', 'primaryImage', 'category')->limit(8)->get();
        $bestSellers = Product::active()->orderByDesc('sales_count')->orderByDesc('rating_avg')->with('batteryBrand', 'primaryImage', 'category')->limit(4)->get();
        $heroProduct = Product::active()->featured()->with('batteryBrand', 'primaryImage', 'category')->first();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->limit(6)->get();
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->limit(6)->get();

        return view('home', compact(
            'banners', 'categories', 'featuredBrands', 'shopBrands', 'featuredProducts',
            'bestSellers', 'heroProduct', 'testimonials', 'faqs'
        ));
    }

    public function cmsPage(string $slug): View
    {
        $page = CmsPage::where('slug', $slug)->where('is_active', true)->firstOrFail();

        // Slugs that have their own hand-crafted layout — fall back to the plain
        // CMS renderer for anything else (privacy, terms, refund, shipping, ...).
        $customViews = [
            'about-us'   => 'about-us',
            'contact-us' => 'contact-us',
        ];
        $viewName = $customViews[$slug] ?? 'cms-page';

        return view($viewName, compact('page'));
    }
}
