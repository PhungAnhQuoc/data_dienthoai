<?php $__env->startSection('title', 'Chi tiết đơn hàng - MobileShop'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="mb-4">
                <a href="<?php echo e(route('orders.tracking')); ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-2"></i>Tìm kiếm khác
                </a>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4>Mã đơn hàng: <strong><?php echo e($order->order_number); ?></strong></h4>
                            <p class="text-muted mb-0">Ngày đặt: <?php echo e($order->created_at->format('d/m/Y H:i')); ?></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <?php
                                $statusBadge = ['pending' => 'warning', 'processing' => 'info', 'shipped' => 'primary', 'delivered' => 'success', 'cancelled' => 'danger'];
                                $statusLabel = ['pending' => 'Chờ xử lý', 'processing' => 'Đang xử lý', 'shipped' => 'Đã gửi', 'delivered' => 'Đã giao', 'cancelled' => 'Đã hủy'];
                            ?>
                            <span class="badge bg-<?php echo e($statusBadge[$order->status] ?? 'secondary'); ?> fs-6">
                                <?php echo e($statusLabel[$order->status] ?? 'N/A'); ?>

                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-4">Tiến trình đơn hàng</h6>
                    <div class="row text-center">
                        <?php
                            $statuses = ['pending' => 'Chờ xử lý', 'processing' => 'Đang xử lý', 'shipped' => 'Đã gửi', 'delivered' => 'Đã giao'];
                            $currentStatus = $order->status;
                            $statusOrder = ['pending', 'processing', 'shipped', 'delivered'];
                            $currentIndex = array_search($currentStatus, $statusOrder);
                        ?>
                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $index = array_search($key, $statusOrder); ?>
                            <div class="col">
                                <div class="mb-3">
                                    <?php if($index <= $currentIndex): ?>
                                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white" style="width:50px;height:50px;">
                                            <i class="bi bi-check-lg fs-5"></i>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-muted" style="width:50px;height:50px;">
                                            <span class="fw-bold"><?php echo e($index + 1); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <small class="d-block fw-bold"><?php echo e($label); ?></small>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Shipping Info -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-title fw-bold mb-3">Thông tin giao hàng</h6>
                            <p class="mb-2">
                                <strong>Người nhận:</strong><br>
                                <?php echo e($order->shipping_name); ?>

                            </p>
                            <p class="mb-2">
                                <strong>Điện thoại:</strong><br>
                                <?php echo e($order->shipping_phone); ?>

                            </p>
                            <p class="mb-2">
                                <strong>Email:</strong><br>
                                <?php echo e($order->shipping_email); ?>

                            </p>
                            <p class="mb-0">
                                <strong>Địa chỉ:</strong><br>
                                <?php echo e($order->shipping_address); ?>

                            </p>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-title fw-bold mb-3">Thông tin thanh toán</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tạm tính:</span>
                                <strong><?php echo e(number_format($order->total_amount - ($order->shipping_cost ?? 0) - ($order->tax_amount ?? 0), 0, ',', '.')); ?>₫</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Phí vận chuyển:</span>
                                <strong><?php echo e(number_format($order->shipping_cost ?? 0, 0, ',', '.')); ?>₫</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Thuế:</span>
                                <strong><?php echo e(number_format($order->tax_amount ?? 0, 0, ',', '.')); ?>₫</strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fs-5">
                                <span class="fw-bold">Tổng cộng:</span>
                                <span class="fw-bold text-primary"><?php echo e(number_format($order->total_amount, 0, ',', '.')); ?>₫</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">Chi tiết sản phẩm</h6>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
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
                                    <?php
                                        $price = $item->unit_price > 0 ? $item->unit_price : ($item->product->sale_price > 0 ? $item->product->sale_price : $item->product->price);
                                        $totalPrice = $item->total_price > 0 ? $item->total_price : ($price * $item->quantity);
                                    ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo e($item->product->name ?? $item->product_name); ?></strong>
                                        </td>
                                        <td class="text-end"><?php echo e(number_format($price, 0, ',', '.')); ?>₫</td>
                                        <td class="text-center"><?php echo e($item->quantity); ?></td>
                                        <td class="text-end"><?php echo e(number_format($totalPrice, 0, ',', '.')); ?>₫</td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="<?php echo e(route('orders.tracking')); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Tìm kiếm đơn hàng khác
                </a>
                <?php if(Auth::check()): ?>
                    <a href="<?php echo e(route('account.orders')); ?>" class="btn btn-outline-primary">
                        <i class="bi bi-list-check me-2"></i>Xem tất cả đơn hàng
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/orders/tracking-detail.blade.php ENDPATH**/ ?>