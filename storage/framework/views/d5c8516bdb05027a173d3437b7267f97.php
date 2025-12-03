

<?php $__env->startSection('title', 'Quản lý Đánh giá'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1>Quản lý Đánh giá</h1>
        <p class="text-muted">Duyệt và quản lý đánh giá từ khách hàng</p>
    </div>
</div>

<?php if($message = Session::get('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e($message); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Stats -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Tổng đánh giá</h6>
                        <h2 class="mb-0"><?php echo e($reviews->total()); ?></h2>
                    </div>
                    <i class="bi bi-star-fill fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card secondary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Đánh giá trung bình</h6>
                        <h2 class="mb-0"><?php echo e(number_format(\App\Models\Review::avg('rating'), 1)); ?>/5</h2>
                    </div>
                    <i class="bi bi-graph-up fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Đánh giá tháng này</h6>
                        <h2 class="mb-0"><?php echo e(\App\Models\Review::whereMonth('created_at', now()->month)->count()); ?></h2>
                    </div>
                    <i class="bi bi-calendar fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Người đánh giá</th>
                    <th>Đánh giá</th>
                    <th>Bình luận</th>
                    <th>Ngày</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('products.show', $review->product->slug)); ?>" class="text-decoration-none">
                                <strong><?php echo e(Str::limit($review->product->name, 30)); ?></strong>
                            </a>
                        </td>
                        <td>
                            <strong><?php echo e($review->reviewer_name); ?></strong>
                            <br>
                            <small class="text-muted"><?php echo e($review->reviewer_email); ?></small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <?php if($i <= $review->rating): ?>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    <?php else: ?>
                                        <i class="bi bi-star text-muted"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <span class="ms-2 fw-bold"><?php echo e($review->rating); ?>/5</span>
                            </div>
                        </td>
                        <td>
                            <small class="text-muted"><?php echo e(Str::limit($review->comment, 40)); ?></small>
                        </td>
                        <td>
                            <?php if($review->is_approved): ?>
                                <span class="badge bg-success">Đã duyệt</span>
                            <?php else: ?>
                                <span class="badge bg-warning">Chờ duyệt</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <small class="text-muted"><?php echo e($review->created_at->format('d/m/Y H:i')); ?></small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <?php if(!$review->is_approved): ?>
                                    <form action="<?php echo e(route('admin.reviews.approve', $review->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" class="btn btn-success" title="Duyệt">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form action="<?php echo e(route('admin.reviews.reject', $review->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" class="btn btn-warning" title="Từ chối">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                                <form action="<?php echo e(route('admin.reviews.destroy', $review->id)); ?>" method="POST" class="d-inline"
                                      onsubmit="return confirm('Bạn chắc chắn muốn xóa?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger" title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <p class="text-muted">Chưa có đánh giá nào</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    <?php echo e($reviews->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/admin/reviews/index.blade.php ENDPATH**/ ?>