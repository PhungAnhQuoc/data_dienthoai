<!-- Product Card Component -->
<div class="product-card animate-fade-in-up">
    <!-- Product Image -->
    <div class="product-image-wrapper">
        <?php if($product->main_image): ?>
            <img src="<?php echo e(asset('storage/' . $product->main_image)); ?>" 
                 alt="<?php echo e($product->name); ?>"
                 loading="lazy"
                 class="product-image">
        <?php elseif($product->images->count() > 0): ?>
            <img src="<?php echo e(asset('storage/' . $product->images->first()->image_url)); ?>" 
                 alt="<?php echo e($product->name); ?>"
                 loading="lazy"
                 class="product-image">
        <?php else: ?>
            <div class="d-flex align-items-center justify-content-center w-100 h-100 bg-light">
                <div class="text-center">
                    <i class="bi bi-image" style="font-size: 3rem; color: #d1d5db;"></i>
                    <p class="text-muted mt-2 mb-0">No Image</p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Badges -->
        <?php if($product->sale_price): ?>
            <span class="product-badge product-badge-sale">
                -<?php echo e(round((($product->price - $product->sale_price) / $product->price) * 100)); ?>%
            </span>
        <?php endif; ?>

        <?php if($product->is_new): ?>
            <span class="product-badge product-badge-new">Mới</span>
        <?php endif; ?>

        <!-- Quick Action Buttons -->
        <div class="product-quick-actions">
            <button type="button" 
                    class="quick-action-btn wishlist-btn" 
                    title="Thêm vào yêu thích"
                    onclick="toggleWishlist(<?php echo e($product->id); ?>)">
                <i class="bi bi-heart"></i>
            </button>
            <button type="button" 
                    class="quick-action-btn add-to-cart-btn"
                    onclick="addToCart(<?php echo e($product->id); ?>)">
                <i class="bi bi-cart-plus me-1"></i> Thêm
            </button>
        </div>
    </div>

    <!-- Product Info -->
    <div class="product-info">
        <!-- Brand -->
        <?php if($product->brand): ?>
            <p class="product-brand"><?php echo e($product->brand->name); ?></p>
        <?php endif; ?>

        <!-- Product Name -->
        <h6 class="product-name" title="<?php echo e($product->name); ?>">
            <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="text-decoration-none text-dark">
                <?php echo e($product->name); ?>

            </a>
        </h6>

        <!-- Rating Stars -->
        <div class="product-rating">
            <?php
                $rating = round($product->reviews()->where('is_approved', true)->avg('rating') ?? 0);
                $reviewCount = $product->reviews()->where('is_approved', true)->count();
            ?>

            <?php for($i = 1; $i <= 5; $i++): ?>
                <?php if($i <= $rating): ?>
                    <i class="bi bi-star-fill star-icon"></i>
                <?php else: ?>
                    <i class="bi bi-star star-icon empty"></i>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if($reviewCount > 0): ?>
                <span class="rating-count">(<?php echo e($reviewCount); ?>)</span>
            <?php endif; ?>
        </div>

        <!-- Description -->
        <?php if($product->description): ?>
            <p class="product-description"><?php echo e(Str::limit($product->description, 50)); ?></p>
        <?php endif; ?>

        <!-- Price -->
        <div class="product-price">
            <?php if($product->sale_price): ?>
                <span class="product-price-current">
                    <?php echo e(number_format($product->sale_price, 0, ',', '.')); ?>₫
                </span>
                <span class="product-price-original">
                    <?php echo e(number_format($product->price, 0, ',', '.')); ?>₫
                </span>
            <?php else: ?>
                <span class="product-price-current">
                    <?php echo e(number_format($product->price, 0, ',', '.')); ?>₫
                </span>
            <?php endif; ?>
        </div>

        <!-- Stock Status -->
        <?php if($product->stock > 0): ?>
            <small class="text-success">
                <i class="bi bi-check-circle-fill"></i> Còn hàng
            </small>
        <?php else: ?>
            <small class="text-danger">
                <i class="bi bi-x-circle-fill"></i> Hết hàng
            </small>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/partials/product-card.blade.php ENDPATH**/ ?>