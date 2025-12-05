

<?php $__env->startSection('title', 'Trang chủ - MobileShop'); ?>

<?php $__env->startSection('content'); ?>
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
            <h2 class="fw-bold mb-0">Sản phẩm nổi bật</h2>
            <a href="<?php echo e(route('products.index')); ?>" class="text-primary text-decoration-none">Xem tất cả</a>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card product-card h-100 border-0 shadow-sm cursor-pointer" onclick="window.location.href='<?php echo e(route('products.show', $product->slug)); ?>'" style="cursor: pointer;">
                    <div class="position-relative">
                        <?php if($product->main_image): ?>
                        <img src="<?php echo e(asset('storage/' . $product->main_image)); ?>" 
                             class="card-img-top" 
                             alt="<?php echo e($product->name); ?>"
                             style="height: 250px; object-fit: cover;">
                        <?php elseif($product->images->count() > 0): ?>
                        <img src="<?php echo e(asset('storage/' . $product->images->first()->image_url)); ?>" 
                             class="card-img-top" 
                             alt="<?php echo e($product->name); ?>"
                             style="height: 250px; object-fit: cover;">
                        <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                            <span class="text-muted">No image</span>
                        </div>
                        <?php endif; ?>
                        <?php if($product->sale_price): ?>
                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                            -<?php echo e(round((($product->price - $product->sale_price) / $product->price) * 100)); ?>%
                        </span>
                        <?php endif; ?>
                        <?php if($product->is_new): ?>
                        <span class="badge bg-success position-absolute top-0 start-0 m-2">Mới</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-1"><?php echo e($product->brand->name ?? 'N/A'); ?></p>
                        <h6 class="card-title"><?php echo e($product->name); ?></h6>
                        <p class="text-muted small"><?php echo e(Str::limit($product->description, 50)); ?></p>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <?php if($product->sale_price): ?>
                                <span class="text-decoration-line-through text-muted small">
                                    <?php echo e($product->formatted_price); ?>

                                </span>
                                <h5 class="text-primary fw-bold mb-0"><?php echo e($product->formatted_sale_price); ?></h5>
                                <?php else: ?>
                                <h5 class="text-primary fw-bold mb-0"><?php echo e($product->formatted_price); ?></h5>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="d-inline w-100">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ</button>
                        </form>
                    </div>
                </div>
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
            <h2 class="fw-bold mb-0">Sản phẩm mới</h2>
            <a href="<?php echo e(route('products.index', ['filter' => 'new'])); ?>" class="text-primary text-decoration-none">
                Xem tất cả
            </a>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $newProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card product-card h-100 border-0 shadow-sm cursor-pointer" onclick="window.location.href='<?php echo e(route('products.show', $product->slug)); ?>'" style="cursor: pointer;">
                    <div class="position-relative">
                        <?php if($product->main_image): ?>
                        <img src="<?php echo e(asset('storage/' . $product->main_image)); ?>" 
                             class="card-img-top" 
                             alt="<?php echo e($product->name); ?>"
                             style="height: 250px; object-fit: cover;">
                        <?php elseif($product->images->count() > 0): ?>
                        <img src="<?php echo e(asset('storage/' . $product->images->first()->image_url)); ?>" 
                             class="card-img-top" 
                             alt="<?php echo e($product->name); ?>"
                             style="height: 250px; object-fit: cover;">
                        <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                            <span class="text-muted">No image</span>
                        </div>
                        <?php endif; ?>
                        <?php if($product->sale_price): ?>
                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                            -<?php echo e(round((($product->price - $product->sale_price) / $product->price) * 100)); ?>%
                        </span>
                        <?php endif; ?>
                        <span class="badge bg-success position-absolute top-0 start-0 m-2">Mới</span>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-1"><?php echo e($product->brand->name ?? 'N/A'); ?></p>
                        <h6 class="card-title"><?php echo e($product->name); ?></h6>
                        <p class="text-muted small"><?php echo e(Str::limit($product->description, 50)); ?></p>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <?php if($product->sale_price): ?>
                                <span class="text-decoration-line-through text-muted small">
                                    <?php echo e($product->formatted_price); ?>

                                </span>
                                <h5 class="text-primary fw-bold mb-0"><?php echo e($product->formatted_sale_price); ?></h5>
                                <?php else: ?>
                                <h5 class="text-primary fw-bold mb-0"><?php echo e($product->formatted_price); ?></h5>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="d-inline w-100">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ACCESSORIES -->
