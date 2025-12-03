<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        // Search by name
        if ($request->has('search') && $request->get('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Filter by category
        if ($request->has('category') && $request->get('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->get('category'));
            });
        }

        // Filter by brand
        if ($request->has('brand') && $request->get('brand')) {
            $query->whereHas('brand', function($q) use ($request) {
                $q->where('slug', $request->get('brand'));
            });
        }

        // Filter by price range
        if ($request->has('price_from') && $request->get('price_from')) {
            $query->where('price', '>=', $request->get('price_from'));
        }
        if ($request->has('price_to') && $request->get('price_to')) {
            $query->where('price', '<=', $request->get('price_to'));
        }

        // Filter by status
        if ($request->has('status') && $request->get('status')) {
            $status = $request->get('status');
            if ($status === 'featured') {
                $query->where('is_featured', true);
            } elseif ($status === 'bestseller') {
                $query->where('is_bestseller', true);
            } elseif ($status === 'sale') {
                $query->whereNotNull('sale_price');
            }
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('sale_price', 'asc')->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('sale_price', 'desc')->orderBy('price', 'desc');
                break;
            case 'bestseller':
                $query->orderBy('is_bestseller', 'desc')->orderBy('created_at', 'desc');
                break;
            case 'featured':
                $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

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
