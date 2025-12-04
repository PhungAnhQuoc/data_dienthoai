<?php
// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Promotion;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy banner chính
        $banners = Banner::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Lấy các ưu đãi đặc biệt
        $promotions = Promotion::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->take(3)
            ->get();

        // Lấy sản phẩm nổi bật
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with(['category', 'brand'])
            ->take(4)
            ->get();

        // Lấy sản phẩm mới
        $newProducts = Product::where('is_active', true)
            ->where('is_new', true)
            ->with(['category', 'brand'])
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Lấy sản phẩm bán chạy
        $bestsellerProducts = Product::where('is_active', true)
            ->where('is_bestseller', true)
            ->with(['category', 'brand'])
            ->take(4)
            ->get();

        // Lấy phụ kiện
        $accessories = Product::where('is_active', true)
            ->whereHas('category', function($query) {
                $query->where('slug', 'phu-kien');
            })
            ->with(['category', 'brand'])
            ->take(4)
            ->get();

        // Lấy thương hiệu nổi bật
        $brands = Brand::where('is_active', true)
            ->take(6)
            ->get();

        // Lấy danh mục
        $categories = Category::where('is_active', true)
            ->get();

        // Lấy tin tức nổi bật
        $blogPosts = BlogPost::where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('home', compact(
            'banners',
            'promotions',
            'featuredProducts',
            'newProducts',
            'bestsellerProducts',
            'accessories',
            'brands',
            'categories',
            'blogPosts'
        ));
    }
}