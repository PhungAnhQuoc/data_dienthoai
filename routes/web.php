<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\AccessoryController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\PromotionController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\FlashSaleController;

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap-index.xml', [SitemapController::class, 'sitemapIndex'])->name('sitemap.index-page');

// ChatBot Routes
Route::post('/api/chatbot/send', [ChatBotController::class, 'sendMessage'])->name('chatbot.send');
Route::get('/api/chatbot/history/{sessionId}', [ChatBotController::class, 'getHistory'])->name('chatbot.history');
Route::post('/api/chatbot/rate', [ChatBotController::class, 'rate'])->name('chatbot.rate');
Route::post('/api/chatbot/clear', [ChatBotController::class, 'clear'])->name('chatbot.clear');

// Flash Sale Routes
Route::prefix('api/flash-sales')->name('flash-sales.')->group(function () {
    Route::get('/current', [App\Http\Controllers\FlashSaleController::class, 'getCurrent'])->name('current');
    Route::get('/modal', [App\Http\Controllers\FlashSaleController::class, 'getModal'])->name('modal');
    Route::post('/{id}/update-sold', [App\Http\Controllers\FlashSaleController::class, 'updateSold'])->name('update-sold');
});

Route::middleware('check.maintenance')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/san-pham', [ProductController::class, 'index'])->name('products.index');
    Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('products.show');
    
    // Flash Sale Detail
    Route::get('/flash-sales/{id}', [App\Http\Controllers\FlashSaleController::class, 'show'])->name('flash-sales.show');

    Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/gio-hang/them', [CartController::class, 'add'])->name('cart.add');
    Route::put('/gio-hang/cap-nhat/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/gio-hang/xoa/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::delete('/gio-hang/xoa-tat-ca', [CartController::class, 'clear'])->name('cart.clear');

    Route::middleware('auth')->group(function () {
        Route::get('/thanh-toan', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/thanh-toan/dat-hang', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/thanh-toan/thanh-cong/{orderId}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
        Route::post('/kiem-tra-ma-giam-gia', [App\Http\Controllers\CheckoutController::class, 'validateCoupon'])->name('checkout.validate-coupon');
        
        // Payment routes
        Route::get('/thanh-toan/vnpay/{orderId}', [App\Http\Controllers\PaymentController::class, 'redirectToVNPay'])->name('payment.vnpay');
        Route::get('/thanh-toan/vnpay-return', [App\Http\Controllers\PaymentController::class, 'vnpayReturn'])->name('payment.vnpay-return');
        Route::post('/thanh-toan/vnpay-ipn', [App\Http\Controllers\PaymentController::class, 'vnpayIpn'])->withoutMiddleware('csrf')->name('payment.vnpay-ipn');
        Route::post('/thanh-toan/retry/{orderId}', [App\Http\Controllers\PaymentController::class, 'retryPayment'])->name('payment.retry');
        
        // Invoice routes
        Route::get('/hoa-don/{orderId}', [App\Http\Controllers\InvoiceController::class, 'view'])->name('invoice.view');
        Route::get('/hoa-don/{orderId}/pdf', [App\Http\Controllers\InvoiceController::class, 'exportPdf'])->name('invoice.pdf');
        
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

    // Newsletter Subscription
    Route::post('/newsletter/subscribe', [App\Http\Controllers\SubscriberController::class, 'subscribe'])->name('newsletter.subscribe');
    Route::get('/newsletter/unsubscribe/{token}', [App\Http\Controllers\SubscriberController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

    Route::middleware('auth')->group(function () {
        // User Profile & Dashboard
        Route::get('/tai-khoan', [App\Http\Controllers\UserProfileController::class, 'dashboard'])->name('user.dashboard');
        Route::get('/tai-khoan/ho-so', [App\Http\Controllers\UserProfileController::class, 'profile'])->name('user.profile');
        Route::post('/tai-khoan/ho-so/cap-nhat', [App\Http\Controllers\UserProfileController::class, 'updateProfile'])->name('user.update-profile');
        Route::post('/tai-khoan/doi-mat-khau', [App\Http\Controllers\UserProfileController::class, 'changePassword'])->name('user.change-password');
        
        // Order History
        Route::get('/tai-khoan/don-hang', [App\Http\Controllers\UserProfileController::class, 'orderHistory'])->name('user.order-history');
        Route::get('/tai-khoan/don-hang/{orderId}', [App\Http\Controllers\UserProfileController::class, 'orderDetail'])->name('user.order-detail');
        Route::post('/tai-khoan/don-hang/{orderId}/huy', [App\Http\Controllers\UserProfileController::class, 'requestCancel'])->name('user.cancel-order');
        
        // User Addresses
        Route::get('/tai-khoan/dia-chi', [App\Http\Controllers\UserAddressController::class, 'index'])->name('user.addresses');
        Route::post('/tai-khoan/dia-chi', [App\Http\Controllers\UserAddressController::class, 'store'])->name('user.address-store');
        Route::put('/tai-khoan/dia-chi/{address}', [App\Http\Controllers\UserAddressController::class, 'update'])->name('user.address-update');
        Route::delete('/tai-khoan/dia-chi/{address}', [App\Http\Controllers\UserAddressController::class, 'destroy'])->name('user.address-destroy');
        Route::post('/tai-khoan/dia-chi/{address}/mac-dinh', [App\Http\Controllers\UserAddressController::class, 'setDefault'])->name('user.address-default');
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
    Route::resource('promotions', PromotionController::class);

    // Flash Sales
    Route::resource('flash-sales', App\Http\Controllers\Admin\FlashSaleController::class);
    
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
    Route::get('/api/don-hang/{orderId}', [App\Http\Controllers\AccountController::class, 'getOrderDetails'])->name('account.order-details');

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

// Newsletter Subscription
Route::post('/newsletter/subscribe', [App\Http\Controllers\SubscriberController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [App\Http\Controllers\SubscriberController::class, 'unsubscribe'])->name('newsletter.unsubscribe');