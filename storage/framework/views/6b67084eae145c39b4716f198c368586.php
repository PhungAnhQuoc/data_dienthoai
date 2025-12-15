<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <!-- Base URL for AJAX requests -->
    <meta name="base-url" content="<?php echo e(url('/')); ?>/">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body>
    <!-- Toast Container -->
    <?php echo $__env->make('partials.toast-container', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div id="app">
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg sticky-top">
            <div class="container">
                <!-- Brand/Logo -->
                <a class="navbar-brand fw-bold" href="<?php echo e(url('/')); ?>">
                    <i class="bi bi-phone me-2"></i><?php echo e(config('app.name', 'MobileShop')); ?>

                </a>

                <!-- Mobile Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Content -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Main Navigation Links -->
                    <ul class="navbar-nav ms-auto gap-1">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('home')); ?>">
                                <i class="bi bi-house-fill me-1"></i>Trang chủ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('products.index')); ?>">
                                <i class="bi bi-bag-fill me-1"></i>Sản phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('blog.index')); ?>">
                                <i class="bi bi-newspaper me-1"></i>Tin tức
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('orders.tracking')); ?>">
                                <i class="bi bi-box-fill me-1"></i>Tra cứu đơn
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('contact.index')); ?>">
                                <i class="bi bi-chat-dots-fill me-1"></i>Liên hệ
                            </a>
                        </li>
                    </ul>

                    <!-- Search Bar (Mobile: Below nav, Desktop: Inline) -->
                    <form action="<?php echo e(route('products.index')); ?>" method="GET" class="d-flex ms-lg-3 mt-3 mt-lg-0 navbar-search-form w-100 w-lg-auto">
                        <input class="form-control navbar-search-input flex-grow-1" 
                               type="search" 
                               name="search" 
                               placeholder="Tìm điện thoại..." 
                               value="<?php echo e(request('search')); ?>" 
                               aria-label="Search">
                        <button class="btn btn-primary navbar-search-btn" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    <!-- Right Icons -->
                    <ul class="navbar-nav ms-auto gap-2 mt-3 mt-lg-0">
                        <?php if(auth()->guard()->guest()): ?>
                            <!-- Guest Links -->
                            <?php if(Route::has('login')): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('login')); ?>">
                                        <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if(Route::has('register')): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('register')); ?>">
                                        <i class="bi bi-person-plus me-1"></i>Đăng ký
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- Wishlist Icon -->
                            <li class="nav-item">
                                <a href="<?php echo e(route('wishlist.index')); ?>" class="nav-link position-relative" title="Yêu thích">
                                    <i class="bi bi-heart-fill" style="color: #dc3545;"></i>
                                    <?php
                                        $wishlistCount = Auth::user()->wishlists()->count();
                                    ?>
                                    <?php if($wishlistCount > 0): ?>
                                        <span class="navbar-badge"><?php echo e($wishlistCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>

                            <!-- Cart Icon -->
                            <li class="nav-item">
                                <a href="<?php echo e(route('cart.index')); ?>" class="nav-link position-relative" title="Giỏ hàng">
                                    <i class="bi bi-cart3"></i>
                                    <?php
                                        $cartCount = count(session('cart', []));
                                    ?>
                                    <?php if($cartCount > 0): ?>
                                        <span class="navbar-badge"><?php echo e($cartCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>

                            <!-- Account Dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Tài khoản">
                                    <i class="bi bi-person-circle"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                                    <li>
                                        <a class="dropdown-item" href="<?php echo e(route('account.profile')); ?>">
                                            <i class="bi bi-person me-2"></i>Tài khoản của tôi
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo e(route('account.orders')); ?>">
                                            <i class="bi bi-bag me-2"></i>Đơn hàng của tôi
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                        </a>
                                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('partials.toast-helper', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    </div>

        <?php echo $__env->make('partials.chatbot-widget', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <!-- Bootstrap JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/layouts/app.blade.php ENDPATH**/ ?>