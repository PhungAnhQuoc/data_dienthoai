<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body>
    <!-- Toast Container -->
    <?php echo $__env->make('partials.toast-container', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                    <?php echo e(config('app.name', 'Laravel')); ?>

                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?php echo e(__('Toggle navigation')); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('home')); ?>">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('products.index')); ?>">Sản phẩm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('blog.index')); ?>">Tin tức</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('orders.tracking')); ?>">Tra cứu đơn</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('contact.index')); ?>">Liên hệ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('cart.index')); ?>">Giỏ hàng</a>
                        </li>
                    </ul>

                    <!-- Search Bar -->
                    <form action="<?php echo e(route('products.index')); ?>" method="GET" class="d-flex me-3" role="search">
                        <input class="form-control me-2 rounded-3" type="search" name="search" placeholder="Tìm sản phẩm..." value="<?php echo e(request('search')); ?>" aria-label="Search">
                        <button class="btn btn-outline-primary rounded-3" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto align-items-center">
                        <?php if(auth()->guard()->guest()): ?>
                            <!-- Authentication Links for Guests -->
                            <?php if(Route::has('login')): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if(Route::has('register')): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- Wishlist Icon -->
                            <li class="nav-item me-3">
                                <a href="<?php echo e(route('wishlist.index')); ?>" class="nav-link position-relative" title="Yêu thích">
                                    <i class="bi bi-heart fs-5"></i>
                                    <?php
                                        $wishlistCount = Auth::user()->wishlists()->count();
                                    ?>
                                    <?php if($wishlistCount > 0): ?>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            <?php echo e($wishlistCount); ?>

                                        </span>
                                    <?php endif; ?>
                                </a>
                            </li>

                            <!-- Cart Icon -->
                            <li class="nav-item me-3">
                                <a href="<?php echo e(route('cart.index')); ?>" class="nav-link position-relative" title="Giỏ hàng">
                                    <i class="bi bi-cart3 fs-5"></i>
                                    <?php
                                        $cartCount = count(session('cart', []));
                                    ?>
                                    <?php if($cartCount > 0): ?>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            <?php echo e($cartCount); ?>

                                        </span>
                                    <?php endif; ?>
                                </a>
                            </li>

                            <!-- Account Link -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('account.profile')); ?>" title="Tài khoản">
                                    <i class="bi bi-person-circle"></i> <?php echo e(Auth::user()->name); ?>

                                </a>
                            </li>
                            
                            <!-- Logout Form -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('logout')); ?>"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   title="Đăng xuất">
                                    <i class="bi bi-box-arrow-right"></i>
                                </a>
                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                    <?php echo csrf_field(); ?>
                                </form>
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
        <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/layouts/app.blade.php ENDPATH**/ ?>