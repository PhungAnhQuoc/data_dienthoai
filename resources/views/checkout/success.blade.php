@extends('layouts.app')

@section('title', 'Đơn hàng thành công - MobileShop')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success" style="width:86px;height:86px;">
                    <i class="bi bi-check-lg text-white fs-1"></i>
                </div>
                <h2 class="mt-3">Đặt Hàng Thành Công!</h2>
                <p class="text-muted">Cảm ơn bạn đã mua hàng! Chi tiết đơn hàng đã được gửi đến email của bạn.</p>
            </div>

            <div class="card mb-4">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-muted">Mã đơn hàng:</div>
                        <div class="fw-bold">{{ $order->order_number ?? '' }}</div>
                        <div class="small text-muted">Ngày đặt: {{ optional($order->created_at)->format('d/m/Y') ?? '' }}</div>
                    </div>
                    <div class="text-end">
                        <a href="#" class="btn btn-outline-secondary btn-sm">Sao chép mã</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Tóm tắt đơn hàng</h5>
                            @foreach($order->items as $item)
                                @php
                                    $price = $item->unit_price > 0 ? $item->unit_price : ($item->product->sale_price > 0 ? $item->product->sale_price : $item->product->price);
                                    $totalPrice = $item->total_price > 0 ? $item->total_price : ($price * $item->quantity);
                                @endphp
                                <div class="d-flex align-items-center py-3 border-bottom">
                                    <div class="me-3" style="width:64px;height:64px; background:#f5f6f8; display:flex;align-items:center;justify-content:center;">
                                        @if(isset($item->product->image_url))
                                            <img src="{{ $item->product->image_url }}" alt="" class="img-fluid" style="max-height:60px;">
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">{{ $item->product->name }}</div>
                                        <div class="small text-muted">x{{ $item->quantity }}</div>
                                    </div>
                                    <div class="text-end">
                                        <div>{{ number_format($totalPrice, 0, ',', '.') }}₫</div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="row mt-3">
                                <div class="col-6 text-muted">Tạm tính</div>
                                <div class="col-6 text-end fw-bold">{{ number_format($order->total_amount - ($order->shipping_cost ?? 0) - ($order->tax_amount ?? 0) + ($order->discount_amount ?? 0), 0, ',', '.') }}₫</div>
                                <div class="col-6 text-muted">Phí vận chuyển</div>
                                <div class="col-6 text-end fw-bold">{{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}₫</div>
                                <div class="col-6 text-muted">Thuế (10%)</div>
                                <div class="col-6 text-end fw-bold">{{ number_format($order->tax_amount ?? 0, 0, ',', '.') }}₫</div>
                                @if(($order->discount_amount ?? 0) > 0)
                                    <div class="col-6 text-muted">Giảm giá ({{ $order->promotion_code ?? '' }})</div>
                                    <div class="col-6 text-end fw-bold text-success">-{{ number_format($order->discount_amount ?? 0, 0, ',', '.') }}₫</div>
                                @endif
                            </div>
                            <hr>
                            <div class="row mt-2">
                                <div class="col-6 fw-bold fs-5">Tổng cộng</div>
                                <div class="col-6 text-end fw-bold fs-5 text-primary">{{ number_format($order->total_amount, 0, ',', '.') }}₫</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="mb-2">Thông tin giao hàng</h6>
                            <div class="small text-muted">{{ $order->shipping_name ?? '' }}</div>
                            <div class="mb-2">{{ $order->shipping_phone ?? '' }}</div>
                            <div class="small text-muted">{{ $order->shipping_address ?? '' }}</div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="mb-2">Phương thức thanh toán</h6>
                            <div class="small text-muted">@if($paymentMethod) {{ $paymentMethod->display_name }} @endif</div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="mb-2">Giao hàng dự kiến</h6>
                            <div class="small text-muted">Thứ Ba, {{ optional($order->created_at)->addDays(3)->format('d/m/Y') ?? '' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3 mt-3">
                <a href="{{ route('account.orders') }}" class="btn btn-primary">Theo dõi đơn hàng</a>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">Tiếp tục mua sắm</a>
            </div>
        </div>
    </div>
</div>
@endsection
