<?php

namespace App\Services\Reviews;

use App\Models\Product;
use App\Models\Review;

class RatingAggregator
{
    public function recompute(Product $product): void
    {
        $stats = Review::query()
            ->where('product_id', $product->id)
            ->where('is_approved', true)
            ->selectRaw('AVG(rating) AS avg_rating, COUNT(*) AS total')
            ->first();

        $product->forceFill([
            'rating_avg' => round((float) ($stats->avg_rating ?? 0), 2),
            'rating_count' => (int) ($stats->total ?? 0),
        ])->save();
    }
}
