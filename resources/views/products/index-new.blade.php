@extends('layouts.app')

@section('title', 'Sản phẩm - MobileShop')

@section('content')
<div class="container py-4">
    <div class="row g-3 g-lg-4">
        <!-- Sidebar Filter - Hidden on mobile, sticky on desktop -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            <button class="btn btn-primary w-100 d-lg-none mb-3" 
                    data-bs-toggle="offcanvas" 
                    data-bs-target="#filterOffcanvas"
                    aria-controls="filterOffcanvas">
                <i class="bi bi-funnel me-2"></i>Bộ lọc
            </button>

            <!-- Filter Offcanvas for Mobile -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Bộ lọc</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body p-0">
                    <filterContent></filterContent>
                </div>
            </div>

            <!-- Filter Sidebar for Desktop -->
            <div class="d-none d-lg-block">
                <filterContent></filterContent>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
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
                    <div class="col-12 col-sm-6 text-sm-end">
                        <small class="text-muted">Tìm thấy {{ $products->total() }} sản phẩm</small>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-funnel me-2"></i>Bộ lọc
                    </h5>

                    <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                        <!-- Search -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tìm kiếm</label>
                            <input type="text" 
                                   class="form-control rounded-3" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Tên sản phẩm...">
                        </div>

                        <hr>

                        <!-- Categories -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Danh mục</label>
                            <div class="list-group list-group-flush">
                                <a href="{{ route('products.index') }}" 
                                   class="list-group-item list-group-item-action border-0 {{ !request('category') ? 'active bg-primary text-white' : '' }}">
                                    Tất cả
                                </a>
                                @foreach($categories as $category)
                                <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                                   class="list-group-item list-group-item-action border-0 {{ request('category') == $category->slug ? 'active bg-primary text-white' : '' }}">
                                    {{ $category->name }}
                                </a>
                                @endforeach
                            </div>
                        </div>

                        <hr>

                        <!-- Brands -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Thương hiệu</label>
                            @foreach($brands as $brand)
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="brand" 
                                       value="{{ $brand->slug }}"
                                       id="brand_{{ $brand->id }}"
                                       {{ request('brand') == $brand->slug ? 'checked' : '' }}>
                                <label class="form-check-label" for="brand_{{ $brand->id }}">
                                    {{ $brand->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <hr>

                        <!-- Price Range -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Giá (₫)</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" 
                                           class="form-control form-control-sm" 
                                           name="price_from" 
                                           value="{{ request('price_from') }}"
                                           placeholder="Từ">
                                </div>
                                <div class="col-6">
                                    <input type="number" 
                                           class="form-control form-control-sm" 
                                           name="price_to" 
                                           value="{{ request('price_to') }}"
                                           placeholder="Đến">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Status Filter -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="status" 
                                       value=""
                                       id="status_all"
                                       {{ !request('status') ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_all">
                                    Tất cả
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="status" 
                                       value="featured"
                                       id="status_featured"
                                       {{ request('status') == 'featured' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_featured">
                                    <span class="badge bg-warning">Nổi bật</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="status" 
                                       value="bestseller"
                                       id="status_bestseller"
                                       {{ request('status') == 'bestseller' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_bestseller">
                                    <span class="badge bg-danger">Bán chạy</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="status" 
                                       value="sale"
                                       id="status_sale"
                                       {{ request('status') == 'sale' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_sale">
                                    <span class="badge bg-success">Giảm giá</span>
                                </label>
                            </div>
                        </div>

                        <hr>

                        <!-- Rating Filter -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Đánh giá</label>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="min_rating" 
                                       value=""
                                       id="rating_all"
                                       {{ !request('min_rating') ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating_all">
                                    Tất cả
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="min_rating" 
                                       value="4"
                                       id="rating_4"
                                       {{ request('min_rating') == '4' ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating_4">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star text-muted"></i> 4+ sao
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="min_rating" 
                                       value="3"
                                       id="rating_3"
                                       {{ request('min_rating') == '3' ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating_3">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star text-muted"></i>
                                    <i class="bi bi-star text-muted"></i> 3+ sao
                                </label>
                            </div>
                        </div>

                        <hr>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Sắp xếp</label>
                            <select class="form-select form-select-sm rounded-3" name="sort">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Giá: Thấp - Cao</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Giá: Cao - Thấp</option>
                                <option value="bestseller" {{ request('sort') == 'bestseller' ? 'selected' : '' }}>Bán chạy</option>
                                <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Nổi bật</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-sm rounded-3">
                                <i class="bi bi-search me-2"></i>Áp dụng bộ lọc
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm rounded-3">
                                <i class="bi bi-arrow-clockwise me-2"></i>Đặt lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Results Header -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold mb-0">
                        Sản phẩm
                        @if(request('search'))
                            <span class="text-muted">- Kết quả: "{{ request('search') }}"</span>
                        @endif
                    </h4>
                    <small class="text-muted">Tìm thấy {{ $products->total() }} sản phẩm</small>
                </div>
            </div>

            <!-- Products -->
            @if($products->count() > 0)
            <div class="row g-4 mb-5">
                @foreach($products as $product)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm product-card rounded-3 overflow-hidden">
                            <!-- Product Image -->
                            <div class="position-relative" style="height: 250px; overflow: hidden; background: #f8f9fa;">
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
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                </div>
                                @endif

                                <!-- Badges -->
                                <div class="position-absolute top-0 start-0 p-2">
                                    @if($product->is_featured)
                                    <span class="badge bg-warning me-2">
                                        <i class="bi bi-star me-1"></i>Nổi bật
                                    </span>
                                    @endif
                                    @if($product->is_bestseller)
                                    <span class="badge bg-danger me-2">
                                        <i class="bi bi-fire me-1"></i>Bán chạy
                                    </span>
                                    @endif
                                    @if($product->sale_price)
                                    <span class="badge bg-success">
                                        -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="card-body">
                                <h6 class="card-title fw-bold text-dark mb-2 text-truncate">
                                    {{ $product->name }}
                                </h6>
                                <p class="text-muted small mb-3">
                                    {{ $product->category->name ?? 'N/A' }}
                                </p>

                                <!-- Price -->
                                <div class="mb-3">
                                    @if($product->sale_price)
                                        <span class="h5 text-danger fw-bold me-2">
                                            {{ number_format($product->sale_price, 0, ',', '.') }}₫
                                        </span>
                                        <span class="text-muted text-decoration-line-through small">
                                            {{ number_format($product->price, 0, ',', '.') }}₫
                                        </span>
                                    @else
                                        <span class="h5 text-primary fw-bold">
                                            {{ number_format($product->price, 0, ',', '.') }}₫
                                        </span>
                                    @endif
                                </div>

                                <!-- Stock Status -->
                                <small class="text-muted">
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
            <div class="d-flex justify-content-center">
                {{ $products->links('pagination::custom') }}
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
</style>
@endsection
