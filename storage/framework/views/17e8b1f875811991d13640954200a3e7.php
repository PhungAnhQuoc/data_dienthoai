

<?php $__env->startSection('title', 'Phụ kiện'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1>Quản lý Phụ kiện</h1>
        <p class="text-muted">Quản lý các phụ kiện sản phẩm</p>
    </div>
    <a href="<?php echo e(route('admin.accessories.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm Phụ kiện
    </a>
</div>

<?php if($message = Session::get('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e($message); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên Phụ kiện</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $accessories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accessory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <?php if($accessory->image): ?>
                                    <img src="<?php echo e(asset('storage/' . $accessory->image)); ?>" alt="<?php echo e($accessory->name); ?>" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                <?php else: ?>
                                    <span class="badge bg-secondary">Không có ảnh</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo e($accessory->name); ?></strong>
                                <br>
                                <small class="text-muted"><?php echo e(Str::limit($accessory->description, 50)); ?></small>
                            </td>
                            <td><?php echo e(number_format($accessory->price, 0, ',', '.')); ?>đ</td>
                            <td>
                                <span class="badge <?php echo e($accessory->stock > 0 ? 'bg-success' : 'bg-danger'); ?>">
                                    <?php echo e($accessory->stock); ?>

                                </span>
                            </td>
                            <td>
                                <span class="badge <?php echo e($accessory->is_active ? 'bg-info' : 'bg-secondary'); ?>">
                                    <?php echo e($accessory->is_active ? 'Hoạt động' : 'Ẩn'); ?>

                                </span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.accessories.edit', $accessory->id)); ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="<?php echo e(route('admin.accessories.destroy', $accessory->id)); ?>" method="POST" class="d-inline"
                                      onsubmit="return confirm('Bạn chắc chắn muốn xóa?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="text-muted">Chưa có phụ kiện nào</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/admin/accessories/index.blade.php ENDPATH**/ ?>