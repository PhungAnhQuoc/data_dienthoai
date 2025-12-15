<?php $__env->startSection('title', 'Tra cứu đơn hàng - MobileShop'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <!-- Search Section -->
    <div class="bg-light rounded-3 p-5 mb-5">
        <h2 class="text-center mb-2">Tra cứu đơn hàng</h2>
        <p class="text-center text-muted mb-4">Nhập mã đơn hàng hoặc số điện thoại để xem trạng thái giao hàng</p>
        
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="<?php echo e(route('orders.tracking.search')); ?>" method="POST" class="d-flex flex-column gap-3">
                    <?php echo csrf_field(); ?>
                    <input type="text" 
                           class="form-control form-control-lg <?php $__errorArgs = ['order_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           name="order_number" 
                           placeholder="Mã đơn hàng (ví dụ: ORD-202512001)"
                           value="<?php echo e(old('order_number')); ?>"
                           required>
                    <input type="email" 
                           class="form-control form-control-lg <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           name="email" 
                           placeholder="Email đặt hàng"
                           value="<?php echo e(old('email')); ?>"
                           required>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-search me-2"></i>Tra cứu
                    </button>
                </form>
                <?php $__errorArgs = ['order_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger small mt-2"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger small mt-2"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
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

    <!-- Help Section -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">
                        <i class="bi bi-question-circle me-2"></i>Không tìm thấy đơn hàng?
                    </h6>
                    <ul class="mb-0 ps-3">
                        <li class="mb-2">Kiểm tra lại mã đơn hàng trong email xác nhận</li>
                        <li class="mb-2">
                            Nếu đã đăng nhập, bạn có thể xem đơn hàng tại 
                            <a href="<?php echo e(route('account.orders')); ?>" class="text-decoration-none fw-bold">tài khoản của tôi</a>
                        </li>
                        <li>
                            Liên hệ với chúng tôi qua 
                            <a href="<?php echo e(route('contact.index')); ?>" class="text-decoration-none fw-bold">trang liên hệ</a>
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