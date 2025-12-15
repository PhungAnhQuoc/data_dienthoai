

<?php $__env->startSection('title', 'Chỉnh Sửa Flash Sale'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1>Chỉnh Sửa Flash Sale</h1>
        <p class="text-muted">Cập nhật thông tin khuyến mãi flash sale</p>
    </div>
    <a href="<?php echo e(route('admin.flash-sales.index')); ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Quay Lại
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?php echo e(route('admin.flash-sales.update', $flashSale->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="row">
                <!-- Thông Tin Cơ Bản -->
                <div class="col-md-8">
                    <h5 class="mb-4 fw-bold">Thông Tin Flash Sale</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Chọn Sản Phẩm (Tùy Chọn)</label>
                        <select class="form-select <?php $__errorArgs = ['product_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                name="product_id" id="productSelect">
                            <option value="">-- Không chọn sản phẩm --</option>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>" 
                                        data-name="<?php echo e($product->name); ?>"
                                        data-price="<?php echo e($product->price); ?>"
                                        <?php echo e(old('product_id', $flashSale->product_id) == $product->id ? 'selected' : ''); ?>>
                                    <?php echo e($product->name); ?> (<?php echo e(number_format($product->price, 0, ',', '.')); ?>₫)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['product_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tên Flash Sale <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               name="title" value="<?php echo e(old('title', $flashSale->title)); ?>" 
                               placeholder="VD: iPhone 15 Pro Max" required>
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô Tả</label>
                        <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  name="description" rows="3"
                                  placeholder="Mô tả ngắn về sản phẩm flash sale..."><?php echo e(old('description', $flashSale->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giá Gốc <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?php $__errorArgs = ['original_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   name="original_price" value="<?php echo e(old('original_price', $flashSale->original_price)); ?>" 
                                   step="1000" min="0" required>
                            <?php $__errorArgs = ['original_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giá Khuyến Mãi <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?php $__errorArgs = ['sale_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   name="sale_price" value="<?php echo e(old('sale_price', $flashSale->sale_price)); ?>" 
                                   step="1000" min="0" required>
                            <?php $__errorArgs = ['sale_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số Lượng <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   name="stock" value="<?php echo e(old('stock', $flashSale->stock)); ?>" min="1" required>
                            <small class="text-muted">Đã bán: <?php echo e($flashSale->sold); ?></small>
                            <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Màu Badge <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color <?php $__errorArgs = ['color_badge'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       name="color_badge" value="<?php echo e(old('color_badge', $flashSale->color_badge)); ?>" required>
                                <input type="text" class="form-control" value="<?php echo e(old('color_badge', $flashSale->color_badge)); ?>" readonly>
                            </div>
                            <?php $__errorArgs = ['color_badge'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <h5 class="mb-3 fw-bold mt-5">Thời Gian Flash Sale</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bắt Đầu Lúc <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control <?php $__errorArgs = ['starts_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   name="starts_at" 
                                   value="<?php echo e(old('starts_at', $flashSale->starts_at->format('Y-m-d\TH:i'))); ?>" required>
                            <?php $__errorArgs = ['starts_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kết Thúc Lúc <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control <?php $__errorArgs = ['ends_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   name="ends_at" 
                                   value="<?php echo e(old('ends_at', $flashSale->ends_at->format('Y-m-d\TH:i'))); ?>" required>
                            <?php $__errorArgs = ['ends_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Hình Ảnh & Cài Đặt -->
                <div class="col-md-4">
                    <h5 class="mb-4 fw-bold">Hình Ảnh & Cài Đặt</h5>

                    <div class="mb-3">
                        <label class="form-label">Hình Ảnh</label>
                        <div class="mb-2">
                            <input type="file" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   name="image" accept="image/*" id="flashSaleImage">
                            <small class="text-muted">Để trống nếu không muốn thay đổi</small>
                            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div id="imagePreview" class="mt-3">
                            <?php if($flashSale->image): ?>
                                <img src="<?php echo e(asset('storage/' . $flashSale->image)); ?>" 
                                     style="max-width: 200px; max-height: 200px; border-radius: 8px; object-fit: cover;">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Độ Ưu Tiên</label>
                        <input type="number" class="form-control" name="sort_order" 
                               value="<?php echo e(old('sort_order', $flashSale->sort_order)); ?>" min="0">
                        <small class="text-muted">Số càng nhỏ, vị trí càng trước</small>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" 
                               value="1" id="flashSaleActive" 
                               <?php echo e(old('is_active', $flashSale->is_active) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="flashSaleActive">
                            Kích Hoạt Flash Sale
                        </label>
                    </div>

                    <div class="alert alert-info">
                        <strong>📊 Thống Kê:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Tổng: <?php echo e($flashSale->stock); ?> sản phẩm</li>
                            <li>Đã bán: <?php echo e($flashSale->sold); ?> sản phẩm</li>
                            <li>Còn lại: <?php echo e($flashSale->getRemainingStock()); ?> sản phẩm</li>
                            <li>Tỉ lệ bán: <?php echo e($flashSale->getSoldPercentage()); ?>%</li>
                        </ul>
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Cập Nhật Flash Sale
                </button>
                <a href="<?php echo e(route('admin.flash-sales.index')); ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Hủy
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.page-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.page-header h1 {
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 5px;
}
</style>

<script>
document.getElementById('productSelect').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    
    if (this.value) {
        const name = selectedOption.dataset.name;
        const price = selectedOption.dataset.price;
        
        document.querySelector('input[name="title"]').value = name;
        document.querySelector('input[name="original_price"]').value = price;
        
        // Optional: Set sale price to 80% of original
        document.querySelector('input[name="sale_price"]').value = Math.floor(price * 0.8);
    }
});

document.getElementById('flashSaleImage').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(event) {
            preview.innerHTML = '<img src="' + event.target.result + 
                              '" style="max-width: 200px; max-height: 200px; border-radius: 8px; object-fit: cover;">';
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

// Update color display
document.querySelector('input[name="color_badge"]').addEventListener('change', function(e) {
    document.querySelector('input[readonly]').value = e.target.value;
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/admin/flash-sales/edit.blade.php ENDPATH**/ ?>