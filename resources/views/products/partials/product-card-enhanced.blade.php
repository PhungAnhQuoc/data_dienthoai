<!-- Enhanced Product Card Component -->
<div class="product-card-enhanced">
    <div class="position-relative overflow-hidden bg-light rounded-top" style="height: 300px;">
        <!-- Product Image -->
        <a href="{{ route('products.show', $product->slug) }}" class="d-block h-100">
            <img src="{{ asset('storage/' . $product->main_image) }}" 
                 alt="{{ $product->name }}"
                 class="w-100 h-100 object-fit-cover product-img">
        </a>

        <!-- Discount Badge -->
        @if($product->sale_price)
            <div class="position-absolute top-0 start-0 p-2">
                <span class="badge bg-danger" style="font-size: 13px; padding: 6px 10px;">
                    Giảm {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                </span>
            </div>
        @endif

        <!-- Installment Badge -->
        <div class="position-absolute top-0 end-0 p-2">
            <span class="badge bg-light text-dark" style="font-size: 11px; padding: 4px 8px;">
                Trả góp 0%
            </span>
        </div>

        <!-- Wishlist Button -->
        <div class="position-absolute bottom-0 end-0 p-3">
            <button class="btn btn-light btn-sm rounded-circle add-to-wishlist" 
                    data-product-id="{{ $product->id }}"
                    title="Thêm vào yêu thích">
                <i class="bi bi-heart" style="font-size: 18px; color: #dc3545;"></i>
            </button>
        </div>
    </div>

    <div class="p-3">
        <!-- Brand Name -->
        <p class="text-muted small mb-1" style="font-size: 12px;">{{ $product->brand->name }}</p>

        <!-- Product Name -->
        <h6 class="card-title mb-2" style="font-size: 14px; font-weight: 600;">
            <a href="{{ route('products.show', $product->slug) }}" 
               class="text-decoration-none text-dark text-truncate d-block">
                {{ Str::limit($product->name, 45) }}
            </a>
        </h6>

        <!-- Specifications (if available) -->
        @if($product->specifications)
            <div class="mb-2">
                <small class="text-muted" style="font-size: 11px;">
                    @foreach(array_slice((array)json_decode($product->specifications), 0, 2) as $key => $spec)
                        {{ $spec ?? '' }}{{ !$loop->last ? ' | ' : '' }}
                    @endforeach
                </small>
            </div>
        @endif

        <!-- Prices -->
        <div class="mb-2">
            @if($product->sale_price)
                <span class="text-decoration-line-through text-muted small d-block" style="font-size: 12px;">
                    {{ number_format($product->price, 0, ',', '.') }}₫
                </span>
                <h5 class="text-danger fw-bold mb-1" style="font-size: 16px;">
                    {{ number_format($product->sale_price, 0, ',', '.') }}₫
                </h5>
            @else
                <h5 class="text-danger fw-bold mb-1" style="font-size: 16px;">
                    {{ number_format($product->price, 0, ',', '.') }}₫
                </h5>
            @endif
        </div>

        <!-- Member Discount -->
        @if($product->sale_price)
            <div class="alert alert-light p-2 mb-2" style="font-size: 11px; background-color: #f0f4ff;">
                <i class="bi bi-person-check"></i> Smember giảm đến 
                <strong>{{ number_format(($product->price - $product->sale_price) * 0.1, 0, ',', '.') }}đ</strong>
            </div>
        @endif

        <!-- Installment Info -->
        <div class="mb-2" style="font-size: 11px; color: #ff6b35;">
            <i class="bi bi-credit-card"></i>
            Trả góp 0% - 0đ phụ thu - 0đ trả trước - kỳ hạn đến 6 tháng
        </div>

        <!-- Rating -->
        <div class="mb-3">
            <div class="text-warning small">
                @for ($i = 0; $i < 5; $i++)
                    <i class="bi bi-star-fill"></i>
                @endfor
                <span class="text-muted ms-1" style="font-size: 11px;">(5.0)</span>
            </div>
        </div>

        <!-- Add to Cart Button -->
        @if($product->stock > 0)
            <form action="{{ route('cart.add') }}" method="POST" class="d-inline w-100">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-primary btn-sm w-100" style="font-size: 12px;">
                    <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                </button>
            </form>
        @else
            <button class="btn btn-secondary btn-sm w-100" disabled style="font-size: 12px;">
                <i class="bi bi-x-circle"></i> Hết hàng
            </button>
        @endif
    </div>
</div>

<style>
.product-card-enhanced {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
    transition: box-shadow 0.3s ease, transform 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    background: white;
}

.product-card-enhanced:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    transform: translateY(-4px);
}

.product-card-enhanced .product-img {
    transition: transform 0.3s ease;
}

.product-card-enhanced:hover .product-img {
    transform: scale(1.05);
}

.product-card-enhanced > div:last-child {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.product-card-enhanced .card-title a {
    transition: color 0.2s ease;
}

.product-card-enhanced .card-title a:hover {
    color: #dc3545 !important;
}
</style>
