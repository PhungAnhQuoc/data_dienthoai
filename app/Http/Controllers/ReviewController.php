<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
            'reviewer_name' => 'nullable|string|max:255',
            'reviewer_email' => 'nullable|email',
        ]);

        $reviewerName = $validated['reviewer_name'] ?? Auth::user()->name ?? 'Anonymous';
        $reviewerEmail = $validated['reviewer_email'] ?? Auth::user()->email ?? '';

        Review::create([
            'product_id' => $productId,
            'user_id' => Auth::id(),
            'reviewer_name' => $reviewerName,
            'reviewer_email' => $reviewerEmail,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Cảm ơn bạn! Đánh giá của bạn đang chờ duyệt.');
    }

    public function destroy($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        // Chỉ user sở hữu review hoặc admin có thể xóa
        if (Auth::id() !== $review->user_id && !Auth::user()->is_admin) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Đánh giá đã được xóa.');
    }
}