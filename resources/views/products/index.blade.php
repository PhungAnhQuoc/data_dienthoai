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
                    @include('products.partials.product-card-enhanced')
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