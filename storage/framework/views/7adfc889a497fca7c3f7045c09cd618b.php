<?php $__env->startSection('title', 'Thanh toán - MobileShop'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row gx-4">
        <!-- Left: Checkout form -->
        <div class="col-lg-8">
            <form action="<?php echo e(route('checkout.store')); ?>" method="POST" id="checkout-form">
                <?php echo csrf_field(); ?>

                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="mb-3">Thông tin giao hàng</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="shipping_name" class="form-control" placeholder="Họ và tên" value="<?php echo e(old('shipping_name', $user->name)); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <input type="tel" name="shipping_phone" class="form-control" placeholder="Số điện thoại" value="<?php echo e(old('shipping_phone', $user->phone)); ?>" required>
                            </div>
                            <div class="col-12">
                                <input type="email" name="shipping_email" class="form-control" placeholder="Email" value="<?php echo e(old('shipping_email', $user->email)); ?>">
                            </div>
                            <div class="col-12">
                                <input type="text" name="shipping_address" class="form-control" placeholder="Địa chỉ (số nhà, đường, phường,... )" value="<?php echo e(old('shipping_address', $user->address)); ?>" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="mb-3">Vận chuyển</h6>
                        <div class="list-group">
                            <label class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-bold">Giao hàng tiêu chuẩn</div>
                                    <div class="small text-muted">Dự kiến 2-4 ngày</div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold">30.000₫</div>
                                    <input class="form-check-input mt-2" type="radio" name="shipping_method" value="standard" checked>
                                </div>
                            </label>
                            <label class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-bold">Giao hàng hỏa tốc</div>
                                    <div class="small text-muted">Giao trong ngày</div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold">50.000₫</div>
                                    <input class="form-check-input mt-2" type="radio" name="shipping_method" value="fast">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="mb-3">Thanh toán</h6>

                        <?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($method->name !== 'vnpay'): ?>
                            <div class="form-check mb-3 p-3 border rounded" data-method-name="<?php echo e($method->name); ?>">
                                <input class="form-check-input" type="radio" name="payment_method_id" id="payment_<?php echo e($method->id); ?>" value="<?php echo e($method->id); ?>" data-name="<?php echo e($method->name); ?>" <?php echo e($loop->first && $method->name !== 'vnpay' ? 'checked' : ($loop->first ? '' : '')); ?>>
                                <label class="form-check-label ms-3" for="payment_<?php echo e($method->id); ?>">
                                    <strong><?php echo e($method->display_name); ?></strong>
                                    <div class="small text-muted"><?php echo e($method->description); ?></div>
                                </label>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div id="bank-transfer-info" class="mt-3" style="display:none;">
                            <?php if(isset($bankAccounts) && $bankAccounts->count()): ?>
                                <?php $__currentLoopData = $bankAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="card mb-2">
                                        <div class="card-body d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="fw-bold"><?php echo e($bank->bank_name); ?></div>
                                                <div>Số tài khoản: <code><?php echo e($bank->account_number); ?></code></div>
                                                <div>Chủ tài khoản: <?php echo e($bank->account_holder); ?></div>
                                            </div>
                                            <div style="width:140px;">
                                                <?php if(!empty($bank->qr_code)): ?>
                                                    <img src="<?php echo e((filter_var($bank->qr_code, FILTER_VALIDATE_URL) ? $bank->qr_code : asset($bank->qr_code))); ?>" alt="QR" class="img-fluid">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>

                        <div id="card-payment-form" class="mt-3" style="display:none;">
                            <div class="mb-3">
                                <label class="form-label">Số thẻ</label>
                                <input type="text" name="card_number" class="form-control" placeholder="1234 5678 9012 3456">
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label class="form-label">Tháng/Năm</label>
                                    <input type="text" name="card_exp" class="form-control" placeholder="MM/YY">
                                </div>
                                <div class="col-4">
                                    <label class="form-label">CVC</label>
                                    <input type="text" name="card_cvc" class="form-control" placeholder="123">
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Chủ thẻ</label>
                                    <input type="text" name="card_name" class="form-control" placeholder="Nguyễn Văn A">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="hidden-coupon" name="promotion_code" value="">

                <button type="submit" class="btn btn-primary btn-lg w-100 mb-4" id="checkout-btn">
                    <i class="bi bi-check-circle me-2"></i>Đặt hàng
                </button>
            </form>
        </div>

        <!-- Right: summary -->
        <div class="col-lg-4">
            <div class="card sticky-top" style="top:20px;">
                <div class="card-body">
                    <h5 class="card-title">Tóm tắt đơn hàng</h5>
                    <ul class="list-group list-group-flush mb-3">
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold"><?php echo e($item['name']); ?></div>
                                    <div class="small text-muted">x<?php echo e($item['quantity']); ?></div>
                                </div>
                                <div class="text-end">
                                    <div><?php echo e(number_format($item['price'] * $item['quantity'], 0, ',', '.')); ?>₫</div>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                    <div class="d-flex justify-content-between mb-2">
                        <div class="text-muted">Tạm tính</div>
                        <div class="fw-bold" id="summary-subtotal"><?php echo e(number_format($subtotal, 0, ',', '.')); ?>₫</div>
                    </div>
                    
                    <!-- Coupon Discount -->
                    <div id="discount-section" style="display:none;">
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <div class="text-muted">Giảm giá</div>
                            <div class="fw-bold" id="summary-discount">0₫</div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <div class="text-muted">Phí vận chuyển</div>
                        <div class="fw-bold" id="summary-shipping"><?php echo e(number_format($shipping ?? 30000, 0, ',', '.')); ?>₫</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="text-muted">Thuế (10%)</div>
                        <div class="fw-bold" id="summary-tax"><?php echo e(number_format($tax ?? 0, 0, ',', '.')); ?>₫</div>
                    </div>
                    <hr>
                    
                    <!-- Coupon Code Input -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Mã giảm giá</label>
                        <div class="input-group input-group-sm">
                            <input type="text" 
                                   id="checkout-coupon"
                                   class="form-control" 
                                   placeholder="Nhập mã..."
                                   autocomplete="off">
                            <button class="btn btn-outline-primary" type="button" onclick="applyCouponCheckout()">
                                Áp dụng
                            </button>
                        </div>
                        <small id="coupon-msg-checkout" class="d-block mt-1"></small>
                    </div>
                    
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold">Tổng cộng</div>
                        <div class="fs-5 text-primary fw-bold" id="summary-total"><?php echo e(number_format($total, 0, ',', '.')); ?>₫</div>
                    </div>

                    <button type="submit" form="checkout-form" class="btn btn-primary w-100">Đặt hàng và thanh toán</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle payment method change
    document.querySelectorAll('input[name="payment_method_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const methodName = this.dataset.name;
            
            // Hide all payment forms
            document.getElementById('bank-transfer-info').style.display = 'none';
            document.getElementById('card-payment-form').style.display = 'none';
            
            // Show relevant form based on selected payment method
            if (methodName === 'bank-transfer') {
                document.getElementById('bank-transfer-info').style.display = 'block';
            } else if (methodName === 'credit-card') {
                document.getElementById('card-payment-form').style.display = 'block';
            }
        });
    });

    // Trigger change event to show/hide based on initial selection
    const initialChecked = document.querySelector('input[name="payment_method_id"]:checked');
    if (initialChecked) {
        initialChecked.dispatchEvent(new Event('change'));
    }

    // Handle form submission
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const selectedPaymentMethod = document.querySelector('input[name="payment_method_id"]:checked');
        const paymentMethodId = selectedPaymentMethod?.value;
        
        // Find the payment method name
        let paymentMethodName = '';
        document.querySelectorAll('input[name="payment_method_id"]').forEach(input => {
            if (input.value === paymentMethodId) {
                paymentMethodName = input.dataset.name;
            }
        });
        
        // If VNPay is selected, submit the form normally first to create the order
        // Then redirect to VNPay payment
        if (paymentMethodName === 'vnpay') {
            // Submit form to create order
            const formData = new FormData(this);
            
            fetch('<?php echo e(route("checkout.store")); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.redirected) {
                    // Extract order ID from redirect URL
                    const url = new URL(response.url);
                    const orderId = url.pathname.split('/').pop();
                    
                    // Redirect to VNPay payment
                    window.location.href = '<?php echo e(route("payment.vnpay", ":orderId")); ?>'.replace(':orderId', orderId);
                } else {
                    return response.text().then(text => {
                        document.open();
                        document.write(text);
                        document.close();
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi đặt hàng');
            });
        } else {
            // For other payment methods, submit normally
            this.submit();
        }
    });

    function recalcTotals() {
        const subtotal = Number(<?php echo e($subtotal ?? 0); ?>);
        const shippingFee = document.querySelector('input[name="shipping_method"]:checked')?.value === 'fast' ? 50000 : 30000;
        const tax = Math.round(subtotal * 0.10);
        const discount = Number(document.getElementById('hidden-coupon').value || 0);
        var total = subtotal + shippingFee + tax - discount;

        document.getElementById('summary-subtotal').textContent = formatVND(subtotal);
        document.getElementById('summary-shipping').textContent = formatVND(shippingFee);
        document.getElementById('summary-tax').textContent = formatVND(tax);
        document.getElementById('summary-total').textContent = formatVND(total);
    }

    function formatVND(num) {
        return num.toLocaleString('vi-VN') + '₫';
    }

    document.querySelectorAll('input[name="shipping_method"]').forEach(r => r.addEventListener('change', recalcTotals));
    recalcTotals();
});

