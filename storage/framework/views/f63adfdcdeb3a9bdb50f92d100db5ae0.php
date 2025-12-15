

<?php $__env->startSection('title', 'Sản phẩm - MobileShop'); ?>

<?php $__env->startSection('content'); ?>
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
                    <form action="<?php echo e(route('products.index')); ?>" method="GET" id="filterFormMobile">
                        <?php echo $__env->make('products.partials.filter-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
                        <form action="<?php echo e(route('products.index')); ?>" method="GET" id="filterForm">
                            <?php echo $__env->make('products.partials.filter-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
                            <?php if(request('search')): ?>
                                <span class="text-muted small">- "<?php echo e(request('search')); ?>"</span>
                            <?php endif; ?>
                        </h4>
                    </div>
                    <div class="col-12 col-sm-6">
                        <small class="text-muted">Tìm thấy <?php echo e($products->total()); ?> sản phẩm</small>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <?php if($products->count() > 0): ?>
            <div class="row g-3 g-sm-4 mb-5">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6 col-sm-6 col-lg-4">
                    <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="text-decoration-none text-dark">
                        <div class="card h-100 border-0 shadow-sm product-card rounded-3 overflow-hidden">
                            <!-- Product Image -->
                            <div class="position-relative" style="height: 180px; overflow: hidden; background: #f8f9fa;">
                                <?php if($product->main_image): ?>
                                <img src="<?php echo e(asset('storage/' . $product->main_image)); ?>" 
                                     class="card-img-top w-100 h-100" 
                                     alt="<?php echo e($product->name); ?>"
                                     style="object-fit: cover;">
                                <?php elseif($product->images->count() > 0): ?>
                                <img src="<?php echo e(asset('storage/' . $product->images->first()->image_url)); ?>" 
                                     class="card-img-top w-100 h-100" 
                                     alt="<?php echo e($product->name); ?>"
                                     style="object-fit: cover;">
                                <?php else: ?>
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                </div>
                                <?php endif; ?>

                                <!-- Badges -->
                                <div class="position-absolute top-0 start-0 p-2">
                                    <?php if($product->sale_price): ?>
                                    <span class="badge bg-danger d-block mb-1">
                                        -<?php echo e(round((($product->price - $product->sale_price) / $product->price) * 100)); ?>%
                                    </span>
                                    <?php endif; ?>
                                    <?php if($product->is_featured): ?>
                                    <span class="badge bg-warning d-block mb-1">
                                        <i class="bi bi-star-fill"></i> Nổi bật
                                    </span>
                                    <?php endif; ?>
                                    <?php if($product->is_bestseller): ?>
                                    <span class="badge bg-danger d-block">
                                        <i class="bi bi-fire"></i> Bán chạy
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="card-body p-2 p-sm-3">
                                <h6 class="card-title fw-bold text-dark mb-2 text-truncate small">
                                    <?php echo e($product->name); ?>

                                </h6>

                                <!-- Price -->
                                <div class="mb-2">
                                    <?php if($product->sale_price): ?>
                                        <span class="h6 text-danger fw-bold me-2">
                                            <?php echo e(number_format($product->sale_price, 0, ',', '.')); ?>₫
                                        </span>
                                        <span class="text-muted text-decoration-line-through small">
                                            <?php echo e(number_format($product->price, 0, ',', '.')); ?>₫
                                        </span>
                                    <?php else: ?>
                                        <span class="h6 text-primary fw-bold">
                                            <?php echo e(number_format($product->price, 0, ',', '.')); ?>₫
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Stock Status -->
                                <small>
                                    <?php if($product->stock > 0): ?>
                                        <span class="text-success">✓ Còn hàng</span>
                                    <?php else: ?>
                                        <span class="text-danger">✗ Hết hàng</span>
                                    <?php endif; ?>
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mb-4">
                <?php echo e($products->links('pagination::bootstrap-4')); ?>

            </div>
            <?php else: ?>
            <div class="alert alert-info text-center py-5">
                <i class="bi bi-search" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Không tìm thấy sản phẩm</h5>
                <p class="text-muted">Thử thay đổi tiêu chí tìm kiếm hoặc bộ lọc của bạn</p>
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary btn-sm mt-2">
                    <i class="bi bi-arrow-left me-2"></i>Xem tất cả sản phẩm
                </a>
            </div>
            <?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/products/index-new-responsive.blade.php ENDPATH**/ ?>