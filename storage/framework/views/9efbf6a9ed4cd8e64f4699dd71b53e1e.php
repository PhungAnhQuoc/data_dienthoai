<?php $__env->startSection('title', 'Quản Lý Blog'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Blog</h2>
    <a href="<?php echo e(route('admin.blog.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm Bài Viết
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tiêu Đề</th>
                    <th>Slug</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Tạo</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($blog->id); ?></td>
                        <td><?php echo e($blog->title); ?></td>
                        <td><span class="badge bg-secondary"><?php echo e($blog->slug); ?></span></td>
                        <td>
                            <?php if($blog->is_published): ?>
                                <span class="badge bg-success">Xuất Bản</span>
                            <?php else: ?>
                                <span class="badge bg-warning">Nháp</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($blog->created_at->format('d/m/Y')); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.blog.edit', $blog)); ?>" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="<?php echo e(route('admin.blog.destroy', $blog)); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn không?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Chưa có bài viết nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    <?php echo e($blogs->links('pagination::bootstrap-5')); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/admin/blog/index.blade.php ENDPATH**/ ?>