<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-4">Tin Tức & Bài Viết</h1>
        </div>
    </div>

    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4 mb-4">
                <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="card blog-card h-100 shadow-sm text-decoration-none text-reset d-block">
                    <?php if($post->featured_image): ?>
                    <img src="<?php echo e(asset('storage/' . $post->featured_image)); ?>" 
                         class="card-img-top" 
                         alt="<?php echo e($post->title); ?>"
                         style="height: 250px; object-fit: cover;">
                    <?php else: ?>
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <span class="text-muted">Không có ảnh</span>
                    </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($post->title); ?></h5>
                        <p class="card-text text-muted"><?php echo e(Str::limit($post->excerpt ?? $post->content, 100)); ?></p>
                        <small class="text-secondary"><?php echo e($post->published_at->format('d/m/Y')); ?></small>
                    </div>
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-md-12">
                <div class="alert alert-info">
                    Chưa có bài viết nào. Vui lòng quay lại sau!
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($posts instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
    <div class="row mt-4">
        <div class="col-md-12 d-flex justify-content-center">
            <?php echo e($posts->links()); ?>

        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/blog/index.blade.php ENDPATH**/ ?>