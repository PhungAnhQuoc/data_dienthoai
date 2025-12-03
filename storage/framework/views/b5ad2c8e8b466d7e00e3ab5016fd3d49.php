<?php $__env->startSection('title', 'Tra cứu đơn hàng - MobileShop'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h2>Tra cứu đơn hàng</h2>
                <p class="text-muted">Nhập mã đơn hàng và email để kiểm tra trạng thái đơn hàng của bạn</p>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <strong>Lỗi!</strong> <?php echo e($errors->first()); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="<?php echo e(route('orders.tracking.search')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="mb-4">
                            <label for="order_number" class="form-label fw-bold">Mã đơn hàng *</label>
                            <input type="text" 
                                   class="form-control form-control-lg <?php $__errorArgs = ['order_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="order_number" 
                                   name="order_number" 
                                   placeholder="VD: ĐH123456"
                                   value="<?php echo e(old('order_number')); ?>"
                                   required>
                            <?php $__errorArgs = ['order_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle me-1"></i>Mã đơn hàng được gửi trong email xác nhận đặt hàng của bạn
                            </small>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Email *</label>
                            <input type="email" 
                                   class="form-control form-control-lg <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="email" 
                                   name="email" 
                                   placeholder="email@example.com"
                                   value="<?php echo e(old('email')); ?>"
                                   required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle me-1"></i>Email được sử dụng khi đặt hàng
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-search me-2"></i>Tìm kiếm
                        </button>
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="card mt-4 bg-light border-0">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">
                        <i class="bi bi-question-circle me-2"></i>Không tìm thấy đơn hàng?
                    </h6>
                    <ul class="mb-0 ps-3">
                        <li class="mb-2">Kiểm tra lại mã đơn hàng trong email xác nhận</li>
                        <li class="mb-2">Đảm bảo email nhập đúng với email đặt hàng</li>
                        <li class="mb-2">
                            Nếu đã đăng nhập, bạn có thể xem đơn hàng tại 
                            <a href="<?php echo e(route('account.orders')); ?>" class="text-decoration-none">tài khoản của tôi</a>
                        </li>
                        <li>
                            Liên hệ với chúng tôi qua 
                            <a href="<?php echo e(route('contact.index')); ?>" class="text-decoration-none">trang liên hệ</a>
                        </li>
                    </ul>
                </div>
            </div>

            <?php if(Auth::check()): ?>
                <div class="mt-4 text-center">
                    <p class="text-muted mb-2">Bạn đã đăng nhập?</p>
                    <a href="<?php echo e(route('account.orders')); ?>" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-right me-2"></i>Xem đơn hàng của tôi
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/orders/tracking.blade.php ENDPATH**/ ?>