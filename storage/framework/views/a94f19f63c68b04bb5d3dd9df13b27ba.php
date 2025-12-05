<?php $__env->startSection('title', 'Chi tiết Tin nhắn'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header mb-4">
    <div>
        <a href="<?php echo e(route('admin.contact.index')); ?>" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
        <h1><?php echo e($contactMessage->subject); ?></h1>
        <p class="text-muted">Từ: <?php echo e($contactMessage->name); ?> (<?php echo e($contactMessage->email); ?>)</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-light border-bottom">
                <h5 class="mb-0">
                    <i class="bi bi-envelope-open"></i> Nội dung tin nhắn
                </h5>
            </div>
            <div class="card-body">
                <!-- From Information -->
                <div class="mb-4 pb-3 border-bottom">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="small text-muted mb-1">Từ</p>
                            <p class="mb-0">
                                <strong><?php echo e($contactMessage->name); ?></strong><br>
                                    <a href="mailto:<?php echo e($contactMessage->email); ?>" class="text-decoration-none">
                                        <?php echo e($contactMessage->email); ?>

                                    </a>
                                    <?php if($contactMessage->phone): ?>
                                        <br>
                                        <a href="tel:<?php echo e($contactMessage->phone); ?>" class="text-decoration-none">
                                            <?php echo e($contactMessage->phone); ?>

                                        </a>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="small text-muted mb-1">Ngày gửi</p>
                                <p class="mb-0"><?php echo e($contactMessage->created_at->format('d/m/Y H:i')); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Message Content -->
                    <div class="mb-4">
                        <p class="text-muted"><?php echo e(nl2br(e($contactMessage->message))); ?></p>
                    </div>

                    <!-- Admin Reply -->
                    <?php if($contactMessage->admin_reply): ?>
                        <div class="alert alert-success mb-0">
                            <h6 class="fw-bold mb-2">
                                <i class="bi bi-chat-left-text"></i> Phản hồi của Admin
                            </h6>
                            <p class="mb-2"><?php echo e(nl2br(e($contactMessage->admin_reply))); ?></p>
                            <small class="text-muted">
                                Phản hồi vào: <?php echo e($contactMessage->replied_at->format('d/m/Y H:i')); ?>

                            </small>
                        </div>
                    <?php else: ?>
                        <!-- Reply Form -->
                        <form action="<?php echo e(route('admin.contact.reply', $contactMessage)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label for="admin_reply" class="form-label fw-bold">Phản hồi</label>
                                <textarea class="form-control <?php $__errorArgs = ['admin_reply'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          id="admin_reply" name="admin_reply" rows="6" 
                                          placeholder="Nhập phản hồi của bạn..." required></textarea>
                                <?php $__errorArgs = ['admin_reply'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Gửi phản hồi
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0">Trạng thái</h6>
                </div>
                <div class="card-body">
                    <?php if($contactMessage->status === 'pending'): ?>
                        <span class="badge bg-warning text-dark p-2">
                            <i class="bi bi-exclamation-circle"></i> Chưa đọc
                        </span>
                    <?php elseif($contactMessage->status === 'read'): ?>
                        <span class="badge bg-info text-white p-2">
                            <i class="bi bi-eye"></i> Đã đọc
                        </span>
                    <?php elseif($contactMessage->status === 'replied'): ?>
                        <span class="badge bg-success p-2">
                            <i class="bi bi-check-circle"></i> Đã phản hồi
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Actions -->
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0">Hành động</h6>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.contact.destroy', $contactMessage)); ?>" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash"></i> Xóa tin nhắn
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/admin/contact/show.blade.php ENDPATH**/ ?>