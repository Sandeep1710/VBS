<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BatteryBrand;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\Faq;
use App\Models\Order;
use App\Models\OrderReturn;
use App\Models\Product;
use App\Models\Review;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\WarrantyClaim;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'orders' => [
                'total' => Order::count(),
                'pending' => Order::where('status', Order::STATUS_PENDING)->count(),
                'today' => Order::whereDate('created_at', today())->count(),
                'revenue_today' => (float) Order::whereIn('status', [Order::STATUS_DELIVERED, Order::STATUS_COMPLETED])
                    ->whereDate('created_at', today())->sum('total'),
                'revenue_month' => (float) Order::whereIn('status', [Order::STATUS_DELIVERED, Order::STATUS_COMPLETED])
                    ->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total'),
                'revenue_total' => (float) Order::whereIn('status', [Order::STATUS_DELIVERED, Order::STATUS_COMPLETED])->sum('total'),
            ],
            'products' => ['total' => Product::count(), 'active' => Product::where('is_active', true)->count()],
            'categories' => Category::count(),
            'brands' => BatteryBrand::count(),
            'customers' => User::where('is_admin', false)->count(),
            'banners' => Banner::count(),
            'testimonials' => Testimonial::count(),
            'faqs' => Faq::count(),
            'pages' => CmsPage::count(),
            'pending_reviews' => Review::where('is_approved', false)->count(),
            'pending_returns' => OrderReturn::where('status', OrderReturn::STATUS_REQUESTED)->count(),
            'pending_warranty' => WarrantyClaim::whereIn('status', [WarrantyClaim::STATUS_SUBMITTED, WarrantyClaim::STATUS_UNDER_REVIEW])->count(),
            'low_stock' => Product::where('is_active', true)
                ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
                ->where('stock_quantity', '>', 0)
                ->count(),
            'out_of_stock' => Product::where('is_active', true)->where('stock_quantity', '<=', 0)->count(),
        ];

        $recentOrders = Order::with('user')->latest()->limit(8)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
