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
            <!-- Post Info Card -->
            <div class="card mb-4">
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

            <!-- Suggested Products -->
            @if($suggestedProducts->count() > 0)
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="bi bi-star me-2"></i>Sản phẩm gợi ý
                    </h6>
                </div>
                <div class="card-body p-0">
                    @foreach($suggestedProducts as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                        <div class="d-flex gap-3 p-3 border-bottom hover-effect" style="transition: background 0.3s; cursor: pointer;">
                            <div style="width: 80px; height: 80px; flex-shrink: 0; background: #f5f5f5; border-radius: 8px; overflow: hidden;">
                                @if($product->main_image)
                                    <img src="{{ asset('storage/' . $product->main_image) }}" 
                                         alt="{{ $product->name }}"
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <h6 class="mb-1 text-dark" style="font-size: 0.95rem; line-height: 1.2;">
                                    {{ Str::limit($product->name, 45) }}
                                </h6>
                                <div class="mb-1">
                                    @if($product->sale_price > 0)
                                        <span class="fw-bold text-danger">{{ number_format($product->sale_price, 0, ',', '.') }}₫</span>
                                        <small class="text-muted text-decoration-line-through">{{ number_format($product->price, 0, ',', '.') }}₫</small>
                                    @else
                                        <span class="fw-bold text-primary">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                    @endif
                                </div>
                                <small class="text-muted">
                                    @if($product->stock > 0)
                                        <span class="badge bg-success">Còn hàng</span>
                                    @else
                                        <span class="badge bg-danger">Hết hàng</span>
                                    @endif
                                </small>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                <div class="card-footer bg-light">
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-arrow-right me-2"></i>Xem tất cả sản phẩm
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