<?php if($bestsellerProducts->count() > 0): ?>
<section class="products-section mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Sản phẩm bán chạy</h2>
            <a href="<?php echo e(route('products.index', ['filter' => 'bestseller'])); ?>" class="text-primary text-decoration-none">
                Xem tất cả
            </a>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $bestsellerProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card product-card h-100 border-0 shadow-sm cursor-pointer" onclick="window.location.href='<?php echo e(route('products.show', $product->slug)); ?>'" style="cursor: pointer;">
                    <div class="position-relative">
                        <?php if($product->main_image): ?>
                        <img src="<?php echo e(asset('storage/' . $product->main_image)); ?>" 
                             class="card-img-top" 
                             alt="<?php echo e($product->name); ?>"
                             style="height: 250px; object-fit: cover;">
                        <?php elseif($product->images->count() > 0): ?>
                        <img src="<?php echo e(asset('storage/' . $product->images->first()->image_url)); ?>" 
                             class="card-img-top" 
                             alt="<?php echo e($product->name); ?>"
                             style="height: 250px; object-fit: cover;">
                        <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                            <span class="text-muted">No image</span>
                        </div>
                        <?php endif; ?>
                        <?php if($product->sale_price): ?>
                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                            -<?php echo e(round((($product->price - $product->sale_price) / $product->price) * 100)); ?>%
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-1"><?php echo e($product->brand->name ?? 'N/A'); ?></p>
                        <h6 class="card-title"><?php echo e($product->name); ?></h6>
                        <p class="text-muted small"><?php echo e(Str::limit($product->description, 50)); ?></p>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <?php if($product->sale_price): ?>
                                <span class="text-decoration-line-through text-muted small">
                                    <?php echo e($product->formatted_price); ?>

                                </span>
                                <h5 class="text-primary fw-bold mb-0"><?php echo e($product->formatted_sale_price); ?></h5>
                                <?php else: ?>
                                <h5 class="text-primary fw-bold mb-0"><?php echo e($product->formatted_price); ?></h5>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="d-inline w-100">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- BESTSELLERS -->
<?php if($accessories->count() > 0): ?>
<section class="accessories-section mb-5 bg-light py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Phụ kiện đi kèm</h2>
            <a href="<?php echo e(route('products.index', ['category' => 'phu-kien'])); ?>" class="text-primary text-decoration-none">
                Xem tất cả
            </a>
        </div>
        
        <!-- Tabs -->
        <ul class="nav nav-pills mb-4 justify-content-center" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#all">Tất cả</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#earphones">Sạc dự phòng</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#cases">Ốp lưng</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#chargers">Dán màn hình</button>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="all">
                <div class="row g-4">
                    <?php $__currentLoopData = $accessories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card product-card h-100 border-0 shadow-sm cursor-pointer" onclick="window.location.href='<?php echo e(route('products.show', $product->slug)); ?>'" style="cursor: pointer;">
                            <?php if($product->main_image): ?>
                            <img src="<?php echo e(asset('storage/' . $product->main_image)); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo e($product->name); ?>"
                                 style="height: 200px; object-fit: cover;">
                            <?php elseif($product->images->count() > 0): ?>
                            <img src="<?php echo e(asset('storage/' . $product->images->first()->image_url)); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo e($product->name); ?>"
                                 style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <span class="text-muted">No image</span>
                            </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <h6 class="card-title"><?php echo e($product->name); ?></h6>
                                <p class="text-muted small"><?php echo e(Str::limit($product->description, 50)); ?></p>
                                <h5 class="text-primary fw-bold"><?php echo e($product->formatted_price); ?></h5>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Brands -->
<?php if($brands->count() > 0): ?>
<section class="brands-section mb-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Thương hiệu hàng đầu</h2>
        <div class="row g-4">
            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-2 col-md-3 col-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center justify-content-center p-3">
                        <?php if($brand->logo): ?>
                        <img src="<?php echo e(asset('storage/' . $brand->logo)); ?>" 
                             alt="<?php echo e($brand->name); ?>"
                             class="img-fluid"
                             style="max-height: 50px;">
                        <?php else: ?>
                        <span class="fw-bold text-center"><?php echo e($brand->name); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
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