function applyCouponCheckout() {
    const code = document.getElementById('checkout-coupon').value.trim().toUpperCase();
    if (!code) {
        alert('Vui lòng nhập mã giảm giá');
        return;
    }

    // Call API to validate coupon
    fetch('<?php echo e(route("checkout.validate-coupon")); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ code: code })
    })
    .then(response => response.json())
    .then(data => {
        const msg = document.getElementById('coupon-msg-checkout');
        if (data.success) {
            // Save to hidden field
            document.getElementById('hidden-coupon').value = data.discount;
            
            // Update discount display
            const discountSection = document.getElementById('discount-section');
            discountSection.style.display = 'block';
            document.getElementById('summary-discount').textContent = data.discount_text + '₫';
            
            // Recalculate total with current shipping method
            const subtotal = Number(<?php echo e($subtotal ?? 0); ?>);
            const shippingFee = document.querySelector('input[name="shipping_method"]:checked')?.value === 'fast' ? 50000 : 30000;
            const tax = Math.round(subtotal * 0.10);
            const discount = data.discount;
            const newTotal = subtotal + shippingFee + tax - discount;
            
            document.getElementById('summary-total').textContent = newTotal.toLocaleString('vi-VN') + '₫';
            
            msg.textContent = '✓ ' + data.message;
            msg.className = 'text-success fw-bold';
            
            document.getElementById('checkout-coupon').disabled = true;
        } else {
            msg.textContent = '✗ ' + data.message;
            msg.className = 'text-danger fw-bold';
            document.getElementById('hidden-coupon').value = '';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('coupon-msg-checkout').textContent = '✗ Có lỗi xảy ra';
        document.getElementById('coupon-msg-checkout').className = 'text-danger fw-bold';
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/checkout/index.blade.php ENDPATH**/ ?>