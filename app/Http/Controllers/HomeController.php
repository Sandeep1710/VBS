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
        $categories = Category::where('is_active', true)->orderBy('sort_order')->limit(6)->get();
        $featuredBrands = BatteryBrand::where('is_featured', true)->where('is_active', true)->orderBy('sort_order')->get();
        $featuredProducts = Product::active()->featured()->with('batteryBrand', 'primaryImage', 'category')->limit(8)->get();
        $bestSellers = Product::active()->orderByDesc('sales_count')->orderByDesc('rating_avg')->with('batteryBrand', 'primaryImage', 'category')->limit(4)->get();
        $heroProduct = Product::active()->featured()->with('batteryBrand', 'primaryImage', 'category')->first();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->limit(6)->get();
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->limit(6)->get();

        return view('home', compact(
            'banners', 'categories', 'featuredBrands', 'featuredProducts',
            'bestSellers', 'heroProduct', 'testimonials', 'faqs'
        ));
    }

    public function cmsPage(string $slug): View
    {
        $page = CmsPage::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('cms-page', compact('page'));
    }
}
