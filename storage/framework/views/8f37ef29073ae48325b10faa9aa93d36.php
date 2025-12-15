<!-- Search -->
<div class="mb-4">
    <label class="form-label fw-bold">Tìm kiếm</label>
    <input type="text" 
           class="form-control rounded-3" 
           name="search" 
           value="<?php echo e(request('search')); ?>"
           placeholder="Tên sản phẩm, SKU...">
</div>

<hr>

<!-- Categories -->
<div class="mb-4">
    <label class="form-label fw-bold">Danh mục</label>
    <div class="list-group list-group-flush">
        <a href="<?php echo e(route('products.index')); ?>" 
           class="list-group-item list-group-item-action border-0 <?php echo e(!request('category') ? 'active bg-primary text-white' : ''); ?>">
            Tất cả
        </a>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('products.index', ['category' => $category->slug])); ?>" 
           class="list-group-item list-group-item-action border-0 <?php echo e(request('category') == $category->slug ? 'active bg-primary text-white' : ''); ?>">
            <?php echo e($category->name); ?>

        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<hr>

<!-- Brands -->
<div class="mb-4">
    <label class="form-label fw-bold">Thương hiệu</label>
    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="form-check">
        <input class="form-check-input" 
               type="checkbox" 
               name="brand" 
               value="<?php echo e($brand->slug); ?>"
               id="brand_<?php echo e($brand->id); ?>"
               <?php echo e(request('brand') == $brand->slug ? 'checked' : ''); ?>>
        <label class="form-check-label" for="brand_<?php echo e($brand->id); ?>">
            <?php echo e($brand->name); ?>

        </label>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<hr>

<!-- Price Range -->
<div class="mb-4">
    <label class="form-label fw-bold">Khoảng giá (₫)</label>
    <div class="row g-2">
        <div class="col-6">
            <input type="number" 
                   class="form-control form-control-sm" 
                   name="price_from" 
                   value="<?php echo e(request('price_from')); ?>"
                   placeholder="Từ"
                   min="0">
        </div>
        <div class="col-6">
            <input type="number" 
                   class="form-control form-control-sm" 
                   name="price_to" 
                   value="<?php echo e(request('price_to')); ?>"
                   placeholder="Đến"
                   min="0">
        </div>
    </div>
</div>

<hr>

<!-- Status Filter -->
<div class="mb-4">
    <label class="form-label fw-bold">Trạng thái</label>
    <div class="form-check">
        <input class="form-check-input" 
               type="radio" 
               name="status" 
               value=""
               id="status_all"
               <?php echo e(!request('status') ? 'checked' : ''); ?>>
        <label class="form-check-label" for="status_all">
            Tất cả
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" 
               type="radio" 
               name="status" 
               value="featured"
               id="status_featured"
               <?php echo e(request('status') == 'featured' ? 'checked' : ''); ?>>
        <label class="form-check-label" for="status_featured">
            <span class="badge bg-warning">Nổi bật</span>
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" 
               type="radio" 
               name="status" 
               value="bestseller"
               id="status_bestseller"
               <?php echo e(request('status') == 'bestseller' ? 'checked' : ''); ?>>
        <label class="form-check-label" for="status_bestseller">
            <span class="badge bg-danger">Bán chạy</span>
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" 
               type="radio" 
               name="status" 
               value="sale"
               id="status_sale"
               <?php echo e(request('status') == 'sale' ? 'checked' : ''); ?>>
        <label class="form-check-label" for="status_sale">
            <span class="badge bg-success">Giảm giá</span>
        </label>
    </div>
</div>

<hr>

<!-- Rating Filter -->
<div class="mb-4">
    <label class="form-label fw-bold">Đánh giá</label>
    <div class="form-check">
        <input class="form-check-input" 
               type="radio" 
               name="min_rating" 
               value=""
               id="rating_all"
               <?php echo e(!request('min_rating') ? 'checked' : ''); ?>>
        <label class="form-check-label" for="rating_all">
            Tất cả
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" 
               type="radio" 
               name="min_rating" 
               value="4"
               id="rating_4"
               <?php echo e(request('min_rating') == '4' ? 'checked' : ''); ?>>
        <label class="form-check-label" for="rating_4">
            <span style="color: #FFC107;">★★★★</span><span style="color: #ddd;">★</span> 4+ sao
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" 
               type="radio" 
               name="min_rating" 
               value="3"
               id="rating_3"
               <?php echo e(request('min_rating') == '3' ? 'checked' : ''); ?>>
        <label class="form-check-label" for="rating_3">
            <span style="color: #FFC107;">★★★</span><span style="color: #ddd;">★★</span> 3+ sao
        </label>
    </div>
</div>

<hr>

<!-- Sort -->
<div class="mb-4">
    <label class="form-label fw-bold">Sắp xếp</label>
    <select class="form-select form-select-sm rounded-3" name="sort">
        <option value="latest" <?php echo e(request('sort') == 'latest' ? 'selected' : ''); ?>>Mới nhất</option>
        <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>Giá: Thấp - Cao</option>
        <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>Giá: Cao - Thấp</option>
        <option value="bestseller" <?php echo e(request('sort') == 'bestseller' ? 'selected' : ''); ?>>Bán chạy</option>
        <option value="featured" <?php echo e(request('sort') == 'featured' ? 'selected' : ''); ?>>Nổi bật</option>
    </select>
</div>

<!-- Buttons -->
<div class="d-grid gap-2">
    <button type="submit" class="btn btn-primary btn-sm rounded-3">
        <i class="bi bi-search me-2"></i>Áp dụng bộ lọc
    </button>
    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-secondary btn-sm rounded-3">
        <i class="bi bi-arrow-clockwise me-2"></i>Đặt lại
    </a>
</div>
<?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/products/partials/filter-form.blade.php ENDPATH**/ ?>