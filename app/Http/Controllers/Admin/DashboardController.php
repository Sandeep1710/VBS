<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BatteryBrand;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\Faq;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'products' => ['total' => Product::count(), 'active' => Product::where('is_active', true)->count()],
            'categories' => ['total' => Category::count(), 'active' => Category::where('is_active', true)->count()],
            'brands' => ['total' => BatteryBrand::count(), 'active' => BatteryBrand::where('is_active', true)->count()],
            'banners' => Banner::count(),
            'testimonials' => Testimonial::count(),
            'faqs' => Faq::count(),
            'pages' => CmsPage::count(),
            'featured_products' => Product::where('is_featured', true)->where('is_active', true)->count(),
            'low_stock' => Product::where('is_active', true)
                ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
                ->where('stock_quantity', '>', 0)
                ->count(),
            'out_of_stock' => Product::where('is_active', true)->where('stock_quantity', '<=', 0)->count(),
        ];

        $recentProducts = Product::with('batteryBrand', 'primaryImage', 'category')
            ->latest()
            ->limit(6)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProducts'));
    }
}
