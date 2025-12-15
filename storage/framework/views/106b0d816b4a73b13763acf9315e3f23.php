<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin Panel'); ?> - MobileShop</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f5f7fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 240px;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            z-index: 1000;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
            font-size: 20px;
            font-weight: 600;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 10px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .main-content {
            margin-left: 240px;
            flex: 1;
            padding: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 600;
            color: #2c3e50;
        }

        .btn-add {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(30, 58, 138, 0.4);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stat-card.secondary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-card.success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-card.warning {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .stat-card.info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .table {
            color: #2c3e50;
        }

        .table thead th {
            border: none;
            background-color: #f8f9fa;
            color: #7f8c8d;
            font-weight: 600;
            padding: 15px;
            font-size: 13px;
            text-transform: uppercase;
        }

        .table tbody td {
            border: none;
            padding: 15px;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }

        .tabs-filter {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .tab-btn {
            padding: 10px 16px;
            border: 2px solid #e0e0e0;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            color: #7f8c8d;
            transition: all 0.3s ease;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }

        .user-info {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .sidebar-logout {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .sidebar-logout:hover {
            color: white;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                padding: 15px;
            }

            .sidebar-brand span {
                display: none;
            }

            .sidebar-menu span {
                display: none;
            }

            .main-content {
                margin-left: 70px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <i class="bi bi-phone"></i>
                <span>MobileAdmin</span>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="/admin" class="<?php if(request()->is('admin')): ?> active <?php endif; ?>">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/products" class="<?php if(request()->is('admin/products*')): ?> active <?php endif; ?>">
                        <i class="bi bi-box"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/orders">
                        <i class="bi bi-cart-check"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/categories">
                        <i class="bi bi-tags"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/brands">
                        <i class="bi bi-bookmark"></i>
                        <span>Brands</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.accessories.index')); ?>" class="<?php if(request()->is('admin/accessories*')): ?> active <?php endif; ?>">
                        <i class="bi bi-headphones"></i>
                        <span>Phụ Kiện</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.banners.index')); ?>" class="<?php if(request()->is('admin/banners*')): ?> active <?php endif; ?>">
                        <i class="bi bi-images"></i>
                        <span>Quản lý Banner</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.promotions.index')); ?>" class="<?php if(request()->is('admin/promotions*')): ?> active <?php endif; ?>">
                        <i class="bi bi-tag"></i>
                        <span>Mã ưu đãi</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.flash-sales.index')); ?>" class="<?php if(request()->is('admin/flash-sales*')): ?> active <?php endif; ?>">
                        <i class="bi bi-lightning-charge"></i>
                        <span>Flash Sale</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.contact.index')); ?>">
                        <i class="bi bi-envelope"></i>
                        <span>Liên hệ</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.reviews.index')); ?>" class="<?php if(request()->is('admin/reviews*')): ?> active <?php endif; ?>">
                        <i class="bi bi-star"></i>
                        <span>Đánh giá</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/blog">
                        <i class="bi bi-pencil-square"></i>
                        <span>Bài viết</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.settings.index')); ?>">
                        <i class="bi bi-gear"></i>
                        <span>Cài đặt</span>
                    </a>
                </li>
            </ul>

            <div class="user-info">
                <div class="user-avatar">
                    <i class="bi bi-person"></i>
                </div>
                <h6 style="color: white; margin: 0; font-size: 14px;"><?php echo e(Auth::user()->name ?? 'Admin'); ?></h6>
                <small style="color: rgba(255, 255, 255, 0.7);"><?php echo e(Auth::user()->email ?? 'admin@example.com'); ?></small>
                <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
        </aside>

        <main class="main-content">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/layouts/admin.blade.php ENDPATH**/ ?>