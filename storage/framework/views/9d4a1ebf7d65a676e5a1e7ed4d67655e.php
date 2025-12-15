<?php $__env->startSection('title', 'Chi tiết đơn hàng - MobileShop'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <!-- Header with Order Info -->
    <div class="mb-5">
        <a href="<?php echo e(route('orders.tracking')); ?>" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="bi bi-arrow-left me-2"></i>Tra cứu khác
        </a>

        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h3 class="mb-1">Mã đơn hàng: <strong><?php echo e($order->order_number); ?></strong></h3>
                <p class="text-muted mb-0">Ngày đặt: <?php echo e($order->created_at->format('d/m/Y H:i')); ?></p>
            </div>
            <div class="text-end">
                <?php
                    $statusBadge = ['pending' => 'warning', 'processing' => 'info', 'shipped' => 'primary', 'delivered' => 'success', 'cancelled' => 'danger'];
                    $statusLabel = ['pending' => 'Chờ xử lý', 'processing' => 'Đang xử lý', 'shipped' => 'Đã gửi', 'delivered' => 'Đã giao', 'cancelled' => 'Đã hủy'];
                ?>
                <span class="badge bg-<?php echo e($statusBadge[$order->status] ?? 'secondary'); ?> fs-6 mb-2">
                    <?php echo e($statusLabel[$order->status] ?? 'N/A'); ?>

                </span>
                <div class="small">
                    <a href="javascript:void(0)" class="text-primary text-decoration-none me-2">Xem hoá đơn</a>
                    <?php if($order->status === 'pending'): ?>
                        <a href="javascript:void(0)" class="text-danger text-decoration-none">Hủy đơn</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left: Shipment Progress & Details -->
        <div class="col-lg-8">
            <!-- Shipment Progress -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-4">Tiến trình giao hàng</h6>
                    <div class="position-relative">
                        <?php
                            $statuses = ['pending' => 'Đơn được đặt', 'processing' => 'Đang xử lý', 'shipped' => 'Đang giao hàng', 'delivered' => 'Đã giao'];
                            $currentStatus = $order->status;
                            $statusOrder = ['pending', 'processing', 'shipped', 'delivered'];
                            $currentIndex = array_search($currentStatus, $statusOrder);
                        ?>
                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $index = array_search($key, $statusOrder); ?>
                            <div class="d-flex mb-4">
                                <div class="flex-shrink-0">
                                    <?php if($index <= $currentIndex): ?>
                                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-success text-white" style="width:45px;height:45px;">
                                            <i class="bi bi-check-lg fs-6"></i>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-light text-muted border" style="width:45px;height:45px;">
                                            <span class="small fw-bold"><?php echo e($index + 1); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-1 fw-bold"><?php echo e($label); ?></p>
                                    <?php if($index <= $currentIndex): ?>
                                        <p class="text-muted small mb-0">
                                            <?php if($index == $currentIndex && $currentStatus === 'shipped'): ?>
                                                Đơn hàng đang được vận chuyển. Vui lòng chủ động kiểm tra thời gian giao hàng và liên hệ với chúng tôi nếu có bất kỳ câu hỏi.
                                            <?php elseif($index <= $currentIndex): ?>
                                                Hoàn thành vào <?php echo e($order->created_at->addDays($index)->format('d/m/Y')); ?>

                                            <?php endif; ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">Địa chỉ giao hàng</h6>
                    <p class="mb-2">
                        <strong><?php echo e($order->shipping_name); ?></strong><br>
                        <?php echo e($order->shipping_phone); ?><br>
                        <span class="text-muted"><?php echo e($order->shipping_email); ?></span>
                    </p>
                    <p class="mb-0">
                        <strong>Địa chỉ:</strong><br>
                        <?php echo e($order->shipping_address); ?>

                    </p>
                </div>
            </div>
        </div>

        <!-- Right: Order Summary -->
        <div class="col-lg-4">
            <!-- Products Summary -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">Tóm tắt đơn hàng</h6>
                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $price = $item->unit_price > 0 ? $item->unit_price : ($item->product->sale_price > 0 ? $item->product->sale_price : $item->product->price);
                            $totalPrice = $item->total_price > 0 ? $item->total_price : ($price * $item->quantity);
                            $productImage = $item->product->main_image ? asset('storage/' . $item->product->main_image) : ($item->product->images->first() ? asset('storage/' . $item->product->images->first()->image_url) : null);
                        ?>
                        <div class="d-flex gap-3 mb-3">
                            <div style="width:60px;height:60px;background:#f5f6f8;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <?php if($productImage): ?>
                                    <img src="<?php echo e($productImage); ?>" alt="<?php echo e($item->product->name); ?>" class="img-fluid" style="max-height:55px;object-fit:contain;">
                                <?php endif; ?>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-1 fw-bold small"><?php echo e($item->product->name); ?></p>
                                <p class="text-muted small mb-0">x<?php echo e($item->quantity); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <hr>

                    <!-- Order Totals -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Tạm tính</span>
                            <span class="fw-bold"><?php echo e(number_format($order->total_amount - ($order->shipping_cost ?? 0) - ($order->tax_amount ?? 0), 0, ',', '.')); ?>₫</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Phí vận chuyển</span>
                            <span class="fw-bold"><?php echo e(number_format($order->shipping_cost ?? 0, 0, ',', '.')); ?>₫</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 small">
                            <span class="text-muted">Thuế (10%)</span>
                            <span class="fw-bold"><?php echo e(number_format($order->tax_amount ?? 0, 0, ',', '.')); ?>₫</span>
                        </div>
                        <?php if(($order->discount_amount ?? 0) > 0): ?>
                            <div class="d-flex justify-content-between mb-3 small">
                                <span class="text-muted">Giảm giá</span>
                                <span class="fw-bold text-success">-<?php echo e(number_format($order->discount_amount ?? 0, 0, ',', '.')); ?>₫</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Tổng cộng</span>
                        <span class="fw-bold fs-5 text-primary"><?php echo e(number_format($order->total_amount, 0, ',', '.')); ?>₫</span>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-2">Phương thức thanh toán</h6>
                    <p class="small text-muted mb-0"><?php echo e($order->paymentMethod->display_name ?? 'N/A'); ?></p>
                </div>
            </div>

            <!-- Support Button -->
            <button class="btn btn-outline-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#supportModal">
                <i class="bi bi-chat-dots me-2"></i>Liên hệ hỗ trợ
            </button>
            <a href="<?php echo e(route('contact.index')); ?>" class="btn btn-outline-secondary w-100">
                <i class="bi bi-arrow-return-left me-2"></i>Chính sách đổi trả
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/orders/tracking-detail.blade.php ENDPATH**/ ?>