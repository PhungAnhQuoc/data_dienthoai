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
            <div class="card">
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
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/blog/show.blade.php ENDPATH**/ ?>