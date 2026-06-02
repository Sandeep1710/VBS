<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Services\Catalog\ProductFilterService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function __construct(private readonly ProductFilterService $filters)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(
            Category::where('is_active', true)->orderBy('sort_order')->get()
        );
    }

    public function show(Category $category, Request $request): array
    {
        abort_unless($category->is_active, 404);
        $products = $this->filters->paginate($request, $category, perPage: (int) $request->integer('per_page', 12));
        return [
            'category' => new CategoryResource($category),
            'products' => ProductResource::collection($products),
        ];
    }
}
