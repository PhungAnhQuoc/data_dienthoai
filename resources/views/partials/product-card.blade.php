<!-- Product Card Component -->
<div class="product-card animate-fade-in-up">
    <!-- Product Image -->
    <div class="product-image-wrapper">
        @if($product->main_image)
            <img src="{{ asset('storage/' . $product->main_image) }}" 
                 alt="{{ $product->name }}"
                 loading="lazy"
                 class="product-image">
        @elseif($product->images->count() > 0)
            <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                 alt="{{ $product->name }}"
                 loading="lazy"
                 class="product-image">
        @else
            <div class="d-flex align-items-center justify-content-center w-100 h-100 bg-light">
                <div class="text-center">
                    <i class="bi bi-image" style="font-size: 3rem; color: #d1d5db;"></i>
                    <p class="text-muted mt-2 mb-0">No Image</p>
                </div>
            </div>
        @endif

        <!-- Badges -->
        @if($product->sale_price)
            <span class="product-badge product-badge-sale">
                -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
            </span>
        @endif

        @if($product->is_new)
            <span class="product-badge product-badge-new">Mới</span>
        @endif

        <!-- Quick Action Buttons -->
        <div class="product-quick-actions">
            <button type="button" 
                    class="quick-action-btn wishlist-btn" 
                    title="Thêm vào yêu thích"
                    onclick="toggleWishlist({{ $product->id }})">
                <i class="bi bi-heart"></i>
            </button>
            <button type="button" 
                    class="quick-action-btn add-to-cart-btn"
                    onclick="addToCart({{ $product->id }})">
                <i class="bi bi-cart-plus me-1"></i> Thêm
            </button>
        </div>
    </div>

    <!-- Product Info -->
    <div class="product-info">
        <!-- Brand -->
        @if($product->brand)
            <p class="product-brand">{{ $product->brand->name }}</p>
        @endif

        <!-- Product Name -->
        <h6 class="product-name" title="{{ $product->name }}">
            <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">
                {{ $product->name }}
            </a>
        </h6>

        <!-- Rating Stars -->
        <div class="product-rating">
            @php
                $rating = round($product->reviews()->where('is_approved', true)->avg('rating') ?? 0);
                $reviewCount = $product->reviews()->where('is_approved', true)->count();
            @endphp

            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $rating)
                    <i class="bi bi-star-fill star-icon"></i>
                @else
                    <i class="bi bi-star star-icon empty"></i>
                @endif
            @endfor

            @if($reviewCount > 0)
                <span class="rating-count">({{ $reviewCount }})</span>
            @endif
        </div>

        <!-- Description -->
        @if($product->description)
            <p class="product-description">{{ Str::limit($product->description, 50) }}</p>
        @endif

        <!-- Price -->
        <div class="product-price">
            @if($product->sale_price)
                <span class="product-price-current">
                    {{ number_format($product->sale_price, 0, ',', '.') }}₫
                </span>
                <span class="product-price-original">
                    {{ number_format($product->price, 0, ',', '.') }}₫
                </span>
            @else
                <span class="product-price-current">
                    {{ number_format($product->price, 0, ',', '.') }}₫
                </span>
            @endif
        </div>

        <!-- Stock Status -->
        @if($product->stock > 0)
            <small class="text-success">
                <i class="bi bi-check-circle-fill"></i> Còn hàng
            </small>
        @else
            <small class="text-danger">
                <i class="bi bi-x-circle-fill"></i> Hết hàng
            </small>
        @endif
    </div>
</div>
