<?php $__env->startSection('title', 'Product Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>Product Management</h1>
    <p class="text-muted">Manage all mobile phone products in your store.</p>
    <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-add">
        <i class="bi bi-plus-circle"></i> Add New Product
    </a>
</div>

<div class="tabs-filter">
    <button class="tab-btn active" onclick="filterProducts('all')">All</button>
    <button class="tab-btn" onclick="filterProducts('active')">Active</button>
    <button class="tab-btn" onclick="filterProducts('inactive')">Inactive</button>
    <button class="tab-btn" onclick="filterProducts('low-stock')">Low Stock</button>
</div>

<div class="card">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <?php if($product->main_image): ?>
                        <img src="<?php echo e(asset('storage/' . $product->main_image)); ?>" alt="<?php echo e($product->name); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                    <?php else: ?>
                        <div style="width: 50px; height: 50px; background: #e9ecef; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-image" style="color: #999;"></i>
                        </div>
                    <?php endif; ?>
                </td>
                <td>
                    <strong><?php echo e($product->name); ?></strong><br>
                    <small class="text-muted"><?php echo e($product->brand->name ?? 'No Brand'); ?></small>
                </td>
                <td><?php echo e($product->sku); ?></td>
                <td>
                    <strong><?php echo e(number_format($product->price, 0, ',', '.')); ?>đ</strong>
                    <?php if($product->sale_price): ?>
                        <br><small class="text-danger"><?php echo e(number_format($product->sale_price, 0, ',', '.')); ?>đ</small>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="badge bg-info"><?php echo e($product->stock); ?> units</span>
                    <?php if($product->stock < 10): ?>
                        <br><small class="text-danger">⚠️ Low Stock</small>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($product->is_active): ?>
                        <span class="badge bg-success">Active</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Inactive</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-sm btn-primary" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="text-center py-4">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">No products found</p>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    <?php echo e($products->links()); ?>

</div>

<style>
.page-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e9ecef;
}

.page-header h1 {
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
}

.btn-add {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s;
}

.btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    color: white;
}

.tabs-filter {
    margin-bottom: 20px;
    display: flex;
    gap: 10px;
}

.tab-btn {
    background: white;
    border: 1px solid #e9ecef;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s;
}

.tab-btn:hover {
    border-color: #667eea;
    color: #667eea;
}

.tab-btn.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}

.card {
    border: none;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.table {
    margin-bottom: 0;
}

.table thead th {
    border-bottom: 2px solid #f0f0f0;
    background-color: #f9f9f9;
    font-weight: 600;
    color: #333;
    padding: 12px;
}

.table tbody tr {
    border-bottom: 1px solid #f0f0f0;
}

.table tbody tr:hover {
    background-color: #f9f9f9;
}

.btn-sm {
    padding: 4px 8px;
    font-size: 0.85rem;
}

.badge {
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 0.85rem;
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function filterProducts(type) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    console.log('Filter by:', type);
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/admin/products/index.blade.php ENDPATH**/ ?>