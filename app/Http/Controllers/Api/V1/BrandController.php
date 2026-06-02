<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BatteryBrandResource;
use App\Http\Resources\ProductResource;
use App\Models\BatteryBrand;
use App\Services\Catalog\ProductFilterService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BrandController extends Controller
{
    public function __construct(private readonly ProductFilterService $filters)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        return BatteryBrandResource::collection(
            BatteryBrand::where('is_active', true)->orderBy('sort_order')->get()
        );
    }

    public function show(BatteryBrand $brand, Request $request): array
    {
        abort_unless($brand->is_active, 404);
        $products = $this->filters->paginate($request, brand: $brand, perPage: (int) $request->integer('per_page', 12));
        return [
            'brand' => new BatteryBrandResource($brand),
            'products' => ProductResource::collection($products),
        ];
    }
}
