<?php $__env->startSection('title', 'Trang chủ - MobileShop'); ?>

<?php $__env->startSection('content'); ?>
<!-- Flash Sale Modal -->
<?php echo $__env->make('partials.flash-sale-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Flash Sale Promo Banner -->
<?php echo $__env->make('partials.flash-sale-promo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Hero Banner -->
<section class="hero-section mb-5">
    <div class="hero-banner position-relative overflow-hidden rounded-4" style="height: 550px; min-height: 400px;">
        <?php if($banners->count() > 0): ?>
        <div id="heroBanner" class="carousel slide carousel-fade h-100" data-bs-ride="carousel" data-bs-interval="6000">
            <div class="carousel-indicators position-absolute bottom-0 start-50 translate-middle-x mb-4">
                <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button" data-bs-target="#heroBanner" data-bs-slide-to="<?php echo e($index); ?>" 
                        class="rounded-pill <?php echo e($index == 0 ? 'active' : ''); ?>" 
                        style="width: 14px; height: 14px; background-color: rgba(255,255,255,0.6); border: 2px solid white; transition: all 0.3s ease;"
                        aria-label="Slide <?php echo e($index + 1); ?>"></button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="carousel-inner h-100">
                <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="carousel-item h-100 <?php echo e($index == 0 ? 'active' : ''); ?> position-relative">
                    <?php if($banner->image): ?>
                    <img src="<?php echo e(asset('storage/' . $banner->image)); ?>" 
                         class="d-block w-100 h-100 banner-image" 
                         alt="<?php echo e($banner->title); ?>"
                         style="object-fit: cover;">
                    <?php else: ?>
                    <div class="w-100 h-100 banner-placeholder" 
                         style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                    <?php endif; ?>
                    <!-- Dark overlay for text readability -->
                    <div class="position-absolute top-0 start-0 w-100 h-100 banner-overlay"></div>
                    <div class="carousel-caption d-flex align-items-center justify-content-center h-100">
                        <div class="text-center banner-content px-4">
                            <h1 class="display-3 fw-bold mb-3 text-white banner-title"><?php echo e($banner->title); ?></h1>
                            <p class="fs-5 text-white-50 mb-4 banner-description" style="font-weight: 300;"><?php echo e($banner->description); ?></p>
                            <?php if($banner->link): ?>
                            <a href="<?php echo e($banner->link); ?>" class="btn btn-primary btn-lg px-5 fw-bold banner-btn">Khám Phá Ngay</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php if($banners->count() > 1): ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroBanner" data-bs-slide="prev">
                <span class="carousel-control-prev-icon fs-4"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroBanner" data-bs-slide="next">
                <span class="carousel-control-next-icon fs-4"></span>
            </button>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="w-100 h-100 d-flex align-items-center justify-content-center position-relative overflow-hidden rounded-4"
             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 400px;">
            <div class="position-absolute banner-overlay"></div>
            <div class="text-center text-white position-relative z-2">
                <h1 class="display-3 fw-bold mb-3">Chào mừng tới MobileShop</h1>
                <p class="fs-5 mb-4" style="font-weight: 300;">Khám phá bộ sưu tập điện thoại mới nhất</p>
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-light btn-lg px-5 fw-bold">Mua Sắm Ngay</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- FLASH SALES SECTION -->
<section class="flash-sales-section mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-lightning-fill text-danger me-2"></i>Flash Sale - Giá Sốc
            </h2>
            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#flashSaleModal">Xem tất cả</button>
        </div>
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, rgba(255, 107, 107, 0.08) 0%, rgba(255, 142, 114, 0.08) 100%); border-radius: 12px;">
            <div class="card-body p-4">
                <div class="flash-sales-grid" id="homeFlashSalesGrid">
                    <div class="text-center py-5">
                        <div class="spinner-border text-danger" role="status">
                            <span class="visually-hidden">Đang tải...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Promotions -->
<?php if($promotions->count() > 0): ?>
<section class="promotions-section mb-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Ưu đãi độc quyền chi dành cho bạn</h2>
        <div class="row g-4">
            <?php $__currentLoopData = $promotions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promotion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="badge bg-primary mb-2"><?php echo e($promotion->code); ?></div>
                        <h5 class="card-title"><?php echo e($promotion->title); ?></h5>
                        <p class="text-muted small"><?php echo e($promotion->description); ?></p>
                        <div class="fw-bold text-primary">
                            <?php if($promotion->discount_value > 0): ?>
                                <?php if($promotion->discount_type === 'percentage'): ?>
                                    Giảm: <span class="text-dark"><?php echo e(intval($promotion->discount_value)); ?>%</span>
                                <?php else: ?>
                                    Giảm: <span class="text-dark"><?php echo e(number_format($promotion->discount_value, 0, ',', '.')); ?>đ</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php echo e($promotion->title); ?>

                            <?php endif; ?>
                        </div>
                        <p class="text-muted small mt-2">
                            Từ <?php echo e($promotion->start_date->format('d/m/Y')); ?> đến <?php echo e($promotion->end_date->format('d/m/Y')); ?>

                        </p>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="copyCode(this, '<?php echo e($promotion->code); ?>')">
                            <i class="bi bi-clipboard"></i> Sao chép mã
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Featured Products -->
<?php if($featuredProducts->count() > 0): ?>
<section class="products-section mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-star-fill text-warning me-2"></i>Sản phẩm nổi bật
            </h2>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <?php echo $__env->make('partials.product-card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- NEW PRODUCTS -->
<?php if($newProducts->count() > 0): ?>
<section class="products-section mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-lightning-fill text-success me-2"></i>Sản phẩm mới
            </h2>
            <a href="<?php echo e(route('products.index', ['filter' => 'new'])); ?>" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $newProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <?php echo $__env->make('partials.product-card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- BESTSELLER PRODUCTS -->
<?php if($bestsellerProducts->count() > 0): ?>
<section class="products-section mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-fire text-danger me-2"></i>Sản phẩm bán chạy
            </h2>
            <a href="<?php echo e(route('products.index', ['filter' => 'bestseller'])); ?>" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $bestsellerProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <?php echo $__env->make('partials.product-card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ACCESSORIES SECTION -->
<?php if($accessories->count() > 0): ?>
<section class="products-section mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-box-fill text-info me-2"></i>Phụ kiện
            </h2>
            <a href="<?php echo e(route('products.index', ['category' => 'phu-kien'])); ?>" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $accessories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <?php echo $__env->make('partials.product-card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Blog Posts -->
<?php if($blogPosts->count() > 0): ?>
<section class="blog-section mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-newspaper text-info me-2"></i>Tin tức nổi bật
            </h2>
            <a href="<?php echo e(route('blog.index')); ?>" class="btn btn-outline-primary btn-sm">Xem thêm</a>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $blogPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4">
                <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="card blog-card border-0 shadow-sm h-100 text-decoration-none text-reset d-block">
                    <?php if($post->featured_image): ?>
                    <img src="<?php echo e(asset('storage/' . $post->featured_image)); ?>" 
                         class="card-img-top" 
                         alt="<?php echo e($post->title); ?>"
                         style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-image" style="font-size: 2rem; color: #d1d5db;"></i>
                    </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <div class="badge bg-light text-dark mb-2">
                            <?php echo e($post->published_at->format('d tháng m, Y')); ?>

                        </div>
                        <h5 class="card-title"><?php echo e($post->title); ?></h5>
                        <p class="card-text text-muted"><?php echo e(Str::limit($post->excerpt, 100)); ?></p>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Brand Categories -->
<?php if($brands->count() > 0): ?>
<section class="brands-section mb-5 py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">
            <i class="bi bi-shop me-2"></i>Thương hiệu hàng đầu
        </h2>
        <div class="row g-4">
            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                <a href="<?php echo e(route('products.index', ['brand' => $brand->slug])); ?>" class="brand-card card border-0 shadow-sm h-100 text-decoration-none text-dark text-center">
                    <div class="card-body d-flex align-items-center justify-content-center" style="min-height: 120px; padding: 2rem 1rem;">
                        <?php if($brand->logo): ?>
                            <img src="<?php echo e(asset('storage/' . $brand->logo)); ?>" 
                                 alt="<?php echo e($brand->name); ?>"
                                 class="img-fluid"
                                 style="max-height: 60px; object-fit: contain;">
                        <?php else: ?>
                            <span class="fw-bold text-center fs-5"><?php echo e($brand->name); ?></span>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Blog Posts -->
<?php if($blogPosts->count() > 0): ?>
<section class="blog-section mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Tin tức nổi bật</h2>
            <a href="<?php echo e(route('blog.index')); ?>" class="text-primary text-decoration-none">Xem thêm</a>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $blogPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4">
                <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="card blog-card border-0 shadow-sm h-100 text-decoration-none text-reset d-block">
                    <?php if($post->featured_image): ?>
                    <img src="<?php echo e(asset('storage/' . $post->featured_image)); ?>" 
                         class="card-img-top" 
                         alt="<?php echo e($post->title); ?>"
                         style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <span class="text-muted">Không có ảnh</span>
                    </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <div class="badge bg-light text-dark mb-2">
                            <?php echo e($post->published_at->format('d tháng m, Y')); ?>

                        </div>
                        <h5 class="card-title"><?php echo e($post->title); ?></h5>
                        <p class="card-text text-muted"><?php echo e(Str::limit($post->excerpt, 100)); ?></p>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Category Tiles + Footer Preview (from design) -->
<section class="categories-preview mb-5">
    <div class="container">
        <h3 class="text-center fw-bold mb-4">Mua sắp theo danh mục</h3>
        <div class="row g-4">
            <?php if(count($categories) > 0): ?>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-3">
                    <a href="<?php echo e(route('products.index', ['category' => $category->slug])); ?>" class="card text-decoration-none overflow-hidden rounded-3 shadow-sm">
                        <?php if($category->image): ?>
                        <img src="<?php echo e(asset('storage/' . $category->image)); ?>" class="card-img-top" alt="<?php echo e($category->name); ?>" style="height:140px; object-fit:cover;">
                        <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:140px;">
                            <span class="text-muted"><?php echo e($category->name); ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="card-body text-center py-3">
                            <strong class="text-dark"><?php echo e($category->name); ?></strong>
                        </div>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function copyCode(btn, code) {
    // Copy to clipboard
    navigator.clipboard.writeText(code).then(() => {
        // Show notification
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check"></i> Đã sao chép!';
        btn.disabled = true;
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 2000);
    }).catch(() => {
        // Fallback for older browsers
        const textarea = document.createElement('textarea');
        textarea.value = code;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        
        btn.innerHTML = '<i class="bi bi-check"></i> Đã sao chép!';
        btn.disabled = true;
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 2000);
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/home.blade.php ENDPATH**/ ?>