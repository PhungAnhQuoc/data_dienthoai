<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <!-- User Profile Card -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body text-center">
                    <div class="mb-3 position-relative" style="width: 70px; height: 70px; margin-left: auto; margin-right: auto;">
                        <?php if(Auth::user()->avatar): ?>
                            <img src="<?php echo e(asset('/storage/avatars/' . Auth::user()->avatar)); ?>?t=<?php echo e(time()); ?>" alt="Avatar" class="rounded-circle" style="width: 70px; height: 70px; object-fit: cover;">
                        <?php else: ?>
                            <div class="avatar-circle mx-auto" style="width: 70px; height: 70px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <span class="text-white" style="font-size: 28px; font-weight: bold;"><?php echo e(substr(Auth::user()->name, 0, 1)); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h6 class="card-title mb-1"><?php echo e(Auth::user()->name); ?></h6>
                    <p class="text-muted small mb-0"><?php echo e(Auth::user()->email); ?></p>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="list-group list-group-flush mb-3">
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center menu-item active" data-tab="personal" style="border-left: 3px solid #0d6efd;">
                    <i class="bi bi-person me-2"></i>
                    <span>Thông tin cá nhân</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center menu-item" data-tab="orders">
                    <i class="bi bi-bag-check me-2"></i>
                    <span>Lịch sử đơn hàng</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center menu-item" data-tab="address">
                    <i class="bi bi-map me-2"></i>
                    <span>Số địa chỉ</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center menu-item" data-tab="payment">
                    <i class="bi bi-credit-card me-2"></i>
                    <span>Phương thức thanh toán</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center menu-item" data-tab="messages">
                    <i class="bi bi-envelope me-2"></i>
                    <span>Tin nhắn liên hệ</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <?php if($message = Session::get('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?php echo e($message); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if($message = Session::get('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i><?php echo e($message); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- TAB 1: Thông tin cá nhân -->
            <div id="tab-personal" class="tab-content active">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-person me-2"></i>Thông tin cá nhân</h5>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editInfoModal">
                            <i class="bi bi-pencil me-1"></i>Chỉnh sửa
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Họ tên</label>
                                <p class="h6 mb-0"><?php echo e(Auth::user()->name); ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Email</label>
                                <p class="h6 mb-0"><?php echo e(Auth::user()->email); ?></p>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Số điện thoại</label>
                                <p class="h6 mb-0"><?php echo e(Auth::user()->phone ?? 'Chưa cập nhật'); ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Email</label>
                                <p class="h6 mb-0"><?php echo e(Auth::user()->email); ?></p>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted small">Địa chỉ</label>
                            <p class="h6 mb-0"><?php echo e(Auth::user()->address ?? 'Chưa cập nhật'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: Lịch sử đơn hàng -->
            <div id="tab-orders" class="tab-content" style="display: none;">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-bag-check me-2"></i>
                            Lịch sử đơn hàng
                        </h5>
                    </div>
                    <div class="card-body p-0">
                    <?php if(Auth::user()->orders->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4" style="width: 140px;">MÃ ĐƠN</th>
                                        <th style="width: 140px;">NGÀY ĐẶT</th>
                                        <th style="width: 140px;">TỔNG TIỀN</th>
                                        <th style="width: 140px;">TRẠNG THÁI</th>
                                        <th class="text-center pe-4" style="width: 100px;">CHI TIẾT</th>
                                    </tr>
                                </thead>
                                <tbody id="ordersTable">
                                    <?php
                                        $statusLabels = [
                                            'pending' => 'Chờ xử lý',
                                            'processing' => 'Đang xử lý',
                                            'shipped' => 'Đã gửi',
                                            'delivered' => 'Đã giao',
                                            'cancelled' => 'Đã hủy'
                                        ];
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'processing' => 'info',
                                            'shipped' => 'primary',
                                            'delivered' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                    ?>
                                    <?php $__currentLoopData = Auth::user()->orders->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="order-row" data-order-number="<?php echo e($order->order_number); ?>" data-status="<?php echo e($order->status); ?>">
                                            <td class="ps-4">
                                                <strong><?php echo e($order->order_number); ?></strong>
                                            </td>
                                            <td><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
                                            <td>
                                                <strong><?php echo e(number_format($order->total_amount, 0, '.', ',')); ?> đ</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo e($statusColors[$order->status] ?? 'secondary'); ?>">
                                                    <?php echo e($statusLabels[$order->status] ?? $order->status); ?>

                                                </span>
                                            </td>
                                            <td class="text-center pe-4">
                                                <button class="btn btn-sm btn-link text-primary toggle-detail-btn" data-order-id="<?php echo e($order->id); ?>" style="text-decoration: none;">
                                                    <i class="bi bi-chevron-down"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Detail Row -->
                                        <tr class="detail-row" id="detail-<?php echo e($order->id); ?>" style="display: none;">
                                            <td colspan="5" class="p-0">
                                                <div class="p-4 bg-light border-top">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <h6 class="mb-3">Chi tiết đơn hàng <?php echo e($order->order_number); ?></h6>
                                                            <div class="table-responsive">
                                                                <table class="table table-sm mb-3">
                                                                    <thead>
                                                                        <tr style="border-top: 1px solid #dee2e6;">
                                                                            <th>SẢN PHẨM</th>
                                                                            <th class="text-end" style="width: 80px;">GIÁ</th>
                                                                            <th class="text-center" style="width: 80px;">SỐ LƯỢNG</th>
                                                                            <th class="text-end" style="width: 120px;">THÀNH TIỀN</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="d-flex align-items-center">
                                                                                        <?php if($item->product->images->first()): ?>
                                                                                            <img src="<?php echo e(asset('storage/' . $item->product->images->first()->image_path)); ?>" alt="<?php echo e($item->product->name); ?>" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; margin-right: 12px;">
                                                                                        <?php endif; ?>
                                                                                        <span><?php echo e($item->product->name); ?></span>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="text-end"><?php echo e(number_format($item->price, 0, '.', ',')); ?> đ</td>
                                                                                <td class="text-center"><?php echo e($item->quantity); ?></td>
                                                                                <td class="text-end"><?php echo e(number_format($item->price * $item->quantity, 0, '.', ',')); ?> đ</td>
                                                                            </tr>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <!-- Cost Summary -->
                                                            <div class="row">
                                                                <div class="col-md-6 offset-md-6">
                                                                    <div class="d-flex justify-content-between mb-2">
                                                                        <span>Tạm tính:</span>
                                                                        <strong><?php echo e(number_format($order->subtotal_amount ?? ($order->total_amount - ($order->shipping_cost ?? 0)), 0, '.', ',')); ?> đ</strong>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                                                        <span>Vận chuyển:</span>
                                                                        <strong><?php echo e(number_format($order->shipping_cost ?? 0, 0, '.', ',')); ?> đ</strong>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between" style="font-size: 14px;">
                                                                        <span>Thuế (10%):</span>
                                                                        <strong><?php echo e(number_format($order->tax_amount ?? 0, 0, '.', ',')); ?> đ</strong>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="d-flex justify-content-between" style="font-size: 16px; color: #dc3545;">
                                                                        <span>Tổng cộng:</span>
                                                                        <strong><?php echo e(number_format($order->total_amount, 0, '.', ',')); ?> đ</strong>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 ps-md-4 border-start">
                                                            <h6 class="mb-3">Thông tin giao hàng</h6>
                                                            <div class="mb-3">
                                                                <small class="text-muted">Người nhận</small>
                                                                <div class="small"><?php echo e($order->shipping_name ?? Auth::user()->name); ?></div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <small class="text-muted">Số điện thoại</small>
                                                                <div class="small"><?php echo e($order->shipping_phone ?? Auth::user()->phone); ?></div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <small class="text-muted">Địa chỉ</small>
                                                                <div class="small"><?php echo e($order->shipping_address ?? Auth::user()->address); ?></div>
                                                            </div>

                                                            <hr>

                                                            <h6 class="mb-3">Phương thức thanh toán</h6>
                                                            <div class="mb-2">
                                                                <small class="text-muted">Loại thanh toán</small>
                                                                <div class="small"><?php echo e($order->paymentMethod->name ?? 'N/A'); ?></div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <small class="text-muted">Trạng thái</small>
                                                                <div class="small">
                                                                    <?php if($order->payment_status === 'paid'): ?>
                                                                        <span class="badge bg-success">Đã thanh toán</span>
                                                                    <?php else: ?>
                                                                        <span class="badge bg-warning">Chưa thanh toán</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>

                                                            <hr>

                                                            <div class="d-flex gap-2">
                                                                <button class="btn btn-sm btn-secondary flex-grow-1" onclick="document.getElementById('detail-<?php echo e($order->id); ?>').style.display='none'; document.querySelector('[data-order-id=&quot;<?php echo e($order->id); ?>&quot;]').innerHTML='<i class=&quot;bi bi-chevron-down&quot;></i>';">
                                                                    <i class="bi bi-check me-1"></i>Đóng
                                                                </button>
                                                                <?php if($order->status === 'pending'): ?>
                                                                    <button class="btn btn-sm btn-outline-danger cancel-order-btn" data-order-id="<?php echo e($order->id); ?>" data-order-number="<?php echo e($order->order_number); ?>">
                                                                        <i class="bi bi-x-circle me-1"></i>Hủy đơn
                                                                    </button>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 48px; color: #ccc;"></i>
                            <p class="text-muted mt-3">Bạn chưa có đơn hàng nào</p>
                            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Tiếp tục mua sắm</a>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- TAB 3: Số địa chỉ -->
            <div id="tab-address" class="tab-content" style="display: none;">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-map me-2"></i>Số địa chỉ</h5>
                        <button class="btn btn-sm btn-primary">
                            <i class="bi bi-plus me-1"></i> Thêm địa chỉ
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>Tính năng quản lý địa chỉ sẽ được cập nhật sớm.
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 4: Phương thức thanh toán -->
            <div id="tab-payment" class="tab-content" style="display: none;">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-credit-card me-2"></i>Phương thức thanh toán</h5>
                        <button class="btn btn-sm btn-primary">
                            <i class="bi bi-plus me-1"></i> Thêm thanh toán
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>Tính năng quản lý phương thức thanh toán sẽ được cập nhật sớm.
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 5: Tin nhắn liên hệ -->
            <div id="tab-messages" class="tab-content" style="display: none;">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0"><i class="bi bi-envelope me-2"></i>Tin nhắn liên hệ</h5>
                    </div>
                    <div class="card-body p-0">
                        <?php if($messages && $messages->count() > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4" style="width: 150px;">TỪ</th>
                                            <th style="width: 200px;">CHỦ ĐỀ</th>
                                            <th style="width: 150px;">NGÀY GỬI</th>
                                            <th style="width: 100px;">TRẠNG THÁI</th>
                                            <th class="text-center pe-4" style="width: 100px;">CHI TIẾT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="ps-4">
                                                    <strong><?php echo e($message->name ?? 'N/A'); ?></strong>
                                                    <br>
                                                    <small class="text-muted"><?php echo e($message->email); ?></small>
                                                </td>
                                                <td><?php echo e(Str::limit($message->subject ?? 'Không có tiêu đề', 50)); ?></td>
                                                <td><?php echo e($message->created_at->format('d/m/Y H:i')); ?></td>
                                                <td>
                                                    <?php if($message->status === 'replied'): ?>
                                                        <span class="badge bg-success">Đã trả lời</span>
                                                    <?php elseif($message->status === 'read'): ?>
                                                        <span class="badge bg-info">Đã đọc</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning">Chờ xử lý</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center pe-4">
                                                    <button class="btn btn-sm btn-link text-primary" data-bs-toggle="modal" data-bs-target="#messageModal<?php echo e($message->id); ?>" style="text-decoration: none;">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Message Detail Modal -->
                                            <div class="modal fade" id="messageModal<?php echo e($message->id); ?>" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header border-bottom">
                                                            <h6 class="modal-title">Chi tiết tin nhắn</h6>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <small class="text-muted">Từ</small>
                                                                <div><strong><?php echo e($message->name); ?></strong> (<?php echo e($message->email); ?>)</div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <small class="text-muted">Tiêu đề</small>
                                                                <div><strong><?php echo e($message->subject ?? 'Không có tiêu đề'); ?></strong></div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <small class="text-muted">Nội dung</small>
                                                                <div class="bg-light p-3 rounded"><?php echo e($message->message); ?></div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <small class="text-muted">Trạng thái</small>
                                                                <div>
                                                                    <?php if($message->status === 'replied'): ?>
                                                                        <span class="badge bg-success">Đã trả lời</span>
                                                                    <?php elseif($message->status === 'read'): ?>
                                                                        <span class="badge bg-info">Đã đọc</span>
                                                                    <?php else: ?>
                                                                        <span class="badge bg-warning">Chờ xử lý</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <?php if($message->admin_reply): ?>
                                                                <hr>
                                                                <div>
                                                                    <small class="text-muted">Trả lời từ admin</small>
                                                                    <div class="bg-light p-3 rounded mt-2"><?php echo e($message->admin_reply); ?></div>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="bi bi-envelope" style="font-size: 48px; color: #ccc;"></i>
                                <p class="text-muted mt-3">Bạn chưa có tin nhắn nào</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Tab switching
    document.querySelectorAll('.menu-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const tab = this.getAttribute('data-tab');

            // Remove active class from all menu items and contents
            document.querySelectorAll('.menu-item').forEach(el => {
                el.classList.remove('active');
                el.style.borderLeft = 'none';
            });
            document.querySelectorAll('.tab-content').forEach(el => {
                el.style.display = 'none';
            });

            // Add active class to current menu item and content
            this.classList.add('active');
            this.style.borderLeft = '3px solid #0d6efd';
            document.getElementById('tab-' + tab).style.display = 'block';
        });
    });

    // Toggle detail row
    document.querySelectorAll('.toggle-detail-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const orderId = this.getAttribute('data-order-id');
            const detailRow = document.getElementById('detail-' + orderId);
            const isOpen = detailRow.style.display !== 'none';
            
            // Close other detail rows
            document.querySelectorAll('.detail-row').forEach(row => {
                row.style.display = 'none';
            });
            document.querySelectorAll('.toggle-detail-btn').forEach(b => {
                b.innerHTML = '<i class="bi bi-chevron-down"></i>';
            });

            // Toggle current row
            if (!isOpen) {
                detailRow.style.display = 'table-row';
                this.innerHTML = '<i class="bi bi-chevron-up"></i>';
            }
        });
    });

    // Cancel order button
    document.querySelectorAll('.cancel-order-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
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
</script>

<!-- Modal: Edit Info -->
<div class="modal fade" id="editInfoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Chỉnh sửa thông tin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('account.update-profile')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Họ tên *</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(Auth::user()->name); ?>" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="phone" value="<?php echo e(Auth::user()->phone ?? ''); ?>" placeholder="09xxxxxxxxx">
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <textarea class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="address" rows="3" placeholder="Nhập địa chỉ của bạn"><?php echo e(Auth::user()->address ?? ''); ?></textarea>
                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/account/profile.blade.php ENDPATH**/ ?>