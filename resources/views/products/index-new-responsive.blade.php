@extends('layouts.app')

@section('title', 'Sản phẩm - MobileShop')

@section('content')
<div class="container py-4">
    <div class="row g-3 g-lg-4">
        <!-- Sidebar Filter -->
        <div class="col-12 col-lg-3">
            <!-- Mobile Filter Button -->
            <button class="btn btn-primary w-100 d-lg-none mb-3" 
                    data-bs-toggle="offcanvas" 
                    data-bs-target="#filterOffcanvas"
                    aria-controls="filterOffcanvas">
                <i class="bi bi-funnel me-2"></i>Bộ lọc
            </button>

            <!-- Filter Offcanvas for Mobile -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Bộ lọc sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body p-3">
                    <form action="{{ route('products.index') }}" method="GET" id="filterFormMobile">
                        @include('products.partials.filter-form')
                    </form>
                </div>
            </div>

            <!-- Filter Sidebar for Desktop -->
            <div class="d-none d-lg-block">
                <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-funnel me-2"></i>Bộ lọc
                        </h5>
                        <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                            @include('products.partials.filter-form')
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-12 col-lg-9">
            <!-- Results Header -->
            <div class="mb-4">
                <div class="row align-items-center">
                    <div class="col-12 col-sm-6">
                        <h4 class="fw-bold mb-2 mb-sm-0">
                            Sản phẩm
                            @if(request('search'))
                                <span class="text-muted small">- "{{ request('search') }}"</span>
                            @endif
                        </h4>
                    </div>
                    <div class="col-12 col-sm-6">
                        <small class="text-muted">Tìm thấy {{ $products->total() }} sản phẩm</small>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
            <div class="row g-3 g-sm-4 mb-5">
                @foreach($products as $product)
                <div class="col-6 col-sm-6 col-lg-4">
                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">
                        <div class="card h-100 border-0 shadow-sm product-card rounded-3 overflow-hidden">
                            <!-- Product Image -->
                            <div class="position-relative" style="height: 180px; overflow: hidden; background: #f8f9fa;">
                                @if($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" 
                                     class="card-img-top w-100 h-100" 
                                     alt="{{ $product->name }}"
                                     style="object-fit: cover;">
                                @elseif($product->images->count() > 0)
                                <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                                     class="card-img-top w-100 h-100" 
                                     alt="{{ $product->name }}"
                                     style="object-fit: cover;">
                                @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                </div>
                                @endif

                                <!-- Badges -->
                                <div class="position-absolute top-0 start-0 p-2">
                                    @if($product->sale_price)
                                    <span class="badge bg-danger d-block mb-1">
                                        -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                    </span>
                                    @endif
                                    @if($product->is_featured)
                                    <span class="badge bg-warning d-block mb-1">
                                        <i class="bi bi-star-fill"></i> Nổi bật
                                    </span>
                                    @endif
                                    @if($product->is_bestseller)
                                    <span class="badge bg-danger d-block">
                                        <i class="bi bi-fire"></i> Bán chạy
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="card-body p-2 p-sm-3">
                                <h6 class="card-title fw-bold text-dark mb-2 text-truncate small">
                                    {{ $product->name }}
                                </h6>

                                <!-- Price -->
                                <div class="mb-2">
                                    @if($product->sale_price)
                                        <span class="h6 text-danger fw-bold me-2">
                                            {{ number_format($product->sale_price, 0, ',', '.') }}₫
                                        </span>
                                        <span class="text-muted text-decoration-line-through small">
                                            {{ number_format($product->price, 0, ',', '.') }}₫
                                        </span>
                                    @else
                                        <span class="h6 text-primary fw-bold">
                                            {{ number_format($product->price, 0, ',', '.') }}₫
                                        </span>
                                    @endif
                                </div>

                                <!-- Stock Status -->
                                <small>
                                    @if($product->stock > 0)
                                        <span class="text-success">✓ Còn hàng</span>
                                    @else
                                        <span class="text-danger">✗ Hết hàng</span>
                                    @endif
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mb-4">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
            @else
            <div class="alert alert-info text-center py-5">
                <i class="bi bi-search" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Không tìm thấy sản phẩm</h5>
                <p class="text-muted">Thử thay đổi tiêu chí tìm kiếm hoặc bộ lọc của bạn</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm mt-2">
                    <i class="bi bi-arrow-left me-2"></i>Xem tất cả sản phẩm
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
}

.product-card img {
    transition: transform 0.3s ease;
}

.product-card:hover img {
    transform: scale(1.05);
}

/* Mobile optimizations */
@media (max-width: 576px) {
    .product-card {
        font-size: 0.875rem;
    }
    
    .product-card .card-body {
        padding: 0.5rem !important;
    }
}
</style>
@endsection
