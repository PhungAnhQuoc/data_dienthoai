@extends('layouts.admin')

@section('title', 'Database Info')

@section('content')
<div class="page-header">
    <h1>Thông Tin Database</h1>
    <p class="text-muted">Xem thông tin tất cả các dữ liệu trong hệ thống</p>
</div>

<!-- Stats Overview -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Tổng Người Dùng</h6>
                        <h2 class="mb-0">{{ $totalUsers }}</h2>
                    </div>
                    <i class="bi bi-people fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card secondary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Tổng Sản Phẩm</h6>
                        <h2 class="mb-0">{{ $totalProducts }}</h2>
                    </div>
                    <i class="bi bi-box fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Tổng Đơn Hàng</h6>
                        <h2 class="mb-0">{{ $totalOrders }}</h2>
                    </div>
                    <i class="bi bi-cart-check fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Tổng Phụ Kiện</h6>
                        <h2 class="mb-0">{{ $totalAccessories }}</h2>
                    </div>
                    <i class="bi bi-headphones fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tables -->
<div class="row">
    <!-- Users Table -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">10 Người Dùng Gần Đây</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Vai Trò</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td><small>{{ $user->email }}</small></td>
                                <td>
                                    <span class="badge {{ $user->is_admin ? 'bg-danger' : 'bg-info' }}">
                                        {{ $user->is_admin ? 'Admin' : 'User' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">Chưa có người dùng</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">10 Sản Phẩm Gần Đây</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tên</th>
                            <th>Giá</th>
                            <th>Kho</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentProducts as $product)
                            <tr>
                                <td><small>{{ $product->name }}</small></td>
                                <td>{{ number_format($product->price, 0, ',', '.') }}đ</td>
                                <td>
                                    <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">Chưa có sản phẩm</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Danh Mục</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tên</th>
                            <th>Số Sản Phẩm</th>
                            <th>Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td><span class="badge bg-info">{{ $category->products_count }}</span></td>
                                <td>
                                    <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $category->is_active ? 'Hoạt động' : 'Ẩn' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">Chưa có danh mục</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Brands Table -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Thương Hiệu</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tên</th>
                            <th>Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands as $brand)
                            <tr>
                                <td>{{ $brand->name }}</td>
                                <td>
                                    <span class="badge {{ $brand->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $brand->is_active ? 'Hoạt động' : 'Ẩn' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-3">Chưa có thương hiệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">10 Đơn Hàng Gần Đây</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Khách Hàng</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th>Thanh Toán</th>
                            <th>Ngày</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td><code>{{ $order->order_number }}</code></td>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td><strong>{{ number_format($order->total_amount, 0, ',', '.') }}đ</strong></td>
                                <td>
                                    <span class="badge {{ $order->status === 'completed' ? 'bg-success' : ($order->status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td><small>{{ $order->created_at->format('d/m/Y H:i') }}</small></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">Chưa có đơn hàng</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Accessories Table -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Phụ Kiện</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tên</th>
                            <th>Giá</th>
                            <th>Kho</th>
                            <th>Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($accessories as $accessory)
                            <tr>
                                <td>{{ $accessory->name }}</td>
                                <td>{{ number_format($accessory->price, 0, ',', '.') }}đ</td>
                                <td><span class="badge bg-info">{{ $accessory->stock }}</span></td>
                                <td>
                                    <span class="badge {{ $accessory->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $accessory->is_active ? 'Hoạt động' : 'Ẩn' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Chưa có phụ kiện</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
