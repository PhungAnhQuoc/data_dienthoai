<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('product')
            ->latest()
            ->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy($reviewId)
    {
        Review::findOrFail($reviewId)->delete();

        return back()->with('success', 'Đánh giá đã được xóa.');
    }

    public function approve($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->update(['is_approved' => true]);

        return back()->with('success', 'Đánh giá đã được duyệt.');
    }

    public function reject($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->update(['is_approved' => false]);

        return back()->with('success', 'Đánh giá đã bị từ chối.');
    }
}
