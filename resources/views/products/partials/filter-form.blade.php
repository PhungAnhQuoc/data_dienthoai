<!-- Search -->
<div class="mb-4">
    <label class="form-label fw-bold">Tìm kiếm</label>
    <input type="text" 
           class="form-control rounded-3" 
           name="search" 
           value="{{ request('search') }}"
           placeholder="Tên sản phẩm, SKU...">
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
    <label class="form-label fw-bold">Khoảng giá (₫)</label>
    <div class="row g-2">
        <div class="col-6">
            <input type="number" 
                   class="form-control form-control-sm" 
                   name="price_from" 
                   value="{{ request('price_from') }}"
                   placeholder="Từ"
                   min="0">
        </div>
        <div class="col-6">
            <input type="number" 
                   class="form-control form-control-sm" 
                   name="price_to" 
                   value="{{ request('price_to') }}"
                   placeholder="Đến"
                   min="0">
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
            <span style="color: #FFC107;">★★★★</span><span style="color: #ddd;">★</span> 4+ sao
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
            <span style="color: #FFC107;">★★★</span><span style="color: #ddd;">★★</span> 3+ sao
        </label>
    </div>
</div>

<hr>

<!-- Sort -->
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
