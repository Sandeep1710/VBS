<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Catalog\ProductFilterService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function __construct(private readonly ProductFilterService $filters)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $products = $this->filters->paginate($request, perPage: (int) $request->integer('per_page', 12));
        return ProductResource::collection($products);
    }

    public function show(Product $product): ProductDetailResource
    {
        abort_unless($product->is_active, 404);
        $product->load([
            'batteryBrand', 'category', 'images',
            'specifications' => fn ($q) => $q->orderBy('sort_order'),
            'fitments.vehicleVariant.vehicleModel.vehicleBrand',
        ]);
        Product::where('id', $product->id)->increment('views_count');
        return new ProductDetailResource($product);
    }
}
