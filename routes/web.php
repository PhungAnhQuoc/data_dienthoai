<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\AccessoryController;
use App\Http\Controllers\Admin\BannerController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

// Frontend Routes (wrapped with maintenance-check middleware)
Route::middleware('check.maintenance')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/san-pham', [ProductController::class, 'index'])->name('products.index');
    Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('products.show');

    Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/gio-hang/them', [CartController::class, 'add'])->name('cart.add');
    Route::put('/gio-hang/cap-nhat/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/gio-hang/xoa/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::delete('/gio-hang/xoa-tat-ca', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout Routes (Protected)
    Route::middleware('auth')->group(function () {
        Route::get('/thanh-toan', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/thanh-toan/dat-hang', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/thanh-toan/thanh-cong/{orderId}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
        
        // Wishlist Routes
        Route::get('/yeu-thich', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/yeu-thich', [App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.store');
        Route::delete('/yeu-thich/{id}', [App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.destroy');
    });

    Route::get('/tin-tuc', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/tin-tuc/{slug}', [BlogController::class, 'show'])->name('blog.show');

    // Contact Routes
    Route::get('/lien-he', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
    Route::post('/lien-he', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

    // Order Tracking (Public)
    Route::get('/tra-cuu-don-hang', [App\Http\Controllers\OrderTrackingController::class, 'index'])->name('orders.tracking');
    Route::post('/tra-cuu-don-hang', [App\Http\Controllers\OrderTrackingController::class, 'search'])->name('orders.tracking.search');

    // Reviews (Protected)
    Route::middleware('auth')->group(function () {
        Route::post('/san-pham/{productId}/danh-gia', [ReviewController::class, 'store'])->name('reviews.store');
        Route::delete('/danh-gia/{reviewId}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    });
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', AdminProductController::class);
    
    // Accessories
    Route::resource('accessories', AccessoryController::class);
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Brands
    Route::resource('brands', BrandController::class);
    
        // Orders
        Route::resource('orders', OrderController::class, ['only' => ['index', 'show']]);
        Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Contact Messages
    Route::get('contact', [App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contact.index');
    Route::get('contact/{contactMessage}', [App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contact.show');
    Route::post('contact/{contactMessage}/reply', [App\Http\Controllers\Admin\ContactController::class, 'reply'])->name('contact.reply');
    Route::delete('contact/{contactMessage}', [App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contact.destroy');

    // Reviews Management
    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::put('reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::put('reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    // Settings
    Route::get('settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');

    // Settings
    Route::get('settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    
    // Banners
    Route::resource('banners', BannerController::class);
    
    // Promotions
    Route::get('promotions', function() {
        return view('admin.promotions.index');
    })->name('promotions.index');
    
    // Blog
    Route::resource('blog', AdminBlogController::class);
});

// Authentication Routes
Route::get('/dang-nhap', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/dang-nhap', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::get('/dang-ky', [App\Http\Controllers\AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/dang-ky', [App\Http\Controllers\AuthController::class, 'register'])->name('register.post');
Route::post('/dang-xuat', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Password Reset (Optional)
Route::get('/quen-mat-khau', function() {
    return view('auth.forgot-password');
})->name('password.request');

// Account Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/tai-khoan', [App\Http\Controllers\AccountController::class, 'profile'])->name('account.profile');
    Route::post('/tai-khoan/cap-nhat-thong-tin', [App\Http\Controllers\AccountController::class, 'updateProfile'])->name('account.update-profile');
    
    Route::get('/don-hang', [App\Http\Controllers\AccountController::class, 'orders'])->name('account.orders');

    // Order Management
    Route::post('/don-hang/{orderId}/huy', [App\Http\Controllers\OrderController::class, 'cancel'])->name('orders.cancel');

    // User Contact Messages
    Route::get('/tin-nhan-lien-he', [App\Http\Controllers\UserContactController::class, 'index'])->name('user.contact.index');
    Route::get('/tin-nhan-lien-he/{contactMessage}', [App\Http\Controllers\UserContactController::class, 'show'])->name('user.contact.show');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Temporary debug route: simulate checkout POST for local debugging only
Route::get('/debug/checkout-simulate', function () {
    // Only allow requests from localhost to avoid exposing this in production
    if (request()->ip() !== '127.0.0.1' && request()->ip() !== '::1') {
        abort(404);
    }
        // Find a product and an active payment method
        $product = \App\Models\Product::first();
        $payment = \App\Models\PaymentMethod::where('is_active', true)->first();

        if (! $product) {
            return response('No products in DB to simulate checkout', 500);
        }
        if (! $payment) {
            return response('No active payment methods to simulate checkout', 500);
        }

        // Login first user for simulation (local only)
        $user = \App\Models\User::first();
        if (! $user) {
            return response('No users in DB to simulate login', 500);
        }

        \Illuminate\Support\Facades\Auth::login($user);

        // Prepare a simple cart in session
        session(['cart' => [ $product->id => ['quantity' => 1] ]]);

        // Create a fake request with required fields
        $request = \Illuminate\Http\Request::create('/thanh-toan/dat-hang', 'POST', [
            'shipping_name' => $user->name,
            'shipping_email' => $user->email,
            'shipping_phone' => $user->phone ?? '0123456789',
            'shipping_address' => $user->address ?? 'Địa chỉ thử',
            'payment_method_id' => $payment->id,
            'notes' => 'Simulated order for debugging',
        ]);

        // Call controller method directly to capture any exception in logs
        try {
            $controller = app(\App\Http\Controllers\CheckoutController::class);
            return $controller->store($request);
        } catch (\Throwable $e) {
            // Re-throw so Laravel logs it and returns 500 with stacktrace in log
            report($e);
            throw $e;
        }
    });