<!-- Flash Sale Promotion Banner -->
<div class="flash-sale-banner mb-5">
    <!-- Header Banner -->
    <div class="flash-sale-header position-relative overflow-hidden rounded-3">
        <!-- Gradient Background -->
        <div class="flash-sale-bg"></div>
        
        <div class="position-relative" style="z-index: 2; padding: 30px 40px;">
            <div class="row align-items-center g-4">
                <!-- Left: Title & Badges -->
                <div class="col-auto">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flash-sale-badge-icon">
                            <i class="bi bi-fire"></i>
                        </div>
                        <div>
                            <div class="text-white fw-bold" style="font-size: 32px; letter-spacing: 2px; line-height: 1;">DOUBLE DAY</div>
                            <div class="text-white fw-bold" style="font-size: 24px;">12.12</div>
                        </div>
                    </div>
                </div>

                <!-- Center: Category Filters -->
                <div class="col">
                    <div class="d-flex gap-2 flex-wrap justify-content-center">
                        <button class="flash-sale-filter-btn active" data-category="all">
                            Tất cả
                        </button>
                        <button class="flash-sale-filter-btn" data-category="phones">
                            Điện thoại, Tablet
                        </button>
                        <button class="flash-sale-filter-btn" data-category="accessories">
                            Phụ kiện, PC
                        </button>
                        <button class="flash-sale-filter-btn" data-category="gadgets">
                            Gia dụng, Điện máy
                        </button>
                    </div>
                </div>

                <!-- Right: Countdown Timer -->
                <div class="col-auto">
                    <div class="countdown-wrapper">
                        <div class="text-white small fw-bold mb-2">KẾT THÚC SAU:</div>
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
    </div>

    <!-- Products Grid -->
    <div class="flash-sale-products-section position-relative mt-4">
        <div class="flash-sale-products-container">
            <div id="flashSaleProductsGrid" class="row g-3">
                <!-- Products will be inserted here -->
            </div>
        </div>

        <!-- Navigation Arrows -->
        <button class="flash-sale-nav-arrow flash-sale-nav-prev" id="flashSaleNavPrev">
            <i class="bi bi-chevron-left"></i>
        </button>
        <button class="flash-sale-nav-arrow flash-sale-nav-next" id="flashSaleNavNext">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>
</div>

<style>
/* Flash Sale Banner */
.flash-sale-banner {
    margin: 20px 0 40px 0;
}

.flash-sale-header {
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #ff1744 0%, #ff5e78 50%, #ff8a9b 100%);
    border-radius: 20px;
    box-shadow: 0 8px 24px rgba(255, 23, 68, 0.25);
}

.flash-sale-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 10% 30%, rgba(255, 255, 255, 0.15) 0%, transparent 40%),
        radial-gradient(circle at 90% 70%, rgba(255, 255, 255, 0.1) 0%, transparent 40%),
        radial-gradient(circle at 50% 50%, rgba(255, 150, 155, 0.1) 0%, transparent 60%);
    opacity: 0.8;
}

.flash-sale-badge-icon {
    background: white;
    width: 80px;
    height: 80px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    color: #ff1744;
    font-weight: bold;
    flex-shrink: 0;
}

.flash-sale-filter-btn {
    background: white;
    border: 2px solid white;
    color: #333;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    white-space: nowrap;
}

.flash-sale-filter-btn:hover,
.flash-sale-filter-btn.active {
    background: #ff1744;
    color: white;
    border-color: #ff1744;
    transform: scale(1.05);
}

.countdown-wrapper {
    text-align: center;
}

.countdown-timer {
    display: flex;
    gap: 4px;
    align-items: center;
    justify-content: center;
    font-family: 'Arial', sans-serif;
}

.countdown-item {
    background: white;
    color: #ff1744;
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: bold;
    font-size: 18px;
    min-width: 42px;
    text-align: center;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.countdown-separator {
    color: white;
    font-weight: bold;
    font-size: 18px;
    margin: 0 2px;
}

/* Products Grid */
.flash-sale-products-section {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.flash-sale-products-container {
    overflow: hidden;
}

#flashSaleProductsGrid {
    padding: 0;
}

.flash-sale-product-col {
    padding: 12px;
}

.flash-sale-product-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.flash-sale-product-card:hover {
    box-shadow: 0 6px 20px rgba(255, 23, 68, 0.15);
    border-color: #ff1744;
    transform: translateY(-4px);
}

.flash-sale-product-image {
    position: relative;
    height: 180px;
    background: #f8f9fa;
    overflow: hidden;
}

.flash-sale-product-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 10px;
    transition: transform 0.3s ease;
}

.flash-sale-product-card:hover .flash-sale-product-image img {
    transform: scale(1.08);
}

.flash-sale-badges {
    position: absolute;
    top: 8px;
    left: 8px;
    right: 8px;
    display: flex;
    gap: 6px;
}

.flash-sale-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: bold;
    white-space: nowrap;
}

.flash-sale-badge-discount {
    background: #ff1744;
    color: white;
}

.flash-sale-badge-installment {
    background: #e3f2fd;
    color: #1976d2;
}

