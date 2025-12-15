<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    /**
     * Generate XML sitemap
     */
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Static pages
        $static_urls = [
            route('home'),
            route('products.index'),
            route('blog.index'),
            route('contact.index'),
        ];

        foreach ($static_urls as $url) {
            $sitemap .= $this->urlElement($url, now(), 'weekly', '1.0');
        }

        // Products
        $products = Product::where('is_active', true)->get();
        foreach ($products as $product) {
            $sitemap .= $this->urlElement(
                route('products.show', $product->slug),
                $product->updated_at,
                'monthly',
                '0.8'
            );
        }

        // Blog posts
        $posts = BlogPost::where('is_active', true)->get();
        foreach ($posts as $post) {
            $sitemap .= $this->urlElement(
                route('blog.show', $post->slug),
                $post->updated_at,
                'monthly',
                '0.7'
            );
        }

        // Categories
        $categories = Category::where('is_active', true)->get();
        foreach ($categories as $category) {
            $sitemap .= $this->urlElement(
                route('products.index', ['category' => $category->slug]),
                $category->updated_at,
                'weekly',
                '0.6'
            );
        }

        $sitemap .= '</urlset>';

        return Response::make($sitemap, 200, ['Content-Type' => 'application/xml']);
    }

    /**
     * Generate single URL element
     */
    private function urlElement($loc, $lastmod, $changefreq, $priority)
    {
        return '<url>' . "\n" .
            '<loc>' . htmlspecialchars($loc) . '</loc>' . "\n" .
            '<lastmod>' . $lastmod->toDateString() . '</lastmod>' . "\n" .
            '<changefreq>' . $changefreq . '</changefreq>' . "\n" .
            '<priority>' . $priority . '</priority>' . "\n" .
            '</url>' . "\n";
    }

    /**
     * Generate sitemap index
     */
    public function sitemapIndex()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $sitemap .= '<sitemap>' . "\n";
        $sitemap .= '<loc>' . route('sitemap.index') . '</loc>' . "\n";
        $sitemap .= '<lastmod>' . now()->toDateString() . '</lastmod>' . "\n";
        $sitemap .= '</sitemap>' . "\n";
        $sitemap .= '</sitemapindex>';

        return Response::make($sitemap, 200, ['Content-Type' => 'application/xml']);
    }
}
