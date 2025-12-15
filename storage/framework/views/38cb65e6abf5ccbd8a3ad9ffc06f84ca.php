<?php $__env->startSection('title', 'Giỏ hàng - MobileShop'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h2 class="fw-bold mb-4">Giỏ hàng của bạn</h2>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if(count($cartItems) > 0): ?>
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Đơn giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-center">Thành tiền</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if($item['isFlashSale']): ?>
                                                <img src="<?php echo e($item['flashSale']->image ? asset('storage/' . $item['flashSale']->image) : asset('images/placeholder.jpg')); ?>" 
                                                     alt="<?php echo e($item['flashSale']->title); ?>"
                                                     class="rounded me-3"
                                                     style="width: 80px; height: 80px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-1">
                                                        <a href="<?php echo e(route('flash-sales.show', $item['flashSale']->id)); ?>" 
                                                           class="text-decoration-none text-dark">
                                                            <?php echo e($item['flashSale']->title); ?>

                                                        </a>
                                                    </h6>
                                                    <div class="badge bg-danger">⚡ Flash Sale</div>
                                                </div>
                                            <?php else: ?>
                                                <img src="<?php echo e(asset('storage/' . $item['product']->main_image)); ?>" 
                                                     alt="<?php echo e($item['product']->name); ?>"
                                                     class="rounded me-3"
                                                     style="width: 80px; height: 80px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-1">
                                                        <a href="<?php echo e(route('products.show', $item['product']->slug)); ?>" 
                                                           class="text-decoration-none text-dark">
                                                            <?php echo e($item['product']->name); ?>

                                                        </a>
                                                    </h6>
                                                    <small class="text-muted"><?php echo e($item['product']->brand->name); ?></small>
                                                    <?php if($item['product']->stock < 10): ?>
                                                    <div class="badge bg-warning text-dark mt-1">
                                                        Chỉ còn <?php echo e($item['product']->stock); ?> sản phẩm
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-primary">
                                            <?php echo e(number_format($item['price'], 0, ',', '.')); ?>đ
                                        </strong>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="input-group" style="max-width: 130px;">
                                                <button class="btn btn-outline-secondary btn-sm" 
                                                        type="button"
                                                            onclick="updateQuantity('<?php echo e($item['id']); ?>', <?php echo e($item['quantity'] - 1); ?>)"
                                                            <?php if($item['quantity'] <= 1): ?> disabled <?php endif; ?>>
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" 
                                                       class="form-control form-control-sm text-center quantity-input"
                                                       id="quantity-<?php echo e($item['id']); ?>"
                                                       value="<?php echo e($item['quantity']); ?>" 
                                                       min="1"
                                                       <?php if($item['isFlashSale']): ?>
                                                           max="999"
                                                       <?php else: ?>
                                                           max="<?php echo e($item['product']->stock); ?>"
                                                       <?php endif; ?>
                                                       onchange="updateQuantity('<?php echo e($item['id']); ?>', this.value)">
                                                <button class="btn btn-outline-secondary btn-sm" 
                                                        type="button"
                                                            onclick="updateQuantity('<?php echo e($item['id']); ?>', <?php echo e($item['quantity'] + 1); ?>)"
                                                            <?php if(!$item['isFlashSale'] && $item['quantity'] >= $item['product']->stock): ?> disabled <?php endif; ?>>
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-danger" id="subtotal-<?php echo e($item['id']); ?>">
                                            <?php echo e(number_format($item['subtotal'], 0, ',', '.')); ?>đ
                                        </strong>
                                    </td>
                                    <td class="text-center">
                                        <form action="<?php echo e(route('cart.remove', $item['id'])); ?>" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-link text-danger p-0">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between pt-3 border-top">
                        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
                        </a>
                        <form action="<?php echo e(route('cart.clear')); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" 
                                    class="btn btn-outline-danger"
                                    onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">
                                <i class="bi bi-trash"></i> Xóa giỏ hàng
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Order Summary -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Tóm tắt đơn hàng</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <strong id="cart-total"><?php echo e(number_format($total, 0, ',', '.')); ?>đ</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển:</span>
                        <strong class="text-success">Miễn phí</strong>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <h6 class="mb-0">Tổng cộng:</h6>
                        <h5 class="text-danger mb-0" id="final-total">
                            <?php echo e(number_format($total, 0, ',', '.')); ?>đ
                        </h5>
                    </div>

                    <a href="<?php echo e(route('checkout.index')); ?>" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-credit-card"></i> Thanh toán
                    </a>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="bi bi-shield-check"></i>
                            Thanh toán an toàn & bảo mật
                        </small>
                    </div>
                </div>
            </div>

            <!-- Coupon Code -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Mã giảm giá</h6>
                    <form id="coupon-form" class="mb-3">
                        <div class="input-group">
                            <input type="text" 
                                   id="coupon-input"
                                   class="form-control" 
                                   placeholder="Nhập mã giảm giá"
                                   autocomplete="off">
                            <button class="btn btn-outline-primary" type="button" onclick="applyCoupon()">
                                Áp dụng
                            </button>
                        </div>
                        <small class="text-muted d-block mt-2" id="coupon-message"></small>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="text-center py-5">
        <i class="bi bi-cart-x display-1 text-muted"></i>
        <h4 class="mt-4">Giỏ hàng của bạn đang trống</h4>
        <p class="text-muted mb-4">Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary">
            <i class="bi bi-shop"></i> Khám phá sản phẩm
        </a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function updateQuantity(productId, quantity) {
    quantity = parseInt(quantity);
    
    if (quantity < 1) {
        alert('Số lượng phải lớn hơn 0');
        return;
    }

    fetch(`/gio-hang/cap-nhat/${productId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`quantity-${productId}`).value = quantity;
            document.getElementById(`subtotal-${productId}`).textContent = data.subtotal;
            document.getElementById('cart-total').textContent = data.total;
            document.getElementById('final-total').textContent = data.total;
        } else {
            alert(data.message);
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra, vui lòng thử lại!');
    });
}

function applyCoupon() {
    const code = document.getElementById('coupon-input').value.trim();
    if (!code) {
        alert('Vui lòng nhập mã giảm giá');
        return;
    }

    // Store coupon in session storage for now (you can send to server later)
    sessionStorage.setItem('coupon_code', code);
    
    // Show message
    const msg = document.getElementById('coupon-message');
    msg.textContent = '✓ Mã giảm giá sẽ được áp dụng tại thanh toán';
    msg.className = 'text-muted d-block mt-2 text-success';
    
    // Reset after 3 seconds
    setTimeout(() => {
        msg.textContent = '';
    }, 3000);
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/cart/index.blade.php ENDPATH**/ ?>