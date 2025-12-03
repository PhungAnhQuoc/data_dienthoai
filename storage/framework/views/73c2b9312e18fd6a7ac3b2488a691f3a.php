<footer class="site-footer bg-white text-dark pt-5 mt-4 border-top">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-4">
                <h5 class="mb-3"><?php echo e(config('app.name')); ?></h5>
                <p class="small text-muted">Cửa hàng điện thoại uy tín, chất lượng hàng đầu với giá cả phải chăng.</p>
                <p class="small mb-1">Địa chỉ: 123 Đường ABC, Quận 1, TP. HCM</p>
                <p class="small mb-1">Điện thoại: <a href="tel:+842838123456" class="text-decoration-none">(028) 3812 3456</a></p>
                <p class="small">Email: <a href="mailto:support@mobileshop.com" class="text-decoration-none">support@mobileshop.com</a></p>
            </div>

            <div class="col-md-2">
                <h6 class="mb-3">Liên kết nhanh</h6>
                <ul class="list-unstyled small">
                    <li><a href="<?php echo e(route('home')); ?>" class="text-dark text-decoration-none">Trang chủ</a></li>
                    <li><a href="<?php echo e(route('products.index')); ?>" class="text-dark text-decoration-none">Sản phẩm</a></li>
                    <li><a href="<?php echo e(route('blog.index')); ?>" class="text-dark text-decoration-none">Tin tức</a></li>
                    <li><a href="<?php echo e(route('contact.index')); ?>" class="text-dark text-decoration-none">Liên hệ</a></li>
                </ul>
            </div>

            <div class="col-md-2">
                <h6 class="mb-3">Chính sách</h6>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-dark text-decoration-none">Chính sách bảo mật</a></li>
                    <li><a href="#" class="text-dark text-decoration-none">Điều khoản dịch vụ</a></li>
                    <li><a href="#" class="text-dark text-decoration-none">Chính sách đổi trả</a></li>
                    <li><a href="#" class="text-dark text-decoration-none">Chính sách vận chuyển</a></li>
                </ul>
            </div>

            <div class="col-md-4">
                <h6 class="mb-3">Đăng ký nhận tin</h6>
                <p class="small text-muted">Nhận thông tin về sản phẩm mới và chương trình khuyến mãi.</p>
                <form action="#" method="POST" class="d-flex">
                    <?php echo csrf_field(); ?>
                    <input type="email" name="email" class="form-control me-2" placeholder="Email của bạn">
                    <button class="btn btn-primary">Đăng ký</button>
                </form>
                <div class="mt-3">
                    <a href="#" class="me-2 text-dark"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="me-2 text-dark"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-dark"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="d-flex flex-column flex-md-row justify-content-between small text-muted">
            <div>&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. Đã đăng ký Bản quyền.</div>
            <div>Thiết kế &nbsp;•&nbsp; Hỗ trợ: <a href="mailto:support@mobileshop.com" class="text-decoration-none">support@mobileshop.com</a></div>
        </div>
    </div>
</footer>
<?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/partials/footer.blade.php ENDPATH**/ ?>