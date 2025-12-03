<?php $__env->startSection('title', 'Categories'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1>Quản lý Danh Mục</h1>
        <p class="text-muted">Quản lý các danh mục sản phẩm</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">
        <i class="bi bi-plus-circle"></i> Thêm Danh Mục
    </button>
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
                    <th>Tên Danh Mục</th>
                    <th>Slug</th>
                    <th>Số Sản Phẩm</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($category->name); ?></strong></td>
                        <td><code><?php echo e($category->slug); ?></code></td>
                        <td>
                            <span class="badge bg-info"><?php echo e($category->products_count ?? 0); ?></span>
                        </td>
                        <td>
                            <span class="badge <?php echo e($category->is_active ? 'bg-success' : 'bg-danger'); ?>">
                                <?php echo e($category->is_active ? 'Hoạt động' : 'Ẩn'); ?>

                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#categoryModal" 
                                    onclick="editCategory(<?php echo e($category->toJson()); ?>)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="<?php echo e(route('admin.categories.destroy', $category->id)); ?>" method="POST" class="d-inline"
                                  onsubmit="return confirm('Xóa danh mục này?');">
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
                        <td colspan="5" class="text-center py-4">
                            <p class="text-muted">Chưa có danh mục nào</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    <?php echo e($categories->links()); ?>

</div>

<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Thêm Danh Mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="categoryForm" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên Danh Mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="categoryName" required>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="categoryActive" value="1">
                        <label class="form-check-label" for="categoryActive">
                            Kích hoạt
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editCategory(category) {
    document.getElementById('modalTitle').innerText = 'Sửa Danh Mục';
    document.getElementById('categoryForm').action = `/admin/categories/${category.id}`;
    document.getElementById('categoryForm').innerHTML = '<?php echo csrf_field(); ?> <?php echo method_field("PUT"); ?>' +
        '<div class="modal-body">' +
        '<div class="mb-3"><label class="form-label">Tên Danh Mục <span class="text-danger">*</span></label>' +
        '<input type="text" class="form-control" name="name" value="' + category.name + '" required></div>' +
        '<div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" ' + (category.is_active ? 'checked' : '') + '>' +
        '<label class="form-check-label">Kích hoạt</label></div></div>' +
        '<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>' +
        '<button type="submit" class="btn btn-primary">Cập nhật</button></div>';
}

document.getElementById('categoryModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('modalTitle').innerText = 'Thêm Danh Mục';
    document.getElementById('categoryForm').action = '/admin/categories';
    document.getElementById('categoryForm').method = 'POST';
    document.getElementById('categoryForm').innerHTML = '<?php echo csrf_field(); ?><div class="modal-body">' +
        '<div class="mb-3"><label class="form-label">Tên Danh Mục <span class="text-danger">*</span></label>' +
        '<input type="text" class="form-control" name="name" required></div>' +
        '<div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1">' +
        '<label class="form-check-label">Kích hoạt</label></div></div>' +
        '<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>' +
        '<button type="submit" class="btn btn-primary">Lưu</button></div>';
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>