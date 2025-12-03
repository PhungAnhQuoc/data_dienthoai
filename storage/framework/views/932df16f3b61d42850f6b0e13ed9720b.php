<?php $__env->startSection('title', $product->name . ' - MobileShop'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>">Sản phẩm</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('products.index', ['category' => $product->category->slug])); ?>">
                <?php echo e($product->category->name); ?>

            </a></li>
            <li class="breadcrumb-item active"><?php echo e($product->name); ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="product-images">
                <!-- Main Image -->
                <div class="main-image mb-3">
                    <img src="<?php echo e(asset('storage/' . $product->main_image)); ?>" 
                         id="mainImage"
                         class="img-fluid rounded shadow-sm w-100" 
                         alt="<?php echo e($product->name); ?>"
                         style="max-height: 500px; object-fit: contain;">
                </div>

                <!-- Thumbnail Images -->
                <?php if($product->images->count() > 0): ?>
                <div class="row g-2">
                    <div class="col-3">
                        <img src="<?php echo e(asset('storage/' . $product->main_image)); ?>" 
                             class="img-thumbnail cursor-pointer thumbnail-image active"
                             onclick="changeImage(this.src, this)"
                             alt="<?php echo e($product->name); ?>">
                    </div>
                    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-3">
                        <img src="<?php echo e(asset('storage/' . $image->image_url)); ?>" 
                             class="img-thumbnail cursor-pointer thumbnail-image"
                             onclick="changeImage(this.src, this)"
                             alt="<?php echo e($product->name); ?>">
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="product-info">
                <div class="mb-2">
                    <span class="badge bg-light text-dark"><?php echo e($product->brand->name); ?></span>
                    <?php if($product->is_new): ?>
                        <span class="badge bg-success">Mới</span>
                    <?php endif; ?>
                    <?php if($product->sale_price): ?>
                        <span class="badge bg-danger">Giảm giá</span>
                    <?php endif; ?>
                </div>

                <h1 class="h3 fw-bold mb-2"><?php echo e($product->name); ?></h1>

                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                        <div class="text-warning">
                            <?php for($i = 0; $i < 5; $i++): ?>
                                <i class="bi <?php echo e($i < 4 ? 'bi-star-fill' : 'bi-star'); ?>"></i>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="text-muted">4.8/5 · <span class="text-primary">128 đánh giá</span></div>
                </div>

                <div class="mb-4">
                    <?php if($product->sale_price): ?>
                        <div class="d-flex align-items-baseline gap-3">
                            <h2 class="text-primary fw-bold mb-0"><?php echo e($product->formatted_sale_price); ?></h2>
                            <div class="text-muted text-decoration-line-through"><?php echo e($product->formatted_price); ?></div>
                            <div class="badge bg-danger">-<?php echo e(round((($product->price - $product->sale_price) / max($product->price,1)) * 100)); ?>%</div>
                        </div>
                    <?php else: ?>
                        <h2 class="text-primary fw-bold"><?php echo e($product->formatted_price); ?></h2>
                    <?php endif; ?>
                </div>

                
                <p class="text-muted mb-4"><?php echo \Illuminate\Support\Str::limit(strip_tags($product->description), 220); ?></p>

                
                <?php if(!empty($product->options)): ?>
                    <div class="mb-3">
                        <?php $__currentLoopData = $product->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionName => $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="form-label"><?php echo e(ucfirst($optionName)); ?></label>
                            <div class="mb-2">
                                <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button type="button" class="btn btn-outline-secondary btn-sm me-2"><?php echo e($val); ?></button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                
                <div class="mb-3">
                    <?php if($product->stock > 0): ?>
                        <span class="text-success"><i class="bi bi-check-circle"></i> Còn hàng (<?php echo e($product->stock); ?>)</span>
                    <?php else: ?>
                        <span class="text-danger"><i class="bi bi-x-circle"></i> Hết hàng</span>
                    <?php endif; ?>
                </div>

                
                <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="mb-4">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">

                    <div class="d-flex align-items-center mb-3">
                        <div class="input-group me-3" style="width: 140px;">
                            <button class="btn btn-outline-secondary" type="button" onclick="decreaseQty()"><i class="bi bi-dash"></i></button>
                            <input type="number" name="quantity" id="quantity" class="form-control text-center" value="1" min="1" max="<?php echo e($product->stock); ?>">
                            <button class="btn btn-outline-secondary" type="button" onclick="increaseQty()"><i class="bi bi-plus"></i></button>
                        </div>

                        <?php if($product->stock > 0): ?>
                            <button type="submit" class="btn btn-primary btn-lg me-2"><i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ hàng</button>
                            <a href="<?php echo e(route('checkout.index')); ?>" class="btn btn-danger btn-lg">Mua ngay</a>
                        <?php else: ?>
                            <button type="button" class="btn btn-secondary btn-lg" disabled>Hết hàng</button>
                        <?php endif; ?>
                    </div>
                </form>

                
                <div class="mb-4">
                    <?php if(auth()->guard()->check()): ?>
                        <?php
                            $isInWishlist = \App\Models\Wishlist::where('user_id', Auth::id())->where('product_id', $product->id)->exists();
                        ?>
                        <form action="<?php echo e(route('wishlist.store')); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                            <button type="submit" class="btn btn-outline-danger me-2"><i class="bi bi-heart<?php echo e($isInWishlist ? '-fill' : ''); ?>"></i> <?php echo e($isInWishlist ? 'Đã yêu thích' : 'Yêu thích'); ?></button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-danger me-2">Đăng nhập để yêu thích</a>
                    <?php endif; ?>
                    <a href="#" class="btn btn-outline-secondary"><i class="bi bi-share"></i> Chia sẻ</a>
                </div>

                
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4">
                                <i class="bi bi-shield-check text-primary fs-3"></i>
                                <p class="mb-0 small mt-2">Bảo hành chính hãng</p>
                            </div>
                            <div class="col-4">
                                <i class="bi bi-truck text-primary fs-3"></i>
                                <p class="mb-0 small mt-2">Giao hàng nhanh</p>
                            </div>
                            <div class="col-4">
                                <i class="bi bi-arrow-clockwise text-primary fs-3"></i>
                                <p class="mb-0 small mt-2">Đổi trả 30 ngày</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Tabs -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#specifications">
                        Thông số kỹ thuật
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#description">
                        Mô tả chi tiết
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reviews">
                        Đánh giá (128)
                    </button>
                </li>
            </ul>

            <div class="tab-content p-4 border border-top-0">
                <!-- Specifications -->
                <div class="tab-pane show active" id="specifications">
                    <?php if($product->specifications): ?>
                    <div class="table-responsive">
                        <?php echo $product->specifications; ?>

                    </div>
                    <?php else: ?>
                    <p class="text-muted">Thông tin chi tiết đang được cập nhật.</p>
                    <?php endif; ?>
                </div>

                <!-- Description -->
                <div class="tab-pane" id="description">
                    <div class="description-content">
                        <?php echo $product->description; ?>

                    </div>
                </div>

                <!-- Reviews -->
                <div class="tab-pane" id="reviews">
                    <div class="container-fluid">
                        <!-- Average Rating -->
                        <div class="mb-5">
                            <h5 class="mb-4">Đánh giá sản phẩm</h5>
                            <?php
                                try {
                                    $approvedReviews = $product->approvedReviews()->get();
                                    $avgRating = $approvedReviews->count() > 0 ? round($approvedReviews->avg('rating'), 1) : 0;
                                } catch (\Exception $e) {
                                    $approvedReviews = collect();
                                    $avgRating = 0;
                                }
                            ?>
                            
                            <?php if($approvedReviews->count() > 0): ?>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="card border-0 bg-light p-4">
                                        <h2 class="mb-2"><?php echo e($avgRating); ?>/5.0</h2>
                                        <div class="mb-2">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <?php if($i <= floor($avgRating)): ?>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                <?php elseif($i - $avgRating < 1): ?>
                                                    <i class="bi bi-star-half text-warning"></i>
                                                <?php else: ?>
                                                    <i class="bi bi-star text-muted"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                        <small class="text-muted">(<?php echo e($approvedReviews->count()); ?> đánh giá)</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Reviews List -->
                            <div class="mb-5">
                                <?php $__currentLoopData = $approvedReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="card border mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1"><?php echo e($review->reviewer_name); ?></h6>
                                                <div class="mb-2">
                                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                                        <?php if($i <= $review->rating): ?>
                                                            <i class="bi bi-star-fill text-warning"></i>
                                                        <?php else: ?>
                                                            <i class="bi bi-star text-muted"></i>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                </div>
                                                <small class="text-muted"><?php echo e($review->created_at->format('d/m/Y H:i')); ?></small>
                                            </div>
                                            <?php if(Auth::check() && Auth::id() === $review->user_id): ?>
                                            <form action="<?php echo e(route('reviews.destroy', $review->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                        </div>
                                        <p class="mt-3 mb-0"><?php echo e($review->comment); ?></p>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Review Form -->
                        <?php if(Auth::check()): ?>
                        <div class="card border-0 bg-light p-4">
                            <h5 class="mb-4">Chia sẻ đánh giá của bạn</h5>
                            <form action="<?php echo e(route('reviews.store', $product->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label class="form-label">Đánh giá *</label>
                                    <div class="rating-input">
                                        <?php for($i = 5; $i >= 1; $i--): ?>
                                        <input type="radio" id="star<?php echo e($i); ?>" name="rating" value="<?php echo e($i); ?>" required>
                                        <label for="star<?php echo e($i); ?>" class="star-label">
                                            <i class="bi bi-star-fill"></i>
                                        </label>
                                        <?php endfor; ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Bình luận *</label>
                                    <textarea class="form-control" name="comment" rows="4" required 
                                              placeholder="Chia sẻ trải nghiệm của bạn với sản phẩm này..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send me-2"></i>Gửi đánh giá
                                </button>
                            </form>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Vui lòng <a href="<?php echo e(route('login')); ?>">đăng nhập</a> để gửi đánh giá.
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if($relatedProducts->count() > 0): ?>
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">Sản phẩm liên quan</h3>
            <div class="row g-4">
                <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card product-card h-100 border-0 shadow-sm">
                        <div class="position-relative">
                            <img src="<?php echo e(asset('storage/' . $relatedProduct->main_image)); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo e($relatedProduct->name); ?>"
                                 style="height: 250px; object-fit: cover;">
                            <?php if($relatedProduct->sale_price): ?>
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                -<?php echo e(round((($relatedProduct->price - $relatedProduct->sale_price) / $relatedProduct->price) * 100)); ?>%
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title"><?php echo e($relatedProduct->name); ?></h6>
                            <h5 class="text-primary fw-bold">
                                <?php echo e($relatedProduct->sale_price ? $relatedProduct->formatted_sale_price : $relatedProduct->formatted_price); ?>

                            </h5>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <a href="<?php echo e(route('products.show', $relatedProduct->slug)); ?>" class="btn btn-outline-primary w-100">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .thumbnail-image {
        cursor: pointer;
        opacity: 0.6;
    }
    
    .thumbnail-image:hover,
    .thumbnail-image.active {
        opacity: 1;
        border-color: var(--bs-primary) !important;
    }

    .description-content {
        line-height: 1.8;
        color: #555;
        font-size: 15px;
    }

    .description-content p { margin-bottom: 1.5rem; }
    .description-content h1, .description-content h2, .description-content h3 { margin-top: 1.5rem; margin-bottom: 1rem; font-weight: 600; }
    .description-content ul, .description-content ol { margin-bottom: 1.5rem; padding-left: 2rem; }
    .description-content li { margin-bottom: 0.5rem; }
    .description-content table { width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; }
    .description-content table th, .description-content table td { border: 1px solid #ddd; padding: 12px; }
    .description-content img { max-width: 100%; height: auto; margin: 1.5rem 0; border-radius: 8px; }
    .description-content a { color: #667eea; text-decoration: none; }

    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        width: fit-content;
        gap: 0.5rem;
    }

    .rating-input input {
        display: none;
    }

    .star-label {
        cursor: pointer;
        font-size: 2rem;
        color: #ddd;
        transition: all 0.2s ease;
    }

    .rating-input input:checked ~ .star-label,
    .star-label:hover,
    .star-label:hover ~ .star-label {
        color: #ffc107;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function changeImage(src, element) {
        document.getElementById('mainImage').src = src;
        document.querySelectorAll('.thumbnail-image').forEach(img => img.classList.remove('active'));
        element.classList.add('active');
    }

    function increaseQty() {
        let qty = document.getElementById('quantity');
        if (parseInt(qty.value) < parseInt(qty.max)) qty.value = parseInt(qty.value) + 1;
    }

    function decreaseQty() {
        let qty = document.getElementById('quantity');
        if (parseInt(qty.value) > 1) qty.value = parseInt(qty.value) - 1;
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/products/show.blade.php ENDPATH**/ ?>