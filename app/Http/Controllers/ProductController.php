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

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($category = $request->input('category')) {
            $query->whereHas('category', function($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        if ($brand = $request->input('brand')) {
            $query->whereHas('brand', function($q) use ($brand) {
                $q->where('slug', $brand);
            });
        }

        if ($priceFrom = $request->input('price_from')) {
            $query->where('price', '>=', $priceFrom);
        }
        
        if ($priceTo = $request->input('price_to')) {
            $query->where('price', '<=', $priceTo);
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
        $products = $query->with(['category', 'brand'])->paginate(12);
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();

        return view('products.index-new', compact('products', 'categories', 'brands'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
