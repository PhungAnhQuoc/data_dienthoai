@extends('layouts.app')

@section('title', 'Trang chủ - MobileShop')

@section('content')
<!-- Flash Sale Modal -->
@include('partials.flash-sale-modal')

<!-- Flash Sale Promo Banner -->
@include('partials.flash-sale-promo')

<!-- Hero Banner -->
<section class="hero-section mb-5">
    <div class="hero-banner position-relative overflow-hidden rounded-4" style="height: 550px; min-height: 400px;">
        @if($banners->count() > 0)
        <div id="heroBanner" class="carousel slide carousel-fade h-100" data-bs-ride="carousel" data-bs-interval="6000">
            <div class="carousel-indicators position-absolute bottom-0 start-50 translate-middle-x mb-4">
                @foreach($banners as $index => $banner)
                <button type="button" data-bs-target="#heroBanner" data-bs-slide-to="{{ $index }}" 
                        class="rounded-pill {{ $index == 0 ? 'active' : '' }}" 
                        style="width: 14px; height: 14px; background-color: rgba(255,255,255,0.6); border: 2px solid white; transition: all 0.3s ease;"
                        aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner h-100">
                @foreach($banners as $index => $banner)
                <div class="carousel-item h-100 {{ $index == 0 ? 'active' : '' }} position-relative">
                    @if($banner->image)
                    <img src="{{ asset('storage/' . $banner->image) }}" 
                         class="d-block w-100 h-100 banner-image" 
                         alt="{{ $banner->title }}"
                         style="object-fit: cover;">
                    @else
                    <div class="w-100 h-100 banner-placeholder" 
                         style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                    @endif
                    <!-- Dark overlay for text readability -->
                    <div class="position-absolute top-0 start-0 w-100 h-100 banner-overlay"></div>
                    <div class="carousel-caption d-flex align-items-center justify-content-center h-100">
                        <div class="text-center banner-content px-4">
                            <h1 class="display-3 fw-bold mb-3 text-white banner-title">{{ $banner->title }}</h1>
                            <p class="fs-5 text-white-50 mb-4 banner-description" style="font-weight: 300;">{{ $banner->description }}</p>
                            @if($banner->link)
                            <a href="{{ $banner->link }}" class="btn btn-primary btn-lg px-5 fw-bold banner-btn">Khám Phá Ngay</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @if($banners->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#heroBanner" data-bs-slide="prev">
                <span class="carousel-control-prev-icon fs-4"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroBanner" data-bs-slide="next">
                <span class="carousel-control-next-icon fs-4"></span>
            </button>
            @endif
        </div>
        @else
        <div class="w-100 h-100 d-flex align-items-center justify-content-center position-relative overflow-hidden rounded-4"
             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 400px;">
            <div class="position-absolute banner-overlay"></div>
            <div class="text-center text-white position-relative z-2">
                <h1 class="display-3 fw-bold mb-3">Chào mừng tới MobileShop</h1>
                <p class="fs-5 mb-4" style="font-weight: 300;">Khám phá bộ sưu tập điện thoại mới nhất</p>
                <a href="{{ route('products.index') }}" class="btn btn-light btn-lg px-5 fw-bold">Mua Sắm Ngay</a>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- FLASH SALES SECTION -->
<section class="flash-sales-section mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-lightning-fill text-danger me-2"></i>Flash Sale - Giá Sốc
            </h2>
            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#flashSaleModal">Xem tất cả</button>
        </div>
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, rgba(255, 107, 107, 0.08) 0%, rgba(255, 142, 114, 0.08) 100%); border-radius: 12px;">
            <div class="card-body p-4">
                <div class="flash-sales-grid" id="homeFlashSalesGrid">
                    <div class="text-center py-5">
                        <div class="spinner-border text-danger" role="status">
                            <span class="visually-hidden">Đang tải...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Promotions -->
