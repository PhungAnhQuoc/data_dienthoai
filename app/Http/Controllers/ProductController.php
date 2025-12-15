<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private function applyFilters(Request $request)
    {
        $query = Product::where('is_active', true);

        // Search by name, description, SKU
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($category = $request->input('category')) {
            $query->whereHas('category', function($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        // Filter by brand
        if ($brand = $request->input('brand')) {
            $query->whereHas('brand', function($q) use ($brand) {
                $q->where('slug', $brand);
            });
        }

        // Filter by price range
        if ($priceFrom = $request->input('price_from')) {
            $query->where(function($q) use ($priceFrom) {
                $q->where('sale_price', '>=', $priceFrom)
                  ->orWhere('price', '>=', $priceFrom);
            });
        }
        
        if ($priceTo = $request->input('price_to')) {
            $query->where(function($q) use ($priceTo) {
                $q->where(function($subQ) use ($priceTo) {
                    $subQ->where('sale_price', '<=', $priceTo)
                         ->orWhereNull('sale_price');
                })->where('price', '<=', $priceTo);
            });
        }

        // Filter by rating
        if ($minRating = $request->input('min_rating')) {
            $query->whereHas('reviews', function($q) use ($minRating) {
                $q->where('is_approved', true)
                  ->selectRaw('AVG(rating) as avg_rating')
                  ->havingRaw('AVG(rating) >= ?', [$minRating]);
            }, '>=', 1);
        }

        $this->applyStatusFilter($query, $request->input('status'));
        $this->applySorting($query, $request->input('sort', 'latest'));

        return $query;
    }

    private function applyStatusFilter(&$query, ?string $status)
    {
        if (!$status) return;

        match($status) {
            'featured' => $query->where('is_featured', true),
            'bestseller' => $query->where('is_bestseller', true),
            'sale' => $query->whereNotNull('sale_price'),
            default => null
        };
    }

    private function applySorting(&$query, string $sort)
    {
        match($sort) {
            'price_low' => $query->orderBy('sale_price', 'asc')->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('sale_price', 'desc')->orderBy('price', 'desc'),
            'bestseller' => $query->orderBy('is_bestseller', 'desc')->orderBy('created_at', 'desc'),
            'featured' => $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc'),
            default => $query->orderBy('created_at', 'desc')
        };
    }

    public function index(Request $request)
    {
        $query = $this->applyFilters($request);
        $products = $query->with(['category', 'brand', 'images'])
            ->paginate(12);
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();
        $brands = Brand::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('products.index-new-responsive', compact('products', 'categories', 'brands'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'brand', 'images', 'reviews' => function($q) {
                $q->where('is_approved', true)->orderBy('created_at', 'desc');
            }])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->with(['images'])
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
