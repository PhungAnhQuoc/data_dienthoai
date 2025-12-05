<?php $__env->startSection('title', 'Liên hệ'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1>
            <i class="bi bi-envelope"></i> Tin nhắn liên hệ
        </h1>
        <p class="text-muted">Quản lý các tin nhắn từ khách hàng</p>
    </div>
    <span class="badge bg-danger fs-6">
        <?php echo e($unread); ?> tin mới
    </span>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Người gửi</th>
                    <th>Email</th>
                    <th>Tiêu đề</th>
                    <th>Trạng thái</th>
                    <th>Ngày gửi</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <strong><?php echo e($message->name); ?></strong>
                                <?php if($message->phone): ?>
                                    <br><small class="text-muted"><?php echo e($message->phone); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="mailto:<?php echo e($message->email); ?>" class="text-decoration-none">
                                    <?php echo e($message->email); ?>

                                </a>
                            </td>
                            <td>
                                <strong><?php echo e(Str::limit($message->subject, 50)); ?></strong>
                            </td>
                            <td>
                                <?php if($message->status === 'pending'): ?>
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-exclamation-circle"></i> Chưa đọc
                                    </span>
                                <?php elseif($message->status === 'read'): ?>
                                    <span class="badge bg-info text-white">
                                        <i class="bi bi-eye"></i> Đã đọc
                                    </span>
                                <?php elseif($message->status === 'replied'): ?>
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Đã phản hồi
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted small">
                                <?php echo e($message->created_at->format('d/m/Y H:i')); ?>

                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.contact.show', $message)); ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Xem
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="mt-3 mb-0">Chưa có tin nhắn nào</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        <?php echo e($messages->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/admin/contact/index.blade.php ENDPATH**/ ?>