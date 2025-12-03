@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-4">Tin Tức & Bài Viết</h1>
        </div>
    </div>

    <div class="row">
        @forelse($posts as $post)
            <div class="col-md-4 mb-4">
                <a href="{{ route('blog.show', $post->slug) }}" class="card blog-card h-100 shadow-sm text-decoration-none text-reset d-block">
                    @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                         class="card-img-top" 
                         alt="{{ $post->title }}"
                         style="height: 250px; object-fit: cover;">
                    @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <span class="text-muted">Không có ảnh</span>
                    </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($post->excerpt ?? $post->content, 100) }}</p>
                        <small class="text-secondary">{{ $post->published_at->format('d/m/Y') }}</small>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-md-12">
                <div class="alert alert-info">
                    Chưa có bài viết nào. Vui lòng quay lại sau!
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($posts instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="row mt-4">
        <div class="col-md-12 d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
