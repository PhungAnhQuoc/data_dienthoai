<!-- Toast Helper - Thêm vào view bất kỳ nơi bạn muốn hiển thị toast -->
<!-- 
    Cách sử dụng:
    
    1. Trong Blade view, thêm phần tử này để hiển thị toast:
    <?php if($message = Session::get('success')): ?>
        <div data-toast-success="<?php echo e($message); ?>"></div>
    <?php endif; ?>
    
    2. Hoặc sử dụng JavaScript trực tiếp:
    <script>
        Toast.success('Đã thêm sản phẩm vào giỏ hàng');
        Toast.error('Có lỗi xảy ra');
        Toast.warning('Cảnh báo');
        Toast.info('Thông tin');
    </script>
    
    3. Trong controller Laravel:
    return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
-->

<div class="toast-helpers">
    <!-- Hiển thị session messages tự động -->
    <?php if($errors->any()): ?>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div data-toast-error="<?php echo e($error); ?>"></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div data-toast-success="<?php echo e(session('success')); ?>"></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div data-toast-error="<?php echo e(session('error')); ?>"></div>
    <?php endif; ?>

    <?php if(session('warning')): ?>
        <div data-toast-warning="<?php echo e(session('warning')); ?>"></div>
    <?php endif; ?>

    <?php if(session('info')): ?>
        <div data-toast-info="<?php echo e(session('info')); ?>"></div>
    <?php endif; ?>
</div>

<script>
    // Hỗ trợ sử dụng Toast từ bất kỳ nơi đâu
    window.showToast = function(message, type = 'info', title = null) {
        if (window.Toast) {
            window.Toast[type](message, title);
        }
    };
</script>
<?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/partials/toast-helper.blade.php ENDPATH**/ ?>