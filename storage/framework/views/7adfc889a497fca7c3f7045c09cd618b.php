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
                            <div class="form-check mb-3 p-3 border rounded" data-method-name="<?php echo e($method->name); ?>">
                                <input class="form-check-input" type="radio" name="payment_method_id" id="payment_<?php echo e($method->id); ?>" value="<?php echo e($method->id); ?>" data-name="<?php echo e($method->name); ?>" <?php echo e($loop->first ? 'checked' : ''); ?>>
                                <label class="form-check-label ms-3" for="payment_<?php echo e($method->id); ?>">
                                    <strong><?php echo e($method->display_name); ?></strong>
                                    <div class="small text-muted"><?php echo e($method->description); ?></div>
                                </label>
                            </div>
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

                <button type="submit" class="btn btn-primary btn-lg w-100 mb-4">
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
                    <div class="d-flex justify-content-between mb-2">
                        <div class="text-muted">Phí vận chuyển</div>
                        <div class="fw-bold" id="summary-shipping"><?php echo e(number_format($shipping ?? 30000, 0, ',', '.')); ?>₫</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="text-muted">Thuế (10%)</div>
                        <div class="fw-bold" id="summary-tax"><?php echo e(number_format($tax ?? 0, 0, ',', '.')); ?>₫</div>
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
    function formatVND(n){
        return n.toLocaleString('vi-VN') + '₫';
    }

    // payment sections
    function updatePaymentSections(){
        var sel = document.querySelector('input[name="payment_method_id"]:checked');
        if(!sel) return;
        var name = (sel.dataset.name || '').toLowerCase();
        if(name.includes('bank') || name.includes('chuyển khoản')){
            document.getElementById('bank-transfer-info').style.display = 'block';
            document.getElementById('card-payment-form').style.display = 'none';
        } else if(name.includes('card') || name.includes('thẻ')){
            document.getElementById('bank-transfer-info').style.display = 'none';
            document.getElementById('card-payment-form').style.display = 'block';
        } else {
            document.getElementById('bank-transfer-info').style.display = 'none';
            document.getElementById('card-payment-form').style.display = 'none';
        }
    }

    document.querySelectorAll('input[name="payment_method_id"]').forEach(function(r){
        r.addEventListener('change', updatePaymentSections);
    });
    updatePaymentSections();

    // shipping fee update and total recalc
    function recalcTotals(){
        var subtotal = Number(<?php echo e($subtotal ?? 0); ?>);
        var shippingFee = document.querySelector('input[name="shipping_method"]:checked')?.value === 'fast' ? 50000 : 30000;
        var tax = Math.round(subtotal * 0.10);
        var total = subtotal + shippingFee + tax;

        document.getElementById('summary-subtotal').textContent = formatVND(subtotal);
        document.getElementById('summary-shipping').textContent = formatVND(shippingFee);
        document.getElementById('summary-tax').textContent = formatVND(tax);
        document.getElementById('summary-total').textContent = formatVND(total);
    }

    document.querySelectorAll('input[name="shipping_method"]').forEach(r => r.addEventListener('change', recalcTotals));
    recalcTotals();
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/checkout/index.blade.php ENDPATH**/ ?>