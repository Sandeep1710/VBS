<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(Request $request): View
    {
        $items = Wishlist::where('user_id', $request->user()->id)
            ->with(['product.batteryBrand', 'product.primaryImage'])
            ->latest()
            ->get();

        return view('account.wishlist.index', compact('items'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        Wishlist::firstOrCreate([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Added to wishlist.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Removed from wishlist.');
    }
}
