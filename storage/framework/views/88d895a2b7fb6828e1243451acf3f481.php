<?php $__env->startSection('title', 'Order Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>Order Management</h1>
    <p class="text-muted">View and manage all customer orders.</p>
</div>

<!-- Filters -->
<div class="tabs-filter">
    <button class="tab-btn active" onclick="filterOrders('all')">All Orders</button>
    <button class="tab-btn" onclick="filterOrders('pending')">Pending</button>
    <button class="tab-btn" onclick="filterOrders('confirmed')">Confirmed</button>
    <button class="tab-btn" onclick="filterOrders('shipped')">Shipped</button>
    <button class="tab-btn" onclick="filterOrders('delivered')">Delivered</button>
    <button class="tab-btn" onclick="filterOrders('cancelled')">Cancelled</button>
</div>

<!-- Orders Table -->
<div class="card">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Items</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <strong><?php echo e($order->order_number); ?></strong>
                </td>
                <td>
                    <strong><?php echo e($order->shipping_name); ?></strong><br>
                    <small class="text-muted"><?php echo e($order->user->email ?? $order->shipping_email); ?></small>
                </td>
                <td>
                    <strong><?php echo e(number_format($order->total_amount, 0, ',', '.')); ?>đ</strong>
                </td>
                <td>
                    <span class="badge bg-info"><?php echo e($order->items->count()); ?> items</span>
                </td>
                <td>
                    <?php switch($order->status):
                        case ('pending'): ?>
                            <span class="badge bg-warning">Pending</span>
                            <?php break; ?>
                        <?php case ('confirmed'): ?>
                            <span class="badge bg-info">Confirmed</span>
                            <?php break; ?>
                        <?php case ('shipped'): ?>
                            <span class="badge bg-primary">Shipped</span>
                            <?php break; ?>
                        <?php case ('delivered'): ?>
                            <span class="badge bg-success">Delivered</span>
                            <?php break; ?>
                        <?php case ('cancelled'): ?>
                            <span class="badge bg-danger">Cancelled</span>
                            <?php break; ?>
                    <?php endswitch; ?>
                </td>
                <td>
                    <?php if($order->payment_status === 'paid'): ?>
                        <span class="badge bg-success">Paid</span>
                    <?php elseif($order->payment_status === 'refunded'): ?>
                        <span class="badge bg-secondary">Refunded</span>
                    <?php else: ?>
                        <span class="badge bg-warning">Unpaid</span>
                    <?php endif; ?>
                </td>
                <td>
                    <small><?php echo e($order->created_at->format('M d, Y')); ?></small>
                </td>
                <td>
                    <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="btn btn-sm btn-primary" title="View">
                        <i class="bi bi-eye"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" class="text-center py-4">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">No orders found</p>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    <?php echo e($orders->links()); ?>

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

.tabs-filter {
    margin-bottom: 20px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.tab-btn {
    background: white;
    border: 1px solid #e9ecef;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s;
    white-space: nowrap;
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
function filterOrders(type) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    console.log('Filter by:', type);
    // TODO: Implement actual filtering
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>