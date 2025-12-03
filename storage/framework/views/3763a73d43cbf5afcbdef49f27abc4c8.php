

<?php $__env->startSection('title', 'Sản phẩm - MobileShop'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row">
        <!-- Sidebar Filter -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-funnel me-2"></i>Bộ lọc
                    </h5>

                    <form action="<?php echo e(route('products.index')); ?>" method="GET" id="filterForm">
                        <!-- Search -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tìm kiếm</label>
                            <input type="text" 
                                   class="form-control rounded-3" 
                                   name="search" 
                                   value="<?php echo e(request('search')); ?>"
                                   placeholder="Tên sản phẩm...">
                        </div>

                        <hr>

                        <!-- Categories -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Danh mục</label>
                            <div class="list-group list-group-flush">
                                <a href="<?php echo e(route('products.index')); ?>" 
                                   class="list-group-item list-group-item-action border-0 <?php echo e(!request('category') ? 'active bg-primary text-white' : ''); ?>">
                                    Tất cả
                                </a>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('products.index', ['category' => $category->slug])); ?>" 
                                   class="list-group-item list-group-item-action border-0 <?php echo e(request('category') == $category->slug ? 'active bg-primary text-white' : ''); ?>">
                                    <?php echo e($category->name); ?>

                                </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <hr>

                        <!-- Brands -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Thương hiệu</label>
                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="brand" 
                                       value="<?php echo e($brand->slug); ?>"
                                       id="brand_<?php echo e($brand->id); ?>"
                                       <?php echo e(request('brand') == $brand->slug ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="brand_<?php echo e($brand->id); ?>">
                                    <?php echo e($brand->name); ?>

                                </label>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                           value="<?php echo e(request('price_from')); ?>"
                                           placeholder="Từ">
                                </div>
                                <div class="col-6">
                                    <input type="number" 
                                           class="form-control form-control-sm" 
                                           name="price_to" 
                                           value="<?php echo e(request('price_to')); ?>"
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
                                       <?php echo e(!request('status') ? 'checked' : ''); ?>>
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
                                       <?php echo e(request('status') == 'featured' ? 'checked' : ''); ?>>
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
                                       <?php echo e(request('status') == 'bestseller' ? 'checked' : ''); ?>>
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
                                       <?php echo e(request('status') == 'sale' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="status_sale">
                                    <span class="badge bg-success">Giảm giá</span>
                                </label>
                            </div>
                        </div>

                        <hr>

                        <!-- Sort -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Sắp xếp</label>
                            <select class="form-select form-select-sm rounded-3" name="sort">
                                <option value="latest" <?php echo e(request('sort') == 'latest' ? 'selected' : ''); ?>>Mới nhất</option>
                                <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>Giá: Thấp - Cao</option>
                                <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>Giá: Cao - Thấp</option>
                                <option value="bestseller" <?php echo e(request('sort') == 'bestseller' ? 'selected' : ''); ?>>Bán chạy</option>
                                <option value="featured" <?php echo e(request('sort') == 'featured' ? 'selected' : ''); ?>>Nổi bật</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-sm rounded-3">
                                <i class="bi bi-search me-2"></i>Áp dụng bộ lọc
                            </button>
                            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-secondary btn-sm rounded-3">
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
                        <?php if(request('search')): ?>
                            <span class="text-muted">- Kết quả: "<?php echo e(request('search')); ?>"</span>
                        <?php endif; ?>
                    </h4>
                    <small class="text-muted">Tìm thấy <?php echo e($products->total()); ?> sản phẩm</small>
                </div>
            </div>

            <!-- Products -->
            <?php if($products->count() > 0): ?>
            <div class="row g-4 mb-5">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-4">
                    <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm product-card rounded-3 overflow-hidden">
                            <!-- Product Image -->
                            <div class="position-relative" style="height: 250px; overflow: hidden; background: #f8f9fa;">
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
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                </div>
                                <?php endif; ?>

                                <!-- Badges -->
                                <div class="position-absolute top-0 start-0 p-2">
                                    <?php if($product->is_featured): ?>
                                    <span class="badge bg-warning me-2">
                                        <i class="bi bi-star me-1"></i>Nổi bật
                                    </span>
                                    <?php endif; ?>
                                    <?php if($product->is_bestseller): ?>
                                    <span class="badge bg-danger me-2">
                                        <i class="bi bi-fire me-1"></i>Bán chạy
                                    </span>
                                    <?php endif; ?>
                                    <?php if($product->sale_price): ?>
                                    <span class="badge bg-success">
                                        -<?php echo e(round((($product->price - $product->sale_price) / $product->price) * 100)); ?>%
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="card-body">
                                <h6 class="card-title fw-bold text-dark mb-2 text-truncate">
                                    <?php echo e($product->name); ?>

                                </h6>
                                <p class="text-muted small mb-3">
                                    <?php echo e($product->category->name ?? 'N/A'); ?>

                                </p>

                                <!-- Price -->
                                <div class="mb-3">
                                    <?php if($product->sale_price): ?>
                                        <span class="h5 text-danger fw-bold me-2">
                                            <?php echo e(number_format($product->sale_price, 0, ',', '.')); ?>₫
                                        </span>
                                        <span class="text-muted text-decoration-line-through small">
                                            <?php echo e(number_format($product->price, 0, ',', '.')); ?>₫
                                        </span>
                                    <?php else: ?>
                                        <span class="h5 text-primary fw-bold">
                                            <?php echo e(number_format($product->price, 0, ',', '.')); ?>₫
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Stock Status -->
                                <small class="text-muted">
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
            <div class="d-flex justify-content-center">
                <?php echo e($products->links()); ?>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/products/index-new.blade.php ENDPATH**/ ?>