.flash-sale-wishlist {
    position: absolute;
    bottom: 8px;
    right: 8px;
    background: white;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.flash-sale-wishlist:hover {
    background: #ff1744;
    color: white;
    transform: scale(1.15);
}

.flash-sale-product-body {
    padding: 12px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.flash-sale-product-name {
    font-size: 13px;
    font-weight: 600;
    color: #333;
    margin-bottom: 6px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
    flex-grow: 1;
}

.flash-sale-product-rating {
    font-size: 11px;
    color: #ffc107;
    margin-bottom: 6px;
}

.flash-sale-product-prices {
    margin-bottom: 8px;
}

.flash-sale-price-current {
    font-size: 16px;
    font-weight: bold;
    color: #ff1744;
    margin-right: 6px;
}

.flash-sale-price-original {
    font-size: 12px;
    color: #bbb;
    text-decoration: line-through;
}

.flash-sale-add-cart {
    width: 100%;
    background: #ff1744;
    color: white;
    border: none;
    padding: 8px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-top: auto;
}

.flash-sale-add-cart:hover {
    background: #e53935;
    transform: translateY(-1px);
    box-shadow: 0 2px 6px rgba(255, 23, 68, 0.2);
}

/* Navigation Arrows */
.flash-sale-nav-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: white;
    border: none;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
    transition: all 0.25s ease;
    color: #ff1744;
    font-size: 20px;
}

.flash-sale-nav-arrow:hover {
    background: #ff1744;
    color: white;
    box-shadow: 0 4px 12px rgba(255, 23, 68, 0.25);
    transform: translateY(-50%) scale(1.1);
}

.flash-sale-nav-prev {
    left: 12px;
}

.flash-sale-nav-next {
    right: 12px;
}

/* Responsive */
@media (max-width: 1400px) {
    #flashSaleProductsGrid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }
}

@media (max-width: 1200px) {
    #flashSaleProductsGrid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }
    
    .flash-sale-header .row {
        gap: 2rem !important;
    }
}

@media (max-width: 768px) {
    #flashSaleProductsGrid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    .flash-sale-header {
        padding: 20px !important;
        border-radius: 12px;
    }
    
    .flash-sale-header .row {
        flex-direction: column;
        text-align: center;
    }
    
    .flash-sale-badge-icon {
        width: 60px;
        height: 60px;
        font-size: 28px;
        margin: 0 auto;
    }
    
    .countdown-timer {
        justify-content: center;
    }
    
    .countdown-item {
        font-size: 14px;
        padding: 6px 10px;
    }
    
    .flash-sale-filter-btn {
        font-size: 12px;
        padding: 6px 12px;
    }
}

@media (max-width: 576px) {
    #flashSaleProductsGrid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 12px;
    }
    
    .flash-sale-nav-arrow {
        display: none;
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

setInterval(updateCountdown, 10);
updateCountdown();

// Category Filter
document.querySelectorAll('.flash-sale-filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.flash-sale-filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});

// Load Flash Sales
async function loadFlashSaleProducts() {
    try {
        const baseUrl = document.querySelector('meta[name="base-url"]')?.content || '/';
        const response = await fetch(baseUrl.replace(/\/$/, '') + '/api/flash-sales/current');
        const data = await response.json();
        
        if (data.success && data.data) {
            renderFlashSaleProducts(data.data);
        }
    } catch (error) {
        console.error('Error loading flash sales:', error);
    }
}

function renderFlashSaleProducts(products) {
    const grid = document.getElementById('flashSaleProductsGrid');
    
    const html = products.map(product => `
        <div class="flash-sale-product-col">
            <div class="flash-sale-product-card">
                <div class="flash-sale-product-image">
                    <img src="${product.image || '/images/placeholder.jpg'}" alt="${product.title}">
                    
                    <div class="flash-sale-badges">
                        <span class="flash-sale-badge flash-sale-badge-discount">
                            Giảm ${product.discount_percentage}%
                        </span>
                        <span class="flash-sale-badge flash-sale-badge-installment">
                            Trả góp 0%
                        </span>
                    </div>
                    
                    <button class="flash-sale-wishlist" title="Thêm vào yêu thích">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>

                <div class="flash-sale-product-body">
                    <div class="flash-sale-product-name">${product.title}</div>
                    
                    <div class="flash-sale-product-rating">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <span style="color: #999; font-size: 10px;">(5)</span>
                    </div>
                    
                    <div class="flash-sale-product-prices">
                        <span class="flash-sale-price-current">
                            ${formatPrice(product.sale_price)}₫
                        </span>
                        <span class="flash-sale-price-original">
                            ${formatPrice(product.original_price)}₫
                        </span>
                    </div>
                    
                    <button class="flash-sale-add-cart" onclick="addFlashSaleToCart(${product.id}, '${product.title}')">
                        <i class="bi bi-cart-plus"></i> Thêm giỏ
                    </button>
                </div>
            </div>
        </div>
    `).join('');

    grid.innerHTML = html;
}

function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN', { maximumFractionDigits: 0 }).format(price);
}

// Add to cart
function addFlashSaleToCart(flashSaleId, title) {
    const quantity = prompt('Nhập số lượng:', '1');
    if (!quantity || isNaN(quantity) || parseInt(quantity) < 1) return;

    const baseUrl = document.querySelector('meta[name="base-url"]')?.content || '/';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    fetch(baseUrl.replace(/\/$/, '') + '/gio-hang/them', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        credentials: 'same-origin',
        body: JSON.stringify({ flash_sale_id: parseInt(flashSaleId), quantity: parseInt(quantity) })
    })
    .then(r => r.json())
    .then(data => {
        if (window.Toast) {
            window.Toast[data.success ? 'success' : 'error'](data.message || (data.success ? 'Đã thêm vào giỏ!' : 'Lỗi'), data.success ? 'Thành công' : 'Lỗi');
        }
    })
    .catch(e => {
        console.error('Error:', e);
        if (window.Toast) window.Toast.error('Có lỗi xảy ra', 'Lỗi');
    });
}

// Initialize
document.addEventListener('DOMContentLoaded', loadFlashSaleProducts);
</script>