@if($promotions->count() > 0)
<section class="promotions-section mb-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Ưu đãi độc quyền chi dành cho bạn</h2>
        <div class="row g-4">
            @foreach($promotions as $promotion)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="badge bg-primary mb-2">{{ $promotion->code }}</div>
                        <h5 class="card-title">{{ $promotion->title }}</h5>
                        <p class="text-muted small">{{ $promotion->description }}</p>
                        <div class="fw-bold text-primary">
                            @if($promotion->discount_value > 0)
                                @if($promotion->discount_type === 'percentage')
                                    Giảm: <span class="text-dark">{{ intval($promotion->discount_value) }}%</span>
                                @else
                                    Giảm: <span class="text-dark">{{ number_format($promotion->discount_value, 0, ',', '.') }}đ</span>
                                @endif
                            @else
                                {{ $promotion->title }}
                            @endif
                        </div>
                        <p class="text-muted small mt-2">
                            Từ {{ $promotion->start_date->format('d/m/Y') }} đến {{ $promotion->end_date->format('d/m/Y') }}
                        </p>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="copyCode(this, '{{ $promotion->code }}')">
                            <i class="bi bi-clipboard"></i> Sao chép mã
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<section class="products-section mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-star-fill text-warning me-2"></i>Sản phẩm nổi bật
            </h2>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
        </div>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                @include('partials.product-card')
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- NEW PRODUCTS -->
@if($newProducts->count() > 0)
<section class="products-section mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-lightning-fill text-success me-2"></i>Sản phẩm mới
            </h2>
            <a href="{{ route('products.index', ['filter' => 'new']) }}" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
        </div>
        <div class="row g-4">
            @foreach($newProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                @include('partials.product-card')
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- BESTSELLER PRODUCTS -->
@if($bestsellerProducts->count() > 0)
<section class="products-section mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-fire text-danger me-2"></i>Sản phẩm bán chạy
            </h2>
            <a href="{{ route('products.index', ['filter' => 'bestseller']) }}" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
        </div>
        <div class="row g-4">
            @foreach($bestsellerProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                @include('partials.product-card')
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ACCESSORIES SECTION -->
@if($accessories->count() > 0)
<section class="products-section mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-box-fill text-info me-2"></i>Phụ kiện
            </h2>
            <a href="{{ route('products.index', ['category' => 'phu-kien']) }}" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
        </div>
        <div class="row g-4">
            @foreach($accessories as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                @include('partials.product-card')
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Blog Posts -->
@if($blogPosts->count() > 0)
<section class="blog-section mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-newspaper text-info me-2"></i>Tin tức nổi bật
            </h2>
            <a href="{{ route('blog.index') }}" class="btn btn-outline-primary btn-sm">Xem thêm</a>
        </div>
        <div class="row g-4">
            @foreach($blogPosts as $post)
            <div class="col-md-4">
                <a href="{{ route('blog.show', $post->slug) }}" class="card blog-card border-0 shadow-sm h-100 text-decoration-none text-reset d-block">
                    @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                         class="card-img-top" 
                         alt="{{ $post->title }}"
                         style="height: 200px; object-fit: cover;">
                    @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-image" style="font-size: 2rem; color: #d1d5db;"></i>
                    </div>
                    @endif
                    <div class="card-body">
                        <div class="badge bg-light text-dark mb-2">
                            {{ $post->published_at->format('d tháng m, Y') }}
                        </div>
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($post->excerpt, 100) }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Brand Categories -->
@if($brands->count() > 0)
<section class="brands-section mb-5 py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">
            <i class="bi bi-shop me-2"></i>Thương hiệu hàng đầu
        </h2>
        <div class="row g-4">
            @foreach($brands as $brand)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                <a href="{{ route('products.index', ['brand' => $brand->slug]) }}" class="brand-card card border-0 shadow-sm h-100 text-decoration-none text-dark text-center">
                    <div class="card-body d-flex align-items-center justify-content-center" style="min-height: 120px; padding: 2rem 1rem;">
                        @if($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" 
                                 alt="{{ $brand->name }}"
                                 class="img-fluid"
                                 style="max-height: 60px; object-fit: contain;">
                        @else
                            <span class="fw-bold text-center fs-5">{{ $brand->name }}</span>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Blog Posts -->
@if($blogPosts->count() > 0)
<section class="blog-section mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Tin tức nổi bật</h2>
            <a href="{{ route('blog.index') }}" class="text-primary text-decoration-none">Xem thêm</a>
        </div>
        <div class="row g-4">
            @foreach($blogPosts as $post)
            <div class="col-md-4">
                <a href="{{ route('blog.show', $post->slug) }}" class="card blog-card border-0 shadow-sm h-100 text-decoration-none text-reset d-block">
                    @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                         class="card-img-top" 
                         alt="{{ $post->title }}"
                         style="height: 200px; object-fit: cover;">
                    @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <span class="text-muted">Không có ảnh</span>
                    </div>
                    @endif
                    <div class="card-body">
                        <div class="badge bg-light text-dark mb-2">
                            {{ $post->published_at->format('d tháng m, Y') }}
                        </div>
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($post->excerpt, 100) }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Category Tiles + Footer Preview (from design) -->
<section class="categories-preview mb-5">
    <div class="container">
        <h3 class="text-center fw-bold mb-4">Mua sắp theo danh mục</h3>
        <div class="row g-4">
            @if(count($categories) > 0)
                @foreach($categories as $category)
                <div class="col-md-3">
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="card text-decoration-none overflow-hidden rounded-3 shadow-sm">
                        @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top" alt="{{ $category->name }}" style="height:140px; object-fit:cover;">
                        @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:140px;">
                            <span class="text-muted">{{ $category->name }}</span>
                        </div>
                        @endif
                        <div class="card-body text-center py-3">
                            <strong class="text-dark">{{ $category->name }}</strong>
                        </div>
                    </a>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function copyCode(btn, code) {
    // Copy to clipboard
    navigator.clipboard.writeText(code).then(() => {
        // Show notification
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check"></i> Đã sao chép!';
        btn.disabled = true;
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 2000);
    }).catch(() => {
        // Fallback for older browsers
        const textarea = document.createElement('textarea');
        textarea.value = code;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        
        btn.innerHTML = '<i class="bi bi-check"></i> Đã sao chép!';
        btn.disabled = true;
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 2000);
    });
}
</script>
@endpush
