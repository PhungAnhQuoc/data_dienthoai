@extends('layouts.app')

@section('title', 'Hóa đơn ' . $order->order_number . ' - MobileShop')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Hóa đơn</h3>
                <div>
                    <a href="{{ route('invoice.pdf', $order->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-download me-2"></i>Tải PDF
                    </a>
                    <a href="{{ route('account.orders') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-2"></i>Quay lại
                    </a>
                </div>
            </div>

            <!-- Invoice Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <!-- Company & Invoice Info -->
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <h5 class="text-primary fw-bold">{{ $company['name'] }}</h5>
                            <p class="text-muted small mb-0">{{ $company['address'] }}</p>
                            <p class="text-muted small mb-0">{{ $company['phone'] }}</p>
                            <p class="text-muted small mb-0">{{ $company['email'] }}</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <h5 class="text-primary fw-bold mb-3">HÓA ĐƠN</h5>
                            <div class="small mb-2">
                                <strong>Mã đơn hàng:</strong> {{ $order->order_number }}
                            </div>
                            <div class="small mb-2">
                                <strong>Ngày lập:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="small">
                                <strong>Trạng thái:</strong>
                                @if($order->payment_status === 'paid')
                                    <span class="badge bg-success">✓ Đã thanh toán</span>
                                @else
                                    <span class="badge bg-warning">⏳ Chờ thanh toán</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Customer Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">THÔNG TIN KHÁCH HÀNG</h6>
                            <p class="mb-1"><strong>{{ $order->user->name }}</strong></p>
                            <p class="mb-1 text-muted">{{ $order->user->email }}</p>
                            <p class="mb-0 text-muted">{{ $order->user->phone ?? 'Không có' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">ĐỊA CHỈ GIAO HÀNG</h6>
                            <p class="mb-1"><strong>{{ $order->shipping_name }}</strong></p>
                            <p class="mb-1 text-muted">{{ $order->shipping_phone }}</p>
                            <p class="mb-0 text-muted">{{ $order->shipping_address }}</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Items Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center" style="width: 100px;">Số lượng</th>
                                    <th class="text-end" style="width: 150px;">Đơn giá</th>
                                    <th class="text-end" style="width: 150px;">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->product->name }}</strong>
                                        <br>
                                        <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">{{ number_format($item->unit_price, 0, ',', '.') }}₫</td>
                                    <td class="text-end fw-bold">{{ number_format($item->total_price, 0, ',', '.') }}₫</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <!-- Summary -->
                    <div class="row justify-content-end mb-4">
                        <div class="col-md-5">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính:</span>
                                <span>{{ number_format($order->total_amount - $order->shipping_cost - $order->tax_amount + $order->discount_amount, 0, ',', '.') }}₫</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phí vận chuyển:</span>
                                <span>{{ number_format($order->shipping_cost, 0, ',', '.') }}₫</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Thuế VAT (10%):</span>
                                <span>{{ number_format($order->tax_amount, 0, ',', '.') }}₫</span>
                            </div>
                            @if($order->discount_amount > 0)
                            <div class="d-flex justify-content-between mb-3 text-success">
                                <span>Giảm giá ({{ $order->promotion_code }}):</span>
                                <span>-{{ number_format($order->discount_amount, 0, ',', '.') }}₫</span>
                            </div>
                            @endif
                            <div class="d-flex justify-content-between border-top pt-2">
                                <strong class="text-primary">Tổng cộng:</strong>
                                <strong class="text-primary fs-5">{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Additional Info -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Phương thức thanh toán</h6>
                            <p class="text-muted">{{ $order->paymentMethod->display_name ?? 'Không xác định' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Trạng thái đơn hàng</h6>
                            <p class="text-muted">
                                @switch($order->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Chờ xác nhận</span>
                                        @break
                                    @case('confirmed')
                                        <span class="badge bg-info">Đã xác nhận</span>
                                        @break
                                    @case('processing')
                                        <span class="badge bg-primary">Đang xử lý</span>
                                        @break
                                    @case('shipped')
                                        <span class="badge bg-success">Đang giao</span>
                                        @break
                                    @case('delivered')
                                        <span class="badge bg-success">Đã giao</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Đã hủy</span>
                                        @break
                                @endswitch
                            </p>
                        </div>
                    </div>

                    @if($order->notes)
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="fw-bold mb-2">Ghi chú</h6>
                        <p class="text-muted mb-0">{{ $order->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="mt-4 text-center">
                <a href="{{ route('invoice.pdf', $order->id) }}" class="btn btn-primary">
                    <i class="bi bi-download me-2"></i>Tải hóa đơn PDF
                </a>
                <a href="{{ route('account.orders') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
