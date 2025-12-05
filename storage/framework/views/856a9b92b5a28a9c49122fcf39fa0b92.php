<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <article>
                <?php if($post->featured_image): ?>
                <img src="<?php echo e(asset('storage/' . $post->featured_image)); ?>" 
                     class="img-fluid rounded mb-4" 
                     alt="<?php echo e($post->title); ?>"
                     style="max-height: 500px; object-fit: cover; width: 100%;">
                <?php endif; ?>
                
                <h1 class="mb-3"><?php echo e($post->title); ?></h1>
                
                <div class="text-muted mb-4">
                    <small>Đăng ngày: <?php echo e($post->published_at->format('d/m/Y H:i')); ?></small>
                </div>
                
                <div class="post-content">
                    <?php echo nl2br(e($post->content)); ?>

                </div>
            </article>

            <!-- Related Posts -->
            <?php if($relatedPosts->count() > 0): ?>
            <hr class="my-5">
            <h3 class="mb-4">Bài viết liên quan</h3>
            <div class="row">
                <?php $__currentLoopData = $relatedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <?php if($related->featured_image): ?>
                        <img src="<?php echo e(asset('storage/' . $related->featured_image)); ?>" 
                             class="card-img-top" 
                             alt="<?php echo e($related->title); ?>"
                             style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="card-title"><?php echo e($related->title); ?></h6>
                            <small class="text-muted"><?php echo e($related->published_at->format('d/m/Y')); ?></small>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <a href="<?php echo e(route('blog.show', $related->slug)); ?>" class="btn btn-sm btn-outline-primary">
                                Đọc thêm
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <!-- Post Info Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Thông tin bài viết</h6>
                </div>
                <div class="card-body">
                    <p><strong>Trạng thái:</strong> 
                        <?php if($post->is_active): ?>
                            <span class="badge bg-success">Đang hoạt động</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Không hoạt động</span>
                        <?php endif; ?>
                    </p>
                    <p><strong>Ngày tạo:</strong> <?php echo e($post->created_at->format('d/m/Y H:i')); ?></p>
                    <p><strong>Cập nhật:</strong> <?php echo e($post->updated_at->format('d/m/Y H:i')); ?></p>
                </div>
            </div>

            <!-- Suggested Products -->
            <?php if($suggestedProducts->count() > 0): ?>
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="bi bi-star me-2"></i>Sản phẩm gợi ý
                    </h6>
                </div>
                <div class="card-body p-0">
                    <?php $__currentLoopData = $suggestedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="text-decoration-none">
                        <div class="d-flex gap-3 p-3 border-bottom hover-effect" style="transition: background 0.3s; cursor: pointer;">
                            <div style="width: 80px; height: 80px; flex-shrink: 0; background: #f5f5f5; border-radius: 8px; overflow: hidden;">
                                <?php if($product->main_image): ?>
                                    <img src="<?php echo e(asset('storage/' . $product->main_image)); ?>" 
                                         alt="<?php echo e($product->name); ?>"
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <h6 class="mb-1 text-dark" style="font-size: 0.95rem; line-height: 1.2;">
                                    <?php echo e(Str::limit($product->name, 45)); ?>

                                </h6>
                                <div class="mb-1">
                                    <?php if($product->sale_price > 0): ?>
                                        <span class="fw-bold text-danger"><?php echo e(number_format($product->sale_price, 0, ',', '.')); ?>₫</span>
                                        <small class="text-muted text-decoration-line-through"><?php echo e(number_format($product->price, 0, ',', '.')); ?>₫</small>
                                    <?php else: ?>
                                        <span class="fw-bold text-primary"><?php echo e(number_format($product->price, 0, ',', '.')); ?>₫</span>
                                    <?php endif; ?>
                                </div>
                                <small class="text-muted">
                                    <?php if($product->stock > 0): ?>
                                        <span class="badge bg-success">Còn hàng</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Hết hàng</span>
                                    <?php endif; ?>
                                </small>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="card-footer bg-light">
                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-arrow-right me-2"></i>Xem tất cả sản phẩm
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/blog/show.blade.php ENDPATH**/ ?>