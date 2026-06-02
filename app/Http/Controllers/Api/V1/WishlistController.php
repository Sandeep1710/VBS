<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class WishlistController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $products = Product::query()
            ->whereHas('wishlistedBy', fn ($q) => $q->where('user_id', $request->user()->id))
            ->with(['batteryBrand', 'primaryImage'])
            ->latest()
            ->paginate(20);

        return ProductResource::collection($products);
    }

    public function store(Request $request, Product $product): JsonResponse
    {
        Wishlist::firstOrCreate([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);

        return response()->json(['message' => 'Added to wishlist.']);
    }

    public function destroy(Request $request, Product $product): JsonResponse
    {
        Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->delete();

        return response()->json(['message' => 'Removed from wishlist.']);
    }
}
