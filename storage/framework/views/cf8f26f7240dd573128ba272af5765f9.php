<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Cài đặt</h1>
            <small class="text-muted">Quản lý các cài đặt chung cho website của bạn.</small>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <!-- Notifications Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Quản lý Thông báo toàn hệ thống</h5>
                    <p class="text-muted">Gửi thông báo đến tất cả người dùng trên toàn bộ trang web.</p>

                    <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <label class="form-label">Nội dung thông báo</label>
                            <textarea name="notify_message" class="form-control" rows="4" placeholder="Nhập nội dung thông báo của bạn ở đây..."></textarea>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <label class="form-label">Loại thông báo</label>
                                <select name="notify_type" class="form-select">
                                    <option value="info">Thông tin</option>
                                    <option value="warning">Cảnh báo</option>
                                    <option value="important">Quan trọng</option>
                                </select>
                            </div>
                            <div class="col-md-4 text-end mt-3 mt-md-0">
                                <button type="submit" name="send_notification" value="1" class="btn btn-primary">
                                    <i class="bi bi-send me-1"></i> Gửi thông báo
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Maintenance Card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="card-title mb-0">Chế độ Bảo trì</h5>
                            <small class="text-muted">Bật/tắt chế độ bảo trì cho toàn bộ trang web.</small>
                        </div>
                        <div>
                            <form id="maintenance-toggle-form" action="<?php echo e(route('admin.settings.update')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="maintenance_enabled" name="maintenance_enabled" value="1" <?php echo e(optional($settings)->maintenance_enabled ? 'checked' : ''); ?> onchange="document.getElementById('maintenance-toggle-form').submit()">
                                    <label class="form-check-label" for="maintenance_enabled"><?php echo e(optional($settings)->maintenance_enabled ? 'Bật' : 'Tắt'); ?></label>
                                </div>
                            </form>
                        </div>
                    </div>

                    <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Thời gian bắt đầu</label>
                                <input type="datetime-local" name="maintenance_starts_at" class="form-control" value="">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Thời gian kết thúc</label>
                                <input type="datetime-local" name="maintenance_ends_at" class="form-control" value="<?php echo e(optional($settings->maintenance_ends_at)->format('Y-m-d\TH:i') ?? ''); ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Thông báo bảo trì</label>
                            <textarea class="form-control" name="maintenance_message" rows="3" placeholder="Website đang trong quá trình bảo trì. Vui lòng quay lại sau."><?php echo e(optional($settings)->maintenance_message); ?></textarea>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-success">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Help / Info Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="mb-2">Ghi chú</h6>
                    <p class="small text-muted">Khi chế độ bảo trì được bật, người dùng (không phải admin) sẽ thấy trang thông báo bảo trì. Bạn có thể đặt thời gian kết thúc để tự động cho phép truy cập lại.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>