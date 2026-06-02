<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends AdminController
{
    public function index(Request $request): View
    {
        $query = Review::with('product', 'user', 'images')->latest();

        if ($status = $request->input('status')) {
            $query->where('is_approved', $status === 'approved');
        }

        $reviews = $query->paginate(30)->withQueryString();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Request $request, Review $review): RedirectResponse
    {
        $review->update([
            'is_approved' => true,
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ]);
        return back()->with('success', 'Review approved.');
    }

    public function reject(Review $review): RedirectResponse
    {
        $review->update(['is_approved' => false, 'approved_at' => null, 'approved_by' => null]);
        return back()->with('success', 'Review unapproved.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();
        return back()->with('success', 'Review deleted.');
    }
}
