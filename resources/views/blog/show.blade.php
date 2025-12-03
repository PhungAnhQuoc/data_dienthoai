@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <article>
                @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                     class="img-fluid rounded mb-4" 
                     alt="{{ $post->title }}"
                     style="max-height: 500px; object-fit: cover; width: 100%;">
                @endif
                
                <h1 class="mb-3">{{ $post->title }}</h1>
                
                <div class="text-muted mb-4">
                    <small>Đăng ngày: {{ $post->published_at->format('d/m/Y H:i') }}</small>
                </div>
                
                <div class="post-content">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </article>

            <!-- Related Posts -->
            @if($relatedPosts->count() > 0)
            <hr class="my-5">
            <h3 class="mb-4">Bài viết liên quan</h3>
            <div class="row">
                @foreach($relatedPosts as $related)
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        @if($related->featured_image)
                        <img src="{{ asset('storage/' . $related->featured_image) }}" 
                             class="card-img-top" 
                             alt="{{ $related->title }}"
                             style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h6 class="card-title">{{ $related->title }}</h6>
                            <small class="text-muted">{{ $related->published_at->format('d/m/Y') }}</small>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <a href="{{ route('blog.show', $related->slug) }}" class="btn btn-sm btn-outline-primary">
                                Đọc thêm
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Thông tin bài viết</h6>
                </div>
                <div class="card-body">
                    <p><strong>Trạng thái:</strong> 
                        @if($post->is_active)
                            <span class="badge bg-success">Đang hoạt động</span>
                        @else
                            <span class="badge bg-danger">Không hoạt động</span>
                        @endif
                    </p>
                    <p><strong>Ngày tạo:</strong> {{ $post->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Cập nhật:</strong> {{ $post->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
