<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Tài khoản</h5>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="<?php echo e(route('account.profile')); ?>">
                            <i class="bi bi-person me-2"></i>Hồ sơ
                        </a>
                        <a class="nav-link active" href="<?php echo e(route('account.orders')); ?>">
                            <i class="bi bi-receipt me-2"></i>Đơn hàng
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Lịch sử đơn hàng</h5>
                </div>
                <div class="card-body">
                    <?php if(Auth::user()->orders->count() > 0): ?>
                        <!-- Search Bar -->
                        <div class="mb-4">
                            <input type="text" class="form-control" id="searchOrder" placeholder="Tìm kiếm theo mã đơn hàng...">
                        </div>

                        <!-- Status Filter -->
                        <ul class="nav nav-pills mb-4" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab">
                                    Tất cả (<?php echo e(Auth::user()->orders->count()); ?>)
                                </button>
                            </li>
                            <?php
                                $statusMap = ['pending' => 'Chờ xử lý', 'processing' => 'Đang xử lý', 'shipped' => 'Đã gửi', 'delivered' => 'Đã giao', 'cancelled' => 'Đã hủy'];
                            ?>
                            <?php $__currentLoopData = $statusMap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $count = Auth::user()->orders->where('status', $key)->count(); ?>
                                <?php if($count > 0): ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="<?php echo e($key); ?>-tab" data-bs-toggle="pill" data-bs-target="#<?php echo e($key); ?>" type="button" role="tab">
                                            <?php echo e($label); ?> (<?php echo e($count); ?>)
                                        </button>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- All Orders -->
                            <div class="tab-pane fade show active" id="all" role="tabpanel">
                                <div class="row" id="ordersContainer">
                                    <?php $__currentLoopData = Auth::user()->orders->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-12 mb-3 order-card" data-order-number="<?php echo e($order->order_number); ?>">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div>
                                                            <h6 class="card-title mb-0">Mã đơn: <strong><?php echo e($order->order_number); ?></strong></h6>
                                                            <small class="text-muted"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></small>
                                                        </div>
                                                        <?php
                                                            $statusBadge = ['pending' => 'warning', 'processing' => 'info', 'shipped' => 'primary', 'delivered' => 'success', 'cancelled' => 'danger'];
                                                            $statusLabel = ['pending' => 'Chờ xử lý', 'processing' => 'Đang xử lý', 'shipped' => 'Đã gửi', 'delivered' => 'Đã giao', 'cancelled' => 'Đã hủy'];
                                                        ?>
                                                        <span class="badge bg-<?php echo e($statusBadge[$order->status] ?? 'secondary'); ?>"><?php echo e($statusLabel[$order->status] ?? 'N/A'); ?></span>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Tổng tiền</small><br>
                                                            <strong class="text-primary"><?php echo e(number_format($order->total_amount, 0, ',', '.')); ?>₫</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Số sản phẩm</small><br>
                                                            <strong><?php echo e($order->items->sum('quantity')); ?> sản phẩm</strong>
                                                        </div>
                                                    </div>

                                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal<?php echo e($order->id); ?>">
                                                        <i class="bi bi-eye me-2"></i>Xem chi tiết
                                                    </button>
                                                    <?php if($order->status === 'pending'): ?>
                                                        <button class="btn btn-sm btn-outline-danger cancel-order-btn" data-order-id="<?php echo e($order->id); ?>" data-order-number="<?php echo e($order->order_number); ?>">
                                                            <i class="bi bi-x-circle me-1"></i>Hủy đơn
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Chi tiết đơn hàng -->
                                        <div class="modal fade" id="orderModal<?php echo e($order->id); ?>" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light">
                                                        <h5 class="modal-title">Chi tiết đơn hàng <strong><?php echo e($order->order_number); ?></strong></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <small class="text-muted">Trạng thái</small><br>
                                                                <span class="badge bg-<?php echo e($statusBadge[$order->status] ?? 'secondary'); ?>"><?php echo e($statusLabel[$order->status] ?? 'N/A'); ?></span>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                <small class="text-muted">Ngày đặt</small><br>
                                                                <strong><?php echo e($order->created_at->format('d/m/Y H:i')); ?></strong>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <h6 class="mb-3">Thông tin giao hàng</h6>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <small class="text-muted">Người nhận</small><br>
                                                                <strong><?php echo e($order->shipping_name); ?></strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <small class="text-muted">Điện thoại</small><br>
                                                                <strong><?php echo e($order->shipping_phone); ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <small class="text-muted">Địa chỉ</small><br>
                                                                <strong><?php echo e($order->shipping_address); ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <small class="text-muted">Email</small><br>
                                                                <strong><?php echo e($order->shipping_email); ?></strong>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <h6 class="mb-3">Chi tiết sản phẩm</h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-sm">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th>Sản phẩm</th>
                                                                        <th class="text-end">Giá</th>
                                                                        <th class="text-center">Số lượng</th>
                                                                        <th class="text-end">Thành tiền</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td><?php echo e($item->product->name ?? $item->product_name); ?></td>
                                                                            <td class="text-end"><?php echo e(number_format($item->unit_price, 0, ',', '.')); ?>₫</td>
                                                                            <td class="text-center"><?php echo e($item->quantity); ?></td>
                                                                            <td class="text-end"><?php echo e(number_format($item->unit_price * $item->quantity, 0, ',', '.')); ?>₫</td>
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <hr>

                                                        <div class="row">
                                                            <div class="col-md-6 ms-auto">
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <span>Tạm tính:</span>
                                                                    <span><?php echo e(number_format($order->total_amount - ($order->shipping_cost ?? 0) - ($order->tax_amount ?? 0), 0, ',', '.')); ?>₫</span>
                                                                </div>
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <span>Vận chuyển:</span>
                                                                    <span><?php echo e(number_format($order->shipping_cost ?? 0, 0, ',', '.')); ?>₫</span>
                                                                </div>
                                                                <div class="d-flex justify-content-between mb-3">
                                                                    <span>Thuế:</span>
                                                                    <span><?php echo e(number_format($order->tax_amount ?? 0, 0, ',', '.')); ?>₫</span>
                                                                </div>
                                                                <hr>
                                                                <div class="d-flex justify-content-between fw-bold fs-5">
                                                                    <span>Tổng cộng:</span>
                                                                    <span class="text-primary"><?php echo e(number_format($order->total_amount, 0, ',', '.')); ?>₫</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <!-- Status Filter Panes -->
                            <?php $__currentLoopData = $statusMap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $orders = Auth::user()->orders->where('status', $key)->sortByDesc('created_at'); ?>
                                <?php if($orders->count() > 0): ?>
                                    <div class="tab-pane fade" id="<?php echo e($key); ?>" role="tabpanel">
                                        <div class="row">
                                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-12 mb-3">
                                                    <div class="card h-100 border-0 shadow-sm">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                                <div>
                                                                    <h6 class="card-title mb-0">Mã đơn: <strong><?php echo e($order->order_number); ?></strong></h6>
                                                                    <small class="text-muted"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></small>
                                                                </div>
                                                                <span class="badge bg-<?php echo e($statusBadge[$order->status] ?? 'secondary'); ?>"><?php echo e($label); ?></span>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <small class="text-muted">Tổng tiền</small><br>
                                                                    <strong class="text-primary"><?php echo e(number_format($order->total_amount, 0, ',', '.')); ?>₫</strong>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <small class="text-muted">Số sản phẩm</small><br>
                                                                    <strong><?php echo e($order->items->sum('quantity')); ?> sản phẩm</strong>
                                                                </div>
                                                            </div>
                                                            <button class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#orderModal<?php echo e($order->id); ?>">
                                                                <i class="bi bi-eye me-2"></i>Xem chi tiết
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center py-5" role="alert">
                            <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                            <strong>Chưa có đơn hàng!</strong><br>
                            <p class="text-muted mb-3">Bạn chưa đặt hàng lần nào.</p>
                            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">
                                <i class="bi bi-shop me-2"></i>Bắt đầu mua sắm
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchOrder');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const cards = document.querySelectorAll('#ordersContainer .order-card');
            cards.forEach(card => {
                const orderNumber = card.getAttribute('data-order-number').toLowerCase();
                card.style.display = orderNumber.includes(query) ? 'block' : 'none';
            });
        });
    }

    // Cancel order button handler
    document.querySelectorAll('.cancel-order-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            const orderNumber = this.getAttribute('data-order-number');
            
            if (confirm('Bạn có chắc muốn hủy đơn hàng ' + orderNumber + '?')) {
                fetch('/don-hang/' + orderId + '/huy', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Hủy đơn hàng thành công');
                        location.reload();
                    } else {
                        alert(data.message || 'Có lỗi xảy ra');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi hủy đơn hàng');
                });
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/account/orders.blade.php ENDPATH**/ ?>