<?php

namespace App\Http\Controllers;

use App\Models\BatteryBrand;
use App\Models\Category;
use App\Models\Product;
use App\Models\VehicleVariant;
use App\Services\Catalog\ProductFilterService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private readonly ProductFilterService $filters)
    {
    }

    public function index(Request $request): View
    {
        $products = $this->filters->paginate($request);
        return view('products.index', $this->commonViewData($request, products: $products, title: 'All Batteries'));
    }

    public function category(Request $request, Category $category): View
    {
        abort_unless($category->is_active, 404);
        $products = $this->filters->paginate($request, category: $category);
        return view('products.index', $this->commonViewData(
            $request,
            products: $products,
            title: $category->name,
            description: $category->description,
            seoTitle: $category->meta_title,
            seoDescription: $category->meta_description,
            currentCategory: $category,
        ));
    }

    public function brand(Request $request, BatteryBrand $brand): View
    {
        abort_unless($brand->is_active, 404);
        $products = $this->filters->paginate($request, brand: $brand);
        return view('products.index', $this->commonViewData(
            $request,
            products: $products,
            title: $brand->name . ' Batteries',
            description: $brand->description,
            seoTitle: $brand->meta_title,
            seoDescription: $brand->meta_description,
            currentBrand: $brand,
        ));
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load([
            'batteryBrand',
            'category',
            'images',
            'specifications' => fn ($q) => $q->orderBy('sort_order'),
            'approvedReviews.user',
            'approvedReviews.images',
            'fitments.vehicleVariant.vehicleModel.vehicleBrand',
            'fitments.vehicleVariant.vehicleModel.vehicleType',
        ]);

        Product::where('id', $product->id)->increment('views_count');

        $similar = Product::active()
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($product) {
                $q->where('battery_brand_id', $product->battery_brand_id)
                    ->orWhere('category_id', $product->category_id);
            })
            ->with(['batteryBrand', 'primaryImage'])
            ->orderByDesc('sales_count')
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'similar'));
    }

    private function commonViewData(
        Request $request,
        $products,
        string $title,
        ?string $description = null,
        ?string $seoTitle = null,
        ?string $seoDescription = null,
        ?Category $currentCategory = null,
        ?BatteryBrand $currentBrand = null,
    ): array {
        $allBrands = BatteryBrand::where('is_active', true)->orderBy('sort_order')->get();
        $allCategories = Category::where('is_active', true)->orderBy('sort_order')->get();

        $variantId = $request->input('vehicle_variant');
        $vehicleContext = null;
        if ($variantId) {
            $vehicleContext = VehicleVariant::with('vehicleModel.vehicleBrand', 'vehicleModel.vehicleType')->find($variantId);
        }

        return [
            'products' => $products,
            'title' => $title,
            'description' => $description,
            'seoTitle' => $seoTitle,
            'seoDescription' => $seoDescription,
            'allBrands' => $allBrands,
            'allCategories' => $allCategories,
            'activeFilters' => $this->filters->activeFilters($request),
            'sortOptions' => ProductFilterService::ALLOWED_SORTS,
            'currentCategory' => $currentCategory,
            'currentBrand' => $currentBrand,
            'vehicleContext' => $vehicleContext,
        ];
    }
}
