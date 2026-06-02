<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ReviewRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\ReviewImage;
use App\Services\Media\ImageOptimizer;
use App\Services\Reviews\RatingAggregator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function __construct(
        private readonly RatingAggregator $aggregator,
        private readonly ImageOptimizer $optimizer,
    ) {
    }

    public function store(ReviewRequest $request, Product $product): RedirectResponse
    {
        $userId = $request->user()->id;

        $hasDelivered = Order::where('user_id', $userId)
            ->whereIn('status', [Order::STATUS_DELIVERED, Order::STATUS_COMPLETED])
            ->whereHas('items', fn ($q) => $q->where('product_id', $product->id))
            ->exists();

        $existing = Review::where('product_id', $product->id)
            ->where('user_id', $userId)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        $review = Review::create([
            'product_id' => $product->id,
            'user_id' => $userId,
            'order_id' => $request->input('order_id'),
            'rating' => (int) $request->input('rating'),
            'title' => $request->input('title'),
            'comment' => $request->input('comment'),
            'is_verified_buyer' => $hasDelivered,
            'is_approved' => false,
        ]);

        if ($request->hasFile('images')) {
            foreach ((array) $request->file('images') as $i => $upload) {
                if (! $upload || ! $upload->isValid()) {
                    continue;
                }
                $path = $this->optimizer->storeAs($upload, "reviews/{$review->id}");
                ReviewImage::create([
                    'review_id' => $review->id,
                    'path' => $path,
                    'sort_order' => $i,
                ]);
            }
        }

        return back()->with('success', 'Thanks for your review! It will appear after moderation.');
    }

    public function destroy(Request $request, Review $review): RedirectResponse
    {
        abort_unless($review->user_id === $request->user()->id, 403);
        $product = $review->product;

        // Cleanup image files
        foreach ($review->images as $img) {
            Storage::disk('public')->delete($img->path);
        }

        $review->delete();
        if ($product) {
            $this->aggregator->recompute($product);
        }
        return back()->with('success', 'Review removed.');
    }
}
