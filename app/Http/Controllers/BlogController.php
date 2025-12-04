<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Product;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private function getActivePostsQuery()
    {
        return BlogPost::where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function index()
    {
        $posts = $this->getActivePostsQuery()
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = $this->getActivePostsQuery()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPosts = $this->getActivePostsQuery()
            ->where('id', '!=', $post->id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $suggestedProducts = Product::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts', 'suggestedProducts'));
    }
}