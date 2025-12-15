@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng - MobileShop')

@section('content')
<div class="container py-5">
    <!-- Header with Order Info -->
    <div class="mb-5">
        <a href="{{ route('orders.tracking') }}" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="bi bi-arrow-left me-2"></i>Tra cứu khác
        </a>

        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h3 class="mb-1">Mã đơn hàng: <strong>{{ $order->order_number }}</strong></h3>
                <p class="text-muted mb-0">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="text-end">
                @php
                    $statusBadge = ['pending' => 'warning', 'processing' => 'info', 'shipped' => 'primary', 'delivered' => 'success', 'cancelled' => 'danger'];
                    $statusLabel = ['pending' => 'Chờ xử lý', 'processing' => 'Đang xử lý', 'shipped' => 'Đã gửi', 'delivered' => 'Đã giao', 'cancelled' => 'Đã hủy'];
                @endphp
                <span class="badge bg-{{ $statusBadge[$order->status] ?? 'secondary' }} fs-6 mb-2">
                    {{ $statusLabel[$order->status] ?? 'N/A' }}
                </span>
                <div class="small">
                    <a href="javascript:void(0)" class="text-primary text-decoration-none me-2">Xem hoá đơn</a>
                    @if($order->status === 'pending')
                        <a href="javascript:void(0)" class="text-danger text-decoration-none">Hủy đơn</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left: Shipment Progress & Details -->
        <div class="col-lg-8">
            <!-- Shipment Progress -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-4">Tiến trình giao hàng</h6>
                    <div class="position-relative">
                        @php
                            $statuses = ['pending' => 'Đơn được đặt', 'processing' => 'Đang xử lý', 'shipped' => 'Đang giao hàng', 'delivered' => 'Đã giao'];
                            $currentStatus = $order->status;
                            $statusOrder = ['pending', 'processing', 'shipped', 'delivered'];
                            $currentIndex = array_search($currentStatus, $statusOrder);
                        @endphp
                        @foreach ($statuses as $key => $label)
                            @php $index = array_search($key, $statusOrder); @endphp
                            <div class="d-flex mb-4">
                                <div class="flex-shrink-0">
                                    @if ($index <= $currentIndex)
                                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-success text-white" style="width:45px;height:45px;">
                                            <i class="bi bi-check-lg fs-6"></i>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-light text-muted border" style="width:45px;height:45px;">
                                            <span class="small fw-bold">{{ $index + 1 }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-1 fw-bold">{{ $label }}</p>
                                    @if ($index <= $currentIndex)
                                        <p class="text-muted small mb-0">
                                            @if($index == $currentIndex && $currentStatus === 'shipped')
                                                Đơn hàng đang được vận chuyển. Vui lòng chủ động kiểm tra thời gian giao hàng và liên hệ với chúng tôi nếu có bất kỳ câu hỏi.
                                            @elseif($index <= $currentIndex)
                                                Hoàn thành vào {{ $order->created_at->addDays($index)->format('d/m/Y') }}
                                            @endif
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">Địa chỉ giao hàng</h6>
                    <p class="mb-2">
                        <strong>{{ $order->shipping_name }}</strong><br>
                        {{ $order->shipping_phone }}<br>
                        <span class="text-muted">{{ $order->shipping_email }}</span>
                    </p>
                    <p class="mb-0">
                        <strong>Địa chỉ:</strong><br>
                        {{ $order->shipping_address }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Right: Order Summary -->
        <div class="col-lg-4">
            <!-- Products Summary -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">Tóm tắt đơn hàng</h6>
                    @foreach ($order->items as $item)
                        @php
                            $price = $item->unit_price > 0 ? $item->unit_price : ($item->product->sale_price > 0 ? $item->product->sale_price : $item->product->price);
                            $totalPrice = $item->total_price > 0 ? $item->total_price : ($price * $item->quantity);
                            $productImage = $item->product->main_image ? asset('storage/' . $item->product->main_image) : ($item->product->images->first() ? asset('storage/' . $item->product->images->first()->image_url) : null);
                        @endphp
                        <div class="d-flex gap-3 mb-3">
                            <div style="width:60px;height:60px;background:#f5f6f8;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                @if($productImage)
                                    <img src="{{ $productImage }}" alt="{{ $item->product->name }}" class="img-fluid" style="max-height:55px;object-fit:contain;">
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-1 fw-bold small">{{ $item->product->name }}</p>
                                <p class="text-muted small mb-0">x{{ $item->quantity }}</p>
                            </div>
                        </div>
                    @endforeach
                    <hr>

                    <!-- Order Totals -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Tạm tính</span>
                            <span class="fw-bold">{{ number_format($order->total_amount - ($order->shipping_cost ?? 0) - ($order->tax_amount ?? 0), 0, ',', '.') }}₫</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Phí vận chuyển</span>
                            <span class="fw-bold">{{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}₫</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 small">
                            <span class="text-muted">Thuế (10%)</span>
                            <span class="fw-bold">{{ number_format($order->tax_amount ?? 0, 0, ',', '.') }}₫</span>
                        </div>
                        @if(($order->discount_amount ?? 0) > 0)
                            <div class="d-flex justify-content-between mb-3 small">
                                <span class="text-muted">Giảm giá</span>
                                <span class="fw-bold text-success">-{{ number_format($order->discount_amount ?? 0, 0, ',', '.') }}₫</span>
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Tổng cộng</span>
                        <span class="fw-bold fs-5 text-primary">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-2">Phương thức thanh toán</h6>
                    <p class="small text-muted mb-0">{{ $order->paymentMethod->display_name ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Support Button -->
            <button class="btn btn-outline-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#supportModal">
                <i class="bi bi-chat-dots me-2"></i>Liên hệ hỗ trợ
            </button>
            <a href="{{ route('contact.index') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-arrow-return-left me-2"></i>Chính sách đổi trả
            </a>
        </div>
    </div>
</div>
@endsection
