<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user's wishlist.
     */
    public function index()
    {
        $wishlistItems = auth()->user()->wishlists()->with('product')->paginate(12);
        return view('wishlist.index', ['wishlistItems' => $wishlistItems]);
    }

    /**
     * Store a newly created wishlist item.
     */
    public function store(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        
        $existingWishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->exists();

        if (!$existingWishlist) {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
            ]);
        }

        return back()->with('success', 'Sản phẩm đã được thêm vào yêu thích');
    }

    /**
     * Remove the specified wishlist item.
     */
    public function destroy(string $id)
    {
        Wishlist::where('id', $id)->where('user_id', auth()->id())->delete();
        return back()->with('success', 'Sản phẩm đã được xóa khỏi yêu thích');
    }
}
