

<?php $__env->startSection('title', 'Quản lý mã ưu đãi - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0">
                <i class="bi bi-tag"></i> Quản lý mã ưu đãi
            </h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?php echo e(route('admin.promotions.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Thêm mã ưu đãi
            </a>
        </div>
    </div>

    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i><?php echo e($message); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if($message = Session::get('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i><?php echo e($message); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 15%">Mã</th>
                        <th style="width: 25%">Mô tả</th>
                        <th style="width: 15%">Loại & Giá trị</th>
                        <th style="width: 20%">Thời gian</th>
                        <th style="width: 10%">Trạng thái</th>
                        <th style="width: 15%" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $promotions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promotion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <span class="badge bg-info"><?php echo e($promotion->code); ?></span>
                            </td>
                            <td>
                                <small><?php echo e($promotion->description ?? 'Không có mô tả'); ?></small>
                            </td>
                            <td>
                                <div class="fw-bold">
                                    <?php if($promotion->discount_type === 'percentage'): ?>
                                        <?php echo e($promotion->discount_value); ?>%
                                    <?php else: ?>
                                        <?php echo e(number_format($promotion->discount_value, 0, ',', '.')); ?>₫
                                    <?php endif; ?>
                                </div>
                                <small class="text-muted">
                                    <?php echo e($promotion->discount_type === 'percentage' ? 'Phần trăm' : 'Cố định'); ?>

                                </small>
                            </td>
                            <td>
                                <div class="small">
                                    <div>Từ: <?php echo e(date('d/m/Y', strtotime($promotion->start_date))); ?></div>
                                    <div>Đến: <?php echo e(date('d/m/Y', strtotime($promotion->end_date))); ?></div>
                                </div>
                            </td>
                            <td>
                                <?php if($promotion->is_active): ?>
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Hoạt động
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-x-circle me-1"></i>Không hoạt động
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?php echo e(route('admin.promotions.edit', $promotion->id)); ?>" 
                                       class="btn btn-outline-primary" title="Chỉnh sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" 
                                          action="<?php echo e(route('admin.promotions.destroy', $promotion->id)); ?>" 
                                          style="display:inline-block;"
                                          onsubmit="return confirm('Bạn chắc chắn muốn xóa mã ưu đãi này?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-outline-danger" title="Xóa">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Chưa có mã ưu đãi nào
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if($promotions->hasPages()): ?>
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($promotions->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/admin/promotions/index.blade.php ENDPATH**/ ?>