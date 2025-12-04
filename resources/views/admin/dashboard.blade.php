@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header mb-4">
    <div>
        <h2 class="mb-2" style="font-size: 32px; font-weight: 600; color: #2c3e50;">Dashboard</h2>
        <p class="text-muted">Welcome back, Admin! Here's an overview of your store.</p>
    </div>
</div>

<!-- Thống kê Tổng quan / Stats Cards -->
<div class="row mb-4">
    <!-- Tổng sản phẩm -->
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card stat-card stat-card-purple" style="border: none; border-radius: 12px; overflow: hidden; background: linear-gradient(135deg, #e94b7a 0%, #d63f7f 100%);">
            <div class="card-body" style="padding: 24px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div style="flex: 1;">
                        <h6 class="mb-2" style="color: rgba(255, 255, 255, 0.7); font-size: 13px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Tổng sản phẩm</h6>
                        <h2 class="mb-0" style="color: white; font-size: 36px; font-weight: 700;">{{ $stats['total_products'] ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-box-seam" style="font-size: 48px; color: rgba(255, 255, 255, 0.3);"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tổng đơn -->
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card stat-card stat-card-green" style="border: none; border-radius: 12px; overflow: hidden; background: linear-gradient(135deg, #00d084 0%, #00a86b 100%);">
            <div class="card-body" style="padding: 24px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div style="flex: 1;">
                        <h6 class="mb-2" style="color: rgba(255, 255, 255, 0.7); font-size: 13px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Tổng đơn</h6>
                        <h2 class="mb-0" style="color: white; font-size: 36px; font-weight: 700;">{{ $stats['total_orders'] ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-cart3" style="font-size: 48px; color: rgba(255, 255, 255, 0.3);"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Đã bán -->
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card stat-card stat-card-orange" style="border: none; border-radius: 12px; overflow: hidden; background: linear-gradient(135deg, #ff6b6b 0%, #ee5a5a 100%);">
            <div class="card-body" style="padding: 24px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div style="flex: 1;">
                        <h6 class="mb-2" style="color: rgba(255, 255, 255, 0.7); font-size: 13px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Đã bán</h6>
                        <h2 class="mb-0" style="color: white; font-size: 36px; font-weight: 700;">{{ $stats['sold_count'] ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-bag-check" style="font-size: 48px; color: rgba(255, 255, 255, 0.3);"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tổng doanh thu -->
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card stat-card stat-card-yellow" style="border: none; border-radius: 12px; overflow: hidden; background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);">
            <div class="card-body" style="padding: 24px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div style="flex: 1;">
                        <h6 class="mb-2" style="color: rgba(0, 0, 0, 0.5); font-size: 13px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Tổng doanh thu</h6>
                        <h2 class="mb-0" style="color: #333; font-size: 36px; font-weight: 700;">{{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}đ</h2>
                    </div>
                    <i class="bi bi-currency-dollar" style="font-size: 48px; color: rgba(0, 0, 0, 0.2);"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Đơn Hàng Mới / Recent Orders -->
<div class="row">
    <div class="col-12">
        <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);">
            <div class="card-header bg-white border-bottom" style="border-radius: 12px 12px 0 0; padding: 20px; border-bottom: 1px solid #e8edf2;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="font-size: 16px; font-weight: 600; color: #2c3e50;">Đơn Hàng Mới</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%); color: white; border: none; border-radius: 6px; padding: 6px 16px; font-size: 13px; font-weight: 500;">Xem tất cả</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="margin: 0;">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th style="padding: 12px 16px; font-weight: 600; font-size: 13px; color: #666; border: none;">Tên Khách Hàng</th>
                            <th style="padding: 12px 16px; font-weight: 600; font-size: 13px; color: #666; border: none;">Tổng Tiền</th>
                            <th style="padding: 12px 16px; font-weight: 600; font-size: 13px; color: #666; border: none;">Trạng thái</th>
                            <th style="padding: 12px 16px; font-weight: 600; font-size: 13px; color: #666; border: none;">Ngày Đặt Hàng</th>
                            <th style="padding: 12px 16px; font-weight: 600; font-size: 13px; color: #666; border: none;">Hoạt Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders ?? [] as $order)
                        <tr style="border-bottom: 1px solid #e8edf2;">
                            <td style="padding: 12px 16px; color: #2c3e50; font-weight: 500;">
                                {{ $order->user->name ?? 'Khách hàng' }}
                            </td>
                            <td style="padding: 12px 16px; color: #2c3e50; font-weight: 600;">
                                {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}₫
                            </td>
                            <td style="padding: 12px 16px;">
                                @php
                                    $statusMap = [
                                        'pending' => ['Chờ duyệt', '#ffc107'],
                                        'processing' => ['Đang xử lý', '#17a2b8'],
                                        'shipped' => ['Đang giao', '#007bff'],
                                        'completed' => ['Đã giao', '#28a745'],
                                        'cancelled' => ['Đã hủy', '#dc3545']
                                    ];
                                    $status = $statusMap[$order->status] ?? ['Không xác định', '#6c757d'];
                                @endphp
                                <span class="badge" style="background-color: {{ $status[1] }}; color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 500;">
                                    {{ $status[0] }}
                                </span>
                            </td>
                            <td style="padding: 12px 16px; color: #666; font-size: 13px;">
                                {{ $order->created_at->format('Y-m-d H:i:s') }}
                            </td>
                            <td style="padding: 12px 16px;">
                                <a href="{{ route('admin.orders.show', $order->id) }}" style="color: #1e3a8a; text-decoration: none; font-size: 13px; font-weight: 500;">
                                    <i class="bi bi-eye"></i> Xem chi tiết
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted" style="padding: 20px;">
                                Chưa có đơn hàng nào
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mt-4">
    <div class="col-md-8 mb-3">
        <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);">
            <div class="card-header bg-white border-bottom" style="border-radius: 12px 12px 0 0; padding: 20px; border-bottom: 1px solid #e8edf2;">
                <h5 class="mb-0" style="font-size: 16px; font-weight: 600; color: #2c3e50;">Doanh thu theo tháng</h5>
            </div>
            <div class="card-body" style="padding: 20px;">
                <canvas id="revenueChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);">
            <div class="card-header bg-white border-bottom" style="border-radius: 12px 12px 0 0; padding: 20px; border-bottom: 1px solid #e8edf2;">
                <h5 class="mb-0" style="font-size: 16px; font-weight: 600; color: #2c3e50;">Phân loại sản phẩm</h5>
            </div>
            <div class="card-body" style="padding: 20px;">
                <canvas id="categoryChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Prepare monthly revenue data
    @php
        $labels = [];
        $data = [];
        
        foreach ($monthlyRevenue as $item) {
            $labels[] = $item['month_name'];
            $data[] = round($item['revenue'] / 1000000, 2);
        }
        
        $categoryLabels = $categoryBreakdown->pluck('name')->toArray();
        $categoryCounts = $categoryBreakdown->pluck('count')->toArray();
    @endphp

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Doanh thu (triệu ₫)',
                data: {!! json_encode($data) !!},
                borderColor: '#1e3a8a',
                backgroundColor: 'rgba(30, 58, 138, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#1e3a8a',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 15
                    }
                },
                filler: {
                    propagate: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toFixed(1) + 'M';
                        }
                    }
                }
            }
        }
    });

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($categoryLabels) !!},
            datasets: [{
                data: {!! json_encode($categoryCounts) !!},
                backgroundColor: [
                    '#1e3a8a',
                    '#2563eb',
                    '#3b82f6',
                    '#60a5fa',
                    '#93c5fd',
                    '#dbeafe',
                    '#eff6ff',
                    '#1e40af'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true
                    }
                }
            }
        }
    });
</script>
@endpush

