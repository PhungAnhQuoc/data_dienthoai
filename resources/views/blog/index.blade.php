@extends('layouts.app')

@section('content')

<!-- Blog Header -->
<div class="blog-header">
    <div class="container">
        <nav class="breadcrumb" style="margin-bottom: 20px;">
            <a href="{{ route('home') }}" class="breadcrumb-item">Home</a>
            <span class="breadcrumb-item active">Blog</span>
        </nav>
        <h1 class="blog-title">Tech Insights & Reviews</h1>
        <p class="blog-subtitle">Stay updated with cutting-edge technology reviews, and comprehensive buying guides for your next device.</p>
    </div>
</div>

<!-- Main Content -->
<div class="blog-main">
    <div class="container">
        <div class="row g-5">
            <!-- Main Column -->
            <div class="col-lg-8">
                <!-- Featured Post -->
                @if($posts->count() > 0)
                    @php $featured = $posts->first(); @endphp
                    <div class="featured-post mb-5">
                        <div class="featured-image">
                            @if($featured->featured_image)
                                <img src="{{ asset('storage/' . $featured->featured_image) }}" alt="{{ $featured->title }}">
                            @else
                                <div class="placeholder-image">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </div>
                        <div class="featured-content">
                            <div class="featured-badge">
                                <i class="bi bi-star-fill"></i> Featured Review
                            </div>
                            <h2 class="featured-title">{{ $featured->title }}</h2>
                            <p class="featured-excerpt">{{ Str::limit($featured->excerpt ?? $featured->content, 150) }}</p>
                            <a href="{{ route('blog.show', $featured->slug) }}" class="btn btn-primary">
                                Read Full Review
                                <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Recent Articles -->
                    <div class="recent-articles">
                        <div class="section-header">
                            <h3 class="section-title">Recent Articles</h3>
                            <div class="view-toggle">
                                <button class="toggle-btn grid-btn active" title="Grid view">
                                    <i class="bi bi-grid-3x2-gap"></i>
                                </button>
                                <button class="toggle-btn list-btn" title="List view">
                                    <i class="bi bi-list-ul"></i>
                                </button>
                            </div>
                        </div>

                        <div class="articles-grid">
                            @forelse($posts->skip(1) as $post)
                                <article class="article-card">
                                    <div class="article-image">
                                        @if($post->featured_image)
                                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}">
                                        @else
                                            <div class="placeholder-image">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                        @if($post->is_new ?? false)
                                            <span class="badge-new">NEW</span>
                                        @endif
                                    </div>
                                    <div class="article-content">
                                        <div class="article-meta">
                                            <span class="article-category">Tech</span>
                                            <span class="article-date">{{ $post->published_at->format('M d, Y') }}</span>
                                        </div>
                                        <h4 class="article-title">
                                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                        </h4>
                                        <p class="article-excerpt">{{ Str::limit($post->excerpt ?? $post->content, 80) }}</p>
                                        <div class="article-footer">
                                            <a href="{{ route('blog.show', $post->slug) }}" class="read-more">
                                                Read More <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @empty
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if($posts instanceof \Illuminate\Pagination\LengthAwarePaginator && $posts->hasPages())
                        <div class="pagination-wrapper">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($posts->onFirstPage())
                                    <li class="disabled"><span>&laquo;</span></li>
                                @else
                                    <li><a href="{{ $posts->previousPageUrl() }}">&laquo;</a></li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                                    @if ($page == $posts->currentPage())
                                        <li class="active"><span>{{ $page }}</span></li>
                                    @else
                                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($posts->hasMorePages())
                                    <li><a href="{{ $posts->nextPageUrl() }}">&raquo;</a></li>
                                @else
                                    <li class="disabled"><span>&raquo;</span></li>
                                @endif
                            </ul>
                        </div>
                        @endif
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-newspaper"></i>
                        </div>
                        <h3>No Articles Found</h3>
                        <p>Check back soon for new content</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Search -->
                <div class="sidebar-widget search-widget">
                    <input type="text" class="form-control" placeholder="Search articles...">
                    <button class="search-btn">
                        <i class="bi bi-search"></i>
                    </button>
                </div>

                <!-- Categories -->
                <div class="sidebar-widget">
                    <h5 class="widget-title">Categories</h5>
                    <ul class="categories-list">
                        <li><a href="#"><span>All Posts</span><span class="count">127</span></a></li>
                        <li><a href="#"><span>Reviews</span><span class="count">45</span></a></li>
                        <li><a href="#"><span>Buying Guides</span><span class="count">23</span></a></li>
                        <li><a href="#"><span>Industry News</span><span class="count">34</span></a></li>
                        <li><a href="#"><span>How&'s & Tips</span><span class="count">25</span></a></li>
                    </ul>
                </div>

                <!-- Popular Tags -->
                <div class="sidebar-widget">
                    <h5 class="widget-title">Popular Tags</h5>
                    <div class="tags-list">
                        <a href="#" class="tag">Android</a>
                        <a href="#" class="tag">iPhone</a>
                        <a href="#" class="tag">Smartphone</a>
                        <a href="#" class="tag">5G</a>
                        <a href="#" class="tag">Battery Life</a>
                        <a href="#" class="tag">Camera</a>
                        <a href="#" class="tag">Performance</a>
                        <a href="#" class="tag">Pro</a>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="sidebar-widget newsletter-widget">
                    <div class="newsletter-icon">
                        <i class="bi bi-envelope-check"></i>
                    </div>
                    <h5 class="widget-title">Tech Weekly</h5>
                    <p class="widget-description">Get the latest tech news and reviews delivered to your inbox every week.</p>
                    <form class="newsletter-form">
                        <input type="email" class="form-control" placeholder="Enter your email" required>
                        <button type="submit" class="btn btn-primary w-100">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Blog Header */
