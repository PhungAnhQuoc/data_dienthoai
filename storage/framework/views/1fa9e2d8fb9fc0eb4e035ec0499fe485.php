<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <i class="bi bi-heart-fill text-danger"></i> Sản phẩm yêu thích
            </h1>
        </div>
    </div>

    <?php if($wishlistItems->count() > 0): ?>
        <div class="row">
            <?php $__currentLoopData = $wishlistItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <!-- Product Image -->
                        <div class="position-relative overflow-hidden" style="height: 250px; background: #f5f5f5;">
                            <?php if($item->product->images->first()): ?>
                                <img src="<?php echo e(asset('storage/' . $item->product->images->first()->image_path)); ?>" 
                                     alt="<?php echo e($item->product->name); ?>" 
                                     class="w-100 h-100 object-fit-cover">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/400x300?text=<?php echo e(urlencode($item->product->name)); ?>" 
                                     alt="<?php echo e($item->product->name); ?>" 
                                     class="w-100 h-100 object-fit-cover">
                            <?php endif; ?>
                            
                            <!-- Remove from Wishlist Button -->
                            <form action="<?php echo e(route('wishlist.destroy', $item->id)); ?>" method="POST" class="position-absolute top-0 end-0 m-2">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger rounded-circle" title="Xóa khỏi yêu thích">
                                    <i class="bi bi-heart-fill"></i>
                                </button>
                            </form>
                        </div>

                        <div class="card-body">
                            <!-- Product Name -->
                            <h5 class="card-title text-truncate mb-2">
                                <a href="<?php echo e(route('products.show', $item->product->slug)); ?>" class="text-decoration-none text-dark">
                                    <?php echo e($item->product->name); ?>

                                </a>
                            </h5>

                            <!-- Price -->
                            <div class="mb-3">
                                <span class="h5 text-primary fw-bold">
                                    <?php echo e(number_format($item->product->price, 0, ',', '.')); ?> ₫
                                </span>
                                <?php if($item->product->original_price && $item->product->original_price > $item->product->price): ?>
                                    <span class="text-muted text-decoration-line-through ms-2">
                                        <?php echo e(number_format($item->product->original_price, 0, ',', '.')); ?> ₫
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Add to Cart Button -->
                            <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="d-grid">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="product_id" value="<?php echo e($item->product->id); ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <div class="row mt-5">
            <div class="col-12">
                <?php echo e($wishlistItems->links()); ?>

            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center py-5" role="alert">
            <i class="bi bi-heart" style="font-size: 3rem; color: #ccc;"></i>
            <p class="mt-3 mb-0">Chưa có sản phẩm yêu thích nào. <a href="<?php echo e(route('products.index')); ?>">Tiếp tục mua sắm</a></p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/wishlist/index.blade.php ENDPATH**/ ?>