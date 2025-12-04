@extends('layouts.app')

@section('title', 'Sản phẩm - MobileShop')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Sidebar Filter -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Bộ lọc</h5>

                    <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                        <!-- Search -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tìm kiếm</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Nhập tên sản phẩm...">
                        </div>

                        <!-- Categories -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Danh mục</label>
                            <div class="list-group">
                                <a href="{{ route('products.index') }}" 
                                   class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">
                                    Tất cả
                                </a>
                                @foreach($categories as $category)
                                <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                                   class="list-group-item list-group-item-action {{ request('category') == $category->slug ? 'active' : '' }}">
                                    {{ $category->name }}
                                </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Brands -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Thương hiệu</label>
                            @foreach($brands as $brand)
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="brand[]" 
                                       value="{{ $brand->slug }}"
                                       id="brand{{ $brand->id }}"
                                       {{ in_array($brand->slug, (array)request('brand')) ? 'checked' : '' }}
                                       onchange="document.getElementById('filterForm').submit()">
                                <label class="form-check-label" for="brand{{ $brand->id }}">
                                    {{ $brand->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <!-- Price Range -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Khoảng giá</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" 
                                           class="form-control form-control-sm" 
                                           name="min_price"
                                           value="{{ request('min_price') }}"
                                           placeholder="Từ">
                                </div>
                                <div class="col-6">
                                    <input type="number" 
                                           class="form-control form-control-sm" 
                                           name="max_price"
                                           value="{{ request('max_price') }}"
                                           placeholder="Đến">
                                </div>
                            </div>
                        </div>

                        <!-- Special Filter -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Đặc biệt</label>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="filter" 
                                       value="featured"
                                       id="featured"
                                       {{ request('filter') == 'featured' ? 'checked' : '' }}
                                       onchange="document.getElementById('filterForm').submit()">
                                <label class="form-check-label" for="featured">
                                    Nổi bật
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="filter" 
                                       value="bestseller"
                                       id="bestseller"
                                       {{ request('filter') == 'bestseller' ? 'checked' : '' }}
                                       onchange="document.getElementById('filterForm').submit()">
                                <label class="form-check-label" for="bestseller">
                                    Bán chạy
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="filter" 
                                       value="new"
                                       id="new"
                                       {{ request('filter') == 'new' ? 'checked' : '' }}
                                       onchange="document.getElementById('filterForm').submit()">
                                <label class="form-check-label" for="new">
                                    Mới nhất
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="filter" 
                                       value="sale"
                                       id="sale"
                                       {{ request('filter') == 'sale' ? 'checked' : '' }}
                                       onchange="document.getElementById('filterForm').submit()">
                                <label class="form-check-label" for="sale">
                                    Giảm giá
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-funnel"></i> Áp dụng bộ lọc
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-x-circle"></i> Xóa bộ lọc
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Toolbar -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-0">
                        Tất cả sản phẩm 
                        <span class="text-muted">({{ $products->total() }} sản phẩm)</span>
                    </h4>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <label class="mb-0">Sắp xếp:</label>
                    <select class="form-select form-select-sm" 
                            style="width: auto;"
                            onchange="window.location.href=this.value">
                        <option value="{{ route('products.index', array_merge(request()->all(), ['sort' => 'latest'])) }}"
                                {{ request('sort') == 'latest' ? 'selected' : '' }}>
                            Mới nhất
                        </option>
                        <option value="{{ route('products.index', array_merge(request()->all(), ['sort' => 'price_asc'])) }}"
                                {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                            Giá thấp đến cao
                        </option>
                        <option value="{{ route('products.index', array_merge(request()->all(), ['sort' => 'price_desc'])) }}"
                                {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                            Giá cao đến thấp
                        </option>
                        <option value="{{ route('products.index', array_merge(request()->all(), ['sort' => 'name_asc'])) }}"
                                {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                            Tên A-Z
                        </option>
                    </select>
                </div>
            </div>

            <!-- Products -->
            @if($products->count() > 0)
            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="card product-card h-100 border-0 shadow-sm">
                        <div class="position-relative">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ asset('storage/' . $product->main_image) }}" 
                                     class="card-img-top" 
                                     alt="{{ $product->name }}"
                                     style="height: 250px; object-fit: cover;">
                            </a>
                            @if($product->sale_price)
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                            </span>
                            @endif
                            @if($product->is_new)
                            <span class="badge bg-success position-absolute top-0 start-0 m-2">Mới</span>
                            @endif

                            <!-- Quick Actions -->
                            <div class="position-absolute bottom-0 end-0 m-2">
                                <button class="btn btn-light btn-sm rounded-circle me-1" title="Yêu thích">
                                    <i class="bi bi-heart"></i>
                                </button>
                                <button class="btn btn-light btn-sm rounded-circle" title="Xem nhanh">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-1">{{ $product->brand->name }}</p>
                            <h6 class="card-title">
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ Str::limit($product->name, 50) }}
                                </a>
                            </h6>
                            
                            <!-- Rating -->
                            <div class="text-warning small mb-2">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="text-muted">(4.5)</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    @if($product->sale_price)
                                    <span class="text-decoration-line-through text-muted small d-block">
                                        {{ $product->formatted_price }}
                                    </span>
                                    <h5 class="text-primary fw-bold mb-0">{{ $product->formatted_sale_price }}</h5>
                                    @else
                                    <h5 class="text-primary fw-bold mb-0">{{ $product->formatted_price }}</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <div class="d-grid gap-2">
                                @if($product->stock > 0)
                                <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-secondary w-100" disabled>
                                    Hết hàng
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-5">
                {{ $products->links('pagination::custom') }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h5 class="mt-3">Không tìm thấy sản phẩm nào</h5>
                <p class="text-muted">Vui lòng thử lại với bộ lọc khác</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    Xem tất cả sản phẩm
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection