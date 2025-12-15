<!-- Flash Sale Promotion Banner -->
<div class="flash-sale-banner mb-5">
    <!-- Header Banner -->
    <div class="flash-sale-header position-relative overflow-hidden">
        <div class="flash-sale-header-bg"></div>
        
        <div class="container py-4 position-relative" style="z-index: 2;">
            <div class="row align-items-center">
                <!-- Title -->
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flash-sale-title-badge">
                            <i class="bi bi-fire"></i>
                            <div>
                                <div class="fw-bold" style="font-size: 12px;">DOUBLE DAY</div>
                                <div class="fw-bold" style="font-size: 18px;">12.12</div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-white mb-0 fw-bold" style="font-size: 24px;">Flash Sale</h3>
                            <p class="text-white-50 mb-0 small">Giảm giá lên tới 50%</p>
                        </div>
                    </div>
                </div>

                <!-- Category Filters -->
                <div class="col-md-5">
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="flash-sale-filter-btn active" data-category="all">
                            Tất cả
                        </button>
                        <button class="flash-sale-filter-btn" data-category="phones">
                            Điện thoại
                        </button>
                        <button class="flash-sale-filter-btn" data-category="tablets">
                            Tablet
                        </button>
                        <button class="flash-sale-filter-btn" data-category="accessories">
                            Phụ kiện
                        </button>
                    </div>
                </div>

                <!-- Countdown Timer -->
                <div class="col-md-3 text-end">
                    <div class="text-white small mb-2 fw-bold">KẾT THÚC SAU:</div>
                    <div class="countdown-timer">
                        <div class="countdown-item">
                            <span id="countdown-hours">01</span>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <span id="countdown-minutes">09</span>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <span id="countdown-seconds">49</span>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <span id="countdown-ms">09</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Carousel -->
    <div class="container py-5">
        <div class="position-relative">
            <!-- Carousel Wrapper -->
            <div id="flashSaleCarousel" class="flash-sale-carousel">
                <!-- Products will be inserted here -->
            </div>

            <!-- Navigation Arrows -->
            <button class="carousel-nav carousel-nav-prev" id="carouselPrev">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="carousel-nav carousel-nav-next" id="carouselNext">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<style>
/* Flash Sale Banner Styles */
.flash-sale-banner {
    margin: 30px 0;
}

.flash-sale-header {
    background: linear-gradient(135deg, #ff1744 0%, #ff6e40 100%);
    border-radius: 16px;
    position: relative;
    overflow: hidden;
}

.flash-sale-header-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
    z-index: 1;
}

.flash-sale-title-badge {
    background: white;
    padding: 12px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #ff1744;
    font-weight: bold;
}

.flash-sale-title-badge i {
    font-size: 24px;
}

.flash-sale-filter-btn {
    background: white;
    border: 2px solid transparent;
    color: #333;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.flash-sale-filter-btn:hover,
.flash-sale-filter-btn.active {
    background: #ff1744;
    color: white;
    border-color: #ff1744;
}

/* Countdown Timer */
.countdown-timer {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
    align-items: center;
}

.countdown-item {
    background: white;
    color: #ff1744;
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: bold;
    font-size: 18px;
    min-width: 40px;
    text-align: center;
}

.countdown-separator {
    color: white;
    font-weight: bold;
    font-size: 16px;
}

/* Carousel Styles */
.flash-sale-carousel {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    padding: 20px 0;
    scroll-behavior: smooth;
    margin: 0 50px;
}

.flash-sale-carousel::-webkit-scrollbar {
    height: 6px;
}

.flash-sale-carousel::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.flash-sale-carousel::-webkit-scrollbar-thumb {
    background: #ff1744;
    border-radius: 3px;
}

.carousel-product-card {
    flex: 0 0 calc(20% - 16px);
    min-width: 180px;
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.carousel-product-card:hover {
    box-shadow: 0 8px 24px rgba(255, 23, 68, 0.15);
    transform: translateY(-4px);
}

.carousel-product-card-image {
    position: relative;
    height: 200px;
    background: #f5f5f5;
    overflow: hidden;
}

.carousel-product-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.carousel-product-card:hover .carousel-product-card-image img {
    transform: scale(1.05);
}

.carousel-product-badges {
    position: absolute;
    top: 12px;
    left: 12px;
    right: 12px;
    display: flex;
    gap: 6px;
    justify-content: space-between;
}

.carousel-badge-discount {
    background: #ff1744;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: bold;
}

.carousel-badge-installment {
    background: #e3f2fd;
    color: #1976d2;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: bold;
}

.carousel-wishlist-btn {
    position: absolute;
    bottom: 12px;
    right: 12px;
    background: white;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.carousel-wishlist-btn:hover {
    background: #ff1744;
    color: white;
    transform: scale(1.1);
}

.carousel-product-card-body {
    padding: 12px;
}

.carousel-product-name {
    font-size: 13px;
    font-weight: 600;
    color: #333;
    margin-bottom: 6px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.carousel-product-rating {
    font-size: 12px;
    color: #ffc107;
    margin-bottom: 6px;
}

.carousel-product-prices {
    margin-bottom: 6px;
}

.carousel-product-price-current {
    font-size: 16px;
    font-weight: bold;
    color: #ff1744;
}

.carousel-product-price-original {
    font-size: 12px;
    color: #999;
    text-decoration: line-through;
    margin-left: 6px;
}

.carousel-add-to-cart {
    width: 100%;
    background: #ff1744;
    color: white;
    border: none;
    padding: 6px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.carousel-add-to-cart:hover {
    background: #e53935;
    transform: translateY(-1px);
}

/* Navigation Arrows */
.carousel-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    color: #ff1744;
    font-size: 18px;
}

.carousel-nav:hover {
    background: #ff1744;
    color: white;
    box-shadow: 0 4px 12px rgba(255, 23, 68, 0.2);
}

.carousel-nav-prev {
    left: 0;
}

.carousel-nav-next {
    right: 0;
}

/* Responsive */
@media (max-width: 1200px) {
    .carousel-product-card {
        flex: 0 0 calc(25% - 15px);
    }
}

@media (max-width: 768px) {
    .carousel-product-card {
        flex: 0 0 calc(50% - 10px);
    }
    
    .flash-sale-header .row {
        flex-direction: column;
        gap: 20px;
    }
    
    .countdown-timer {
        justify-content: center;
    }
    
    .flash-sale-carousel {
        margin: 0 30px;
    }
}

@media (max-width: 576px) {
    .carousel-product-card {
        flex: 0 0 calc(100% - 10px);
    }
    
    .flash-sale-filter-btn {
        font-size: 11px;
        padding: 6px 12px;
    }
}
</style>

<script>
// Countdown Timer
function updateCountdown() {
    const endTime = new Date('2025-12-14T13:49:09').getTime();
    const now = new Date().getTime();
    const diff = endTime - now;
    
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((diff % (1000 * 60)) / 1000);
    const ms = Math.floor((diff % 1000) / 10);
    
    document.getElementById('countdown-hours').textContent = String(hours).padStart(2, '0');
    document.getElementById('countdown-minutes').textContent = String(minutes).padStart(2, '0');
    document.getElementById('countdown-seconds').textContent = String(seconds).padStart(2, '0');
    document.getElementById('countdown-ms').textContent = String(ms).padStart(2, '0');
}

// Update countdown every 10ms
setInterval(updateCountdown, 10);
updateCountdown();

// Carousel Navigation
document.getElementById('carouselPrev')?.addEventListener('click', function() {
    const carousel = document.getElementById('flashSaleCarousel');
    carousel.scrollBy({ left: -220, behavior: 'smooth' });
});

document.getElementById('carouselNext')?.addEventListener('click', function() {
    const carousel = document.getElementById('flashSaleCarousel');
    carousel.scrollBy({ left: 220, behavior: 'smooth' });
});

// Category Filter
document.querySelectorAll('.flash-sale-filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.flash-sale-filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        // TODO: Filter products by category
    });
});
</script>
<?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/partials/flash-sale-promo.blade.php ENDPATH**/ ?>