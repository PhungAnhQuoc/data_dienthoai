<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CacheService
{
    const CACHE_DURATION = 3600; // 1 hour

    /**
     * Get all active categories with caching
     */
    public static function getCategories()
    {
        return Cache::remember('categories:all', self::CACHE_DURATION, function () {
            return Category::where('is_active', true)
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Get all active brands with caching
     */
    public static function getBrands()
    {
        return Cache::remember('brands:all', self::CACHE_DURATION, function () {
            return Brand::where('is_active', true)
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Get featured products with caching
     */
    public static function getFeaturedProducts($limit = 8)
    {
        return Cache::remember("products:featured:{$limit}", self::CACHE_DURATION, function () use ($limit) {
            return Product::where('is_active', true)
                ->where('is_featured', true)
                ->with(['images', 'category', 'brand'])
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get bestseller products with caching
     */
    public static function getBestsellerProducts($limit = 8)
    {
        return Cache::remember("products:bestseller:{$limit}", self::CACHE_DURATION, function () use ($limit) {
            return Product::where('is_active', true)
                ->where('is_bestseller', true)
                ->with(['images', 'category', 'brand'])
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get new products with caching
     */
    public static function getNewProducts($limit = 8)
    {
        return Cache::remember("products:new:{$limit}", self::CACHE_DURATION, function () use ($limit) {
            return Product::where('is_active', true)
                ->where('is_new', true)
                ->with(['images', 'category', 'brand'])
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get single product with caching
     */
    public static function getProduct($slug)
    {
        return Cache::remember("product:{$slug}", self::CACHE_DURATION, function () use ($slug) {
            return Product::where('slug', $slug)
                ->where('is_active', true)
                ->with(['images', 'category', 'brand', 'accessories'])
                ->firstOrFail();
        });
    }

    /**
     * Clear all product-related caches
     */
    public static function clearProductCaches()
    {
        Cache::forget('categories:all');
        Cache::forget('brands:all');
        Cache::forget('products:featured:*');
        Cache::forget('products:bestseller:*');
        Cache::forget('products:new:*');
    }

    /**
     * Clear single product cache
     */
    public static function clearProductCache($slug)
    {
        Cache::forget("product:{$slug}");
    }

    /**
     * Get price statistics with caching
     */
    public static function getPriceStats()
    {
        return Cache::remember('products:price_stats', self::CACHE_DURATION, function () {
            return [
                'min' => Product::where('is_active', true)->min('price'),
                'max' => Product::where('is_active', true)->max(
                    DB::raw('COALESCE(sale_price, price)')
                ),
            ];
        });
    }
}
