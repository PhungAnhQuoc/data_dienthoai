@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Tài khoản</h5>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ route('account.profile') }}">
                            <i class="bi bi-person me-2"></i>Hồ sơ
                        </a>
                        <a class="nav-link active" href="{{ route('account.orders') }}">
                            <i class="bi bi-receipt me-2"></i>Đơn hàng
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Lịch sử đơn hàng</h5>
                </div>
                <div class="card-body">
                    @if(Auth::user()->orders->count() > 0)
                        <!-- Search Bar -->
                        <div class="mb-4">
                            <input type="text" class="form-control" id="searchOrder" placeholder="Tìm kiếm theo mã đơn hàng...">
                        </div>

                        <!-- Status Filter -->
                        <ul class="nav nav-pills mb-4" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab">
                                    Tất cả ({{ Auth::user()->orders->count() }})
                                </button>
                            </li>
                            @php
                                $statusMap = ['pending' => 'Chờ xử lý', 'processing' => 'Đang xử lý', 'shipped' => 'Đã gửi', 'delivered' => 'Đã giao', 'cancelled' => 'Đã hủy'];
                            @endphp
                            @foreach($statusMap as $key => $label)
                                @php $count = Auth::user()->orders->where('status', $key)->count(); @endphp
                                @if($count > 0)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="{{ $key }}-tab" data-bs-toggle="pill" data-bs-target="#{{ $key }}" type="button" role="tab">
                                            {{ $label }} ({{ $count }})
                                        </button>
                                    </li>
                                @endif
                            @endforeach
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- All Orders -->
                            <div class="tab-pane fade show active" id="all" role="tabpanel">
                                <div class="row" id="ordersContainer">
                                    @foreach(Auth::user()->orders->sortByDesc('created_at') as $order)
                                        <div class="col-12 mb-3 order-card" data-order-number="{{ $order->order_number }}">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div>
                                                            <h6 class="card-title mb-0">Mã đơn: <strong>{{ $order->order_number }}</strong></h6>
                                                            <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                                        </div>
                                                        @php
                                                            $statusBadge = ['pending' => 'warning', 'processing' => 'info', 'shipped' => 'primary', 'delivered' => 'success', 'cancelled' => 'danger'];
                                                            $statusLabel = ['pending' => 'Chờ xử lý', 'processing' => 'Đang xử lý', 'shipped' => 'Đã gửi', 'delivered' => 'Đã giao', 'cancelled' => 'Đã hủy'];
                                                        @endphp
                                                        <span class="badge bg-{{ $statusBadge[$order->status] ?? 'secondary' }}">{{ $statusLabel[$order->status] ?? 'N/A' }}</span>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Tổng tiền</small><br>
                                                            <strong class="text-primary">{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Số sản phẩm</small><br>
                                                            <strong>{{ $order->items->sum('quantity') }} sản phẩm</strong>
                                                        </div>
                                                    </div>

                                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                                        <i class="bi bi-eye me-2"></i>Xem chi tiết
                                                    </button>
                                                    @if($order->status === 'pending')
                                                        <button class="btn btn-sm btn-outline-danger cancel-order-btn" data-order-id="{{ $order->id }}" data-order-number="{{ $order->order_number }}">
                                                            <i class="bi bi-x-circle me-1"></i>Hủy đơn
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Chi tiết đơn hàng -->
                                        <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light">
                                                        <h5 class="modal-title">Chi tiết đơn hàng <strong>{{ $order->order_number }}</strong></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <small class="text-muted">Trạng thái</small><br>
                                                                <span class="badge bg-{{ $statusBadge[$order->status] ?? 'secondary' }}">{{ $statusLabel[$order->status] ?? 'N/A' }}</span>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                <small class="text-muted">Ngày đặt</small><br>
                                                                <strong>{{ $order->created_at->format('d/m/Y H:i') }}</strong>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <h6 class="mb-3">Thông tin giao hàng</h6>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <small class="text-muted">Người nhận</small><br>
                                                                <strong>{{ $order->shipping_name }}</strong>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <small class="text-muted">Điện thoại</small><br>
                                                                <strong>{{ $order->shipping_phone }}</strong>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <small class="text-muted">Địa chỉ</small><br>
                                                                <strong>{{ $order->shipping_address }}</strong>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <small class="text-muted">Email</small><br>
                                                                <strong>{{ $order->shipping_email }}</strong>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <h6 class="mb-3">Chi tiết sản phẩm</h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-sm">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th>Sản phẩm</th>
                                                                        <th class="text-end">Giá</th>
                                                                        <th class="text-center">Số lượng</th>
                                                                        <th class="text-end">Thành tiền</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($order->items as $item)
                                                                        @php
                                                                            $price = $item->unit_price > 0 ? $item->unit_price : ($item->product->sale_price > 0 ? $item->product->sale_price : $item->product->price);
                                                                            $totalPrice = $item->total_price > 0 ? $item->total_price : ($price * $item->quantity);
                                                                        @endphp
                                                                        <tr>
                                                                            <td>{{ $item->product->name ?? $item->product_name }}</td>
                                                                            <td class="text-end">{{ number_format($price, 0, ',', '.') }}₫</td>
                                                                            <td class="text-center">{{ $item->quantity }}</td>
                                                                            <td class="text-end">{{ number_format($totalPrice, 0, ',', '.') }}₫</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <hr>

                                                        <div class="row">
                                                            <div class="col-md-6 ms-auto">
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <span>Tạm tính:</span>
                                                                    <span>{{ number_format($order->total_amount - ($order->shipping_cost ?? 0) - ($order->tax_amount ?? 0), 0, ',', '.') }}₫</span>
                                                                </div>
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <span>Vận chuyển:</span>
                                                                    <span>{{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}₫</span>
                                                                </div>
                                                                <div class="d-flex justify-content-between mb-3">
                                                                    <span>Thuế:</span>
                                                                    <span>{{ number_format($order->tax_amount ?? 0, 0, ',', '.') }}₫</span>
                                                                </div>
                                                                <hr>
                                                                <div class="d-flex justify-content-between fw-bold fs-5">
                                                                    <span>Tổng cộng:</span>
                                                                    <span class="text-primary">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Status Filter Panes -->
                            @foreach($statusMap as $key => $label)
                                @php $orders = Auth::user()->orders->where('status', $key)->sortByDesc('created_at'); @endphp
                                @if($orders->count() > 0)
                                    <div class="tab-pane fade" id="{{ $key }}" role="tabpanel">
                                        <div class="row">
                                            @foreach($orders as $order)
                                                <div class="col-12 mb-3">
                                                    <div class="card h-100 border-0 shadow-sm">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                                <div>
                                                                    <h6 class="card-title mb-0">Mã đơn: <strong>{{ $order->order_number }}</strong></h6>
                                                                    <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                                                </div>
                                                                <span class="badge bg-{{ $statusBadge[$order->status] ?? 'secondary' }}">{{ $label }}</span>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <small class="text-muted">Tổng tiền</small><br>
                                                                    <strong class="text-primary">{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <small class="text-muted">Số sản phẩm</small><br>
                                                                    <strong>{{ $order->items->sum('quantity') }} sản phẩm</strong>
                                                                </div>
                                                            </div>
                                                            <button class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                                                <i class="bi bi-eye me-2"></i>Xem chi tiết
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info text-center py-5" role="alert">
                            <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                            <strong>Chưa có đơn hàng!</strong><br>
                            <p class="text-muted mb-3">Bạn chưa đặt hàng lần nào.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="bi bi-shop me-2"></i>Bắt đầu mua sắm
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchOrder');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const cards = document.querySelectorAll('#ordersContainer .order-card');
            cards.forEach(card => {
                const orderNumber = card.getAttribute('data-order-number').toLowerCase();
                card.style.display = orderNumber.includes(query) ? 'block' : 'none';
            });
        });
    }

    // Cancel order button handler
    document.querySelectorAll('.cancel-order-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            const orderNumber = this.getAttribute('data-order-number');
            
            if (confirm('Bạn có chắc muốn hủy đơn hàng ' + orderNumber + '?')) {
                fetch('/don-hang/' + orderId + '/huy', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Hủy đơn hàng thành công');
                        location.reload();
                    } else {
                        alert(data.message || 'Có lỗi xảy ra');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi hủy đơn hàng');
                });
            }
        });
    });
});
</script>
@endpush
@endsection
