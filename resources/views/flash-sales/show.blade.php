@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Flash Sale</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $flashSale->title }}</li>
            </ol>
        </nav>

        @if ($flashSale->is_active && $flashSale->starts_at <= now() && $flashSale->ends_at > now())
            <!-- Main Content -->
            <div class="row g-5">
                <!-- Left: Image -->
                <div class="col-lg-5">
                    <div class="position-relative mb-4">
                        <div class="position-relative rounded-4 overflow-hidden" style="height: 500px; background: #f8f9fa;">
                            <img 
                                src="{{ $flashSale->image ? asset('storage/' . $flashSale->image) : asset('images/placeholder.jpg') }}" 
                                alt="{{ $flashSale->title }}"
                                class="w-100 h-100"
                                style="object-fit: cover;"
                            >
                            <div class="position-absolute top-3 end-3 badge bg-danger fs-5" style="padding: 12px 18px;">
                                <i class="bi bi-lightning-fill"></i>
                                <span class="ms-2 fw-bold">{{ $flashSale->discount_percentage ?? 0 }}% OFF</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Details -->
                <div class="col-lg-7">
                    <!-- Title -->
                    <h1 class="fw-bold mb-2" style="font-size: 2rem;">{{ $flashSale->title }}</h1>
                    
                    <!-- Description -->
                    @if ($flashSale->description)
                        <p class="text-muted mb-4" style="font-size: 1.1rem;">{{ $flashSale->description }}</p>
                    @endif

                    <!-- Price Section -->
                    <div class="p-4 rounded-4 mb-4" style="background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%); border-left: 5px solid #FF6B6B;">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <small class="text-muted d-block mb-2 fw-bold">Giá hiện tại:</small>
                                <div class="fs-2 fw-bold text-danger">
                                    {{ number_format($flashSale->sale_price, 0, ',', '.') }}₫
                                </div>
                            </div>
                            <div class="col-auto">
                                <div style="border-left: 2px solid #ccc; padding-left: 20px;">
                                    <small class="text-muted d-block mb-2 fw-bold">Giá gốc:</small>
                                    <div class="fs-5 text-muted text-decoration-line-through">
                                        {{ number_format($flashSale->original_price, 0, ',', '.') }}₫
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="text-center">
                            <span class="badge bg-danger fs-6" style="padding: 8px 16px;">
                                💰 Tiết kiệm: {{ number_format($flashSale->original_price - $flashSale->sale_price, 0, ',', '.') }}₫
                            </span>
                        </div>
                    </div>

                    <!-- Countdown Timer -->
                    <div class="p-4 rounded-4 mb-4" style="background: linear-gradient(135deg, #FFE0E0 0%, #FFB3B3 100%); border-left: 5px solid #FF6B6B;">
                        <small class="text-muted d-block mb-3 fw-bold" style="font-size: 0.95rem;">⏱️ KẾT THÚC TRONG:</small>
                        <div class="row text-center">
                            <div class="col">
                                <div class="fs-3 fw-bold text-danger countdown-hours" style="font-family: 'Courier New', monospace; font-size: 2rem;">00</div>
                                <small class="text-muted fw-bold">GIỜ</small>
                            </div>
                            <div class="col">
                                <span class="fw-bold text-muted fs-5">:</span>
                            </div>
                            <div class="col">
                                <div class="fs-3 fw-bold text-danger countdown-minutes" style="font-family: 'Courier New', monospace; font-size: 2rem;">00</div>
                                <small class="text-muted fw-bold">PHÚT</small>
                            </div>
                            <div class="col">
                                <span class="fw-bold text-muted fs-5">:</span>
                            </div>
                            <div class="col">
                                <div class="fs-3 fw-bold text-danger countdown-seconds" style="font-family: 'Courier New', monospace; font-size: 2rem;">00</div>
                                <small class="text-muted fw-bold">GIÂY</small>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Progress -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold">📦 Số lượng còn lại: <span class="text-danger">{{ $flashSale->getRemainingStock() }}</span></span>
                            <span class="text-muted">Đã bán {{ $flashSale->getSoldPercentage() }}%</span>
                        </div>
                        <div class="progress" style="height: 20px; background: #e9ecef;">
                            <div 
                                class="progress-bar" 
                                role="progressbar" 
                                style="width: {{ $flashSale->getSoldPercentage() }}%; background: linear-gradient(90deg, #FF6B6B 0%, #FF8E72 100%); font-weight: bold; color: white; font-size: 0.85rem; line-height: 20px;"
                                aria-valuenow="{{ $flashSale->getSoldPercentage() }}" 
                                aria-valuemin="0" 
                                aria-valuemax="100">
                                @if ($flashSale->getSoldPercentage() > 10)
                                    {{ $flashSale->getSoldPercentage() }}%
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Stock Status Alert -->
                    @if ($flashSale->getRemainingStock() < 10 && $flashSale->getRemainingStock() > 0)
                        <div class="alert alert-warning mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Cảnh báo!</strong> Chỉ còn {{ $flashSale->getRemainingStock() }} sản phẩm. Hãy đặt mua ngay!
                        </div>
                    @elseif ($flashSale->getRemainingStock() == 0)
                        <div class="alert alert-danger mb-4" role="alert">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <strong>Hết hàng!</strong> Flash sale này đã bán hết.
                        </div>
                    @endif

                    <!-- Quantity Selector -->
                    @if ($flashSale->getRemainingStock() > 0)
                        <div class="mb-4">
                            <label class="form-label fw-bold">Số lượng:</label>
                            <div class="input-group" style="max-width: 150px;">
                                <button class="btn btn-outline-secondary" type="button" onclick="decreaseQty()">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input 
                                    type="number" 
                                    class="form-control text-center" 
                                    id="quantity" 
                                    value="1" 
                                    min="1" 
                                    max="{{ $flashSale->getRemainingStock() }}"
                                >
                                <button class="btn btn-outline-secondary" type="button" onclick="increaseQty()">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Add to Cart Form -->
                        <form action="{{ route('cart.add') }}" method="POST" class="mb-3">
                            @csrf
                            <input type="hidden" name="flash_sale_id" value="{{ $flashSale->id }}">
                            <input type="hidden" name="quantity" id="quantityInput" value="1">
                            
                            <button 
                                type="submit" 
                                class="btn btn-lg w-100 fw-bold mb-3"
                                style="background: linear-gradient(135deg, #FF6B6B 0%, #FF8E72 100%); border: none; color: white; padding: 16px 24px; font-size: 1.2rem;"
                            >
                                <i class="bi bi-cart-plus me-2"></i>THÊM VÀO GIỎ HÀNG
                            </button>
                        </form>

                        <!-- Buy Now Button -->
                        <button 
                            type="button" 
                            class="btn btn-outline-danger btn-lg w-100 fw-bold"
                            onclick="buyNow()"
                            style="padding: 16px 24px; font-size: 1.2rem;"
                        >
                            <i class="bi bi-lightning-fill me-2"></i>MUA NGAY
                        </button>
                    @else
                        <button class="btn btn-secondary btn-lg w-100 fw-bold" disabled>
                            <i class="bi bi-x-circle me-2"></i>ĐÃ HẾT HÀNG
                        </button>
                    @endif

                    <!-- Additional Info -->
                    <div class="mt-4 pt-4 border-top">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle text-success fs-5 me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Miễn phí vận chuyển</small>
                                        <strong>Cho đơn từ 500.000₫</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-shield-check text-success fs-5 me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Bảo mật thanh toán</small>
                                        <strong>100% an toàn</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-arrow-repeat text-success fs-5 me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Chính sách đổi trả</small>
                                        <strong>7 ngày không lý do</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-chat-left-text text-success fs-5 me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Hỗ trợ 24/7</small>
                                        <strong>Chat & Email</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Expired Flash Sale Alert -->
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <h4 class="alert-heading">Flash Sale Đã Kết Thúc</h4>
                <p>Rất tiếc, flash sale này đã kết thúc hoặc không còn hoạt động.</p>
                <hr>
                <p class="mb-0">
                    <a href="{{ route('home') }}" class="btn btn-outline-danger">
                        <i class="bi bi-arrow-left me-2"></i>Quay lại trang chủ
                    </a>
                </p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    const maxQty = {{ $flashSale->getRemainingStock() }};

    function increaseQty() {
        const input = document.getElementById('quantity');
        const current = parseInt(input.value) || 1;
        if (current < maxQty) {
            input.value = current + 1;
            updateQuantityInput();
        }
    }

    function decreaseQty() {
        const input = document.getElementById('quantity');
        const current = parseInt(input.value) || 1;
        if (current > 1) {
            input.value = current - 1;
            updateQuantityInput();
        }
    }

    function updateQuantityInput() {
        document.getElementById('quantityInput').value = document.getElementById('quantity').value;
    }

    function buyNow() {
        updateQuantityInput();
        document.querySelector('form').submit();
    }

    // Quantity input change listener
    document.getElementById('quantity').addEventListener('change', updateQuantityInput);
    document.getElementById('quantity').addEventListener('input', function() {
        if (this.value > maxQty) this.value = maxQty;
        if (this.value < 1) this.value = 1;
        updateQuantityInput();
    });

    // Countdown Timer
    function updateCountdown() {
        const endTime = new Date('{{ $flashSale->ends_at->toIso8601String() }}').getTime();
        const now = new Date().getTime();
        const distance = endTime - now;

        if (distance < 0) {
            document.querySelector('.countdown-hours').textContent = '00';
            document.querySelector('.countdown-minutes').textContent = '00';
            document.querySelector('.countdown-seconds').textContent = '00';
            // Optionally reload page or disable button
            return;
        }

        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.querySelector('.countdown-hours').textContent = String(hours).padStart(2, '0');
        document.querySelector('.countdown-minutes').textContent = String(minutes).padStart(2, '0');
        document.querySelector('.countdown-seconds').textContent = String(seconds).padStart(2, '0');
    }

    // Update countdown every second
    updateCountdown();
    setInterval(updateCountdown, 1000);
</script>
@endpush

@endsection