.blog-header {
    background: linear-gradient(135deg, #f9fafb 0%, #e5e7eb 100%);
    padding: 3rem 0;
    margin-bottom: 3rem;
    border-bottom: 1px solid #d1d5db;
}

.blog-header .breadcrumb {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
}

.breadcrumb-item {
    color: #6b7280;
    text-decoration: none;
    transition: color 0.2s;
}

.breadcrumb-item:hover {
    color: #0d6efd;
}

.breadcrumb-item.active {
    color: #0d6efd;
    font-weight: 600;
}

.blog-title {
    font-size: 2rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.5rem;
}

.blog-subtitle {
    color: #6b7280;
    font-size: 1rem;
    margin: 0;
}

/* Main Content */
.blog-main {
    padding: 2rem 0;
}

/* Featured Post */
.featured-post {
    background: #1f2937;
    border-radius: 1rem;
    overflow: hidden;
    color: white;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    align-items: center;
    padding: 2rem;
}

.featured-image {
    position: relative;
    border-radius: 0.5rem;
    overflow: hidden;
    height: 300px;
}

.featured-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.placeholder-image {
    width: 100%;
    height: 100%;
    background: #374151;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #9ca3af;
}

.featured-content {}

.featured-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: #0d6efd;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.featured-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 1rem;
    line-height: 1.3;
}

.featured-excerpt {
    color: #d1d5db;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

/* Section Header */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e5e7eb;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin: 0;
}

.view-toggle {
    display: flex;
    gap: 0.5rem;
}

.toggle-btn {
    width: 36px;
    height: 36px;
    border: 2px solid #e5e7eb;
    background: white;
    color: #6b7280;
    border-radius: 0.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.toggle-btn:hover {
    color: #0d6efd;
    border-color: #0d6efd;
}

.toggle-btn.active {
    background: #0d6efd;
    color: white;
    border-color: #0d6efd;
}

/* Articles Grid */
.articles-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
    margin-bottom: 3rem;
}

.article-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.article-card:hover {
    border-color: #0d6efd;
    box-shadow: 0 10px 30px rgba(13, 110, 253, 0.15);
    transform: translateY(-4px);
}

.article-image {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: #f3f4f6;
}

.article-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.article-card:hover .article-image img {
    transform: scale(1.05);
}

.badge-new {
    position: absolute;
    top: 12px;
    right: 12px;
    background: #10b981;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 700;
}

.article-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.article-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.75rem;
    font-size: 0.85rem;
}

.article-category {
    background: #e0e7ff;
    color: #4f46e5;
    padding: 0.25rem 0.75rem;
    border-radius: 0.25rem;
    font-weight: 600;
}

.article-date {
    color: #9ca3af;
}

.article-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.article-title a {
    color: inherit;
    text-decoration: none;
    transition: color 0.2s;
}

.article-title a:hover {
    color: #0d6efd;
}

.article-excerpt {
    color: #6b7280;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    flex: 1;
    line-height: 1.5;
}

.article-footer {
    margin-top: auto;
}

.read-more {
    color: #0d6efd;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: gap 0.2s;
}

.read-more:hover {
    gap: 0.75rem;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid #e5e7eb;
}

.pagination {
    display: flex;
    gap: 0.5rem;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination li {
    display: flex;
}

.pagination a,
.pagination span {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    color: #111827;
    text-decoration: none;
    transition: all 0.2s;
    font-weight: 500;
}

.pagination a:hover {
    background: #0d6efd;
    color: white;
    border-color: #0d6efd;
}

.pagination .active span {
    background: #0d6efd;
    color: white;
    border-color: #0d6efd;
}

.pagination .disabled span {
    color: #d1d5db;
    cursor: not-allowed;
}

/* Sidebar */
.sidebar-widget {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.widget-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 1rem 0;
}

.widget-description {
    color: #6b7280;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

/* Search Widget */
.search-widget {
    position: relative;
}

.search-widget .form-control {
    padding-right: 40px;
}

.search-btn {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    transition: color 0.2s;
}

.search-btn:hover {
    color: #0d6efd;
}

/* Categories List */
.categories-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.categories-list li {
    border-bottom: 1px solid #f3f4f6;
}

.categories-list li:last-child {
    border-bottom: none;
}

.categories-list a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    color: #6b7280;
    text-decoration: none;
    transition: color 0.2s;
}

.categories-list a:hover {
    color: #0d6efd;
}

.categories-list .count {
    background: #f3f4f6;
    color: #6b7280;
    padding: 0.25rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.85rem;
    font-weight: 600;
}

/* Tags List */
.tags-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.tag {
    background: #f3f4f6;
    color: #6b7280;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.2s;
    border: 1px solid transparent;
}

.tag:hover {
    background: #e0e7ff;
    color: #4f46e5;
    border-color: #4f46e5;
}

/* Newsletter Widget */
.newsletter-widget {
    background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
    color: white;
    border: none;
    text-align: center;
}

.newsletter-widget .widget-title {
    color: white;
}

.newsletter-widget .widget-description {
    color: rgba(255, 255, 255, 0.9);
}

.newsletter-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.newsletter-form {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.newsletter-form .form-control {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
}

.newsletter-form .form-control::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.newsletter-form .form-control:focus {
    background: rgba(255, 255, 255, 0.25);
    border-color: white;
    color: white;
    box-shadow: none;
}

.newsletter-form .btn {
    background: white;
    color: #0d6efd;
    font-weight: 600;
}

.newsletter-form .btn:hover {
    background: #f0f0f0;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    color: #111827;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #6b7280;
}

/* Responsive */
@media (max-width: 1024px) {
    .articles-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .featured-post {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .featured-image {
        height: 250px;
    }

    .blog-title {
        font-size: 1.5rem;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .view-toggle {
        align-self: flex-end;
    }
}

@media (max-width: 576px) {
    .blog-header {
        padding: 2rem 1rem;
    }

    .blog-title {
        font-size: 1.25rem;
    }

    .featured-post {
        padding: 1.5rem;
    }

    .featured-title {
        font-size: 1.25rem;
    }

    .section-title {
        font-size: 1.25rem;
    }

    .articles-grid {
        gap: 1.5rem;
    }

    .article-image {
        height: 150px;
    }
}
</style>

@endsection
