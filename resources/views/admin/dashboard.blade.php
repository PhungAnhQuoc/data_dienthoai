@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1>Dashboard</h1>
        <p class="text-muted">Xin chào {{ Auth::user()->name }}, chào mừng đến với admin panel!</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Tổng sản phẩm</h6>
                        <h2 class="mb-0">{{ $stats['total_products'] ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-box-seam fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card secondary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Đang bán</h6>
                        <h2 class="mb-0">{{ $stats['active_products'] ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-check-circle fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Hết hàng</h6>
                        <h2 class="mb-0">{{ $stats['out_of_stock'] ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-exclamation-triangle fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Danh mục</h6>
                        <h2 class="mb-0">{{ $stats['total_categories'] ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-folder fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <a href="{{ route('admin.contact.index') }}" class="text-decoration-none">
            <div class="card stat-card info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Liên hệ mới</h6>
                            <h2 class="mb-0">{{ \App\Models\ContactMessage::where('status', 'pending')->count() }}</h2>
                        </div>
                        <i class="bi bi-envelope fs-1 text-white-50"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">Doanh thu theo tháng</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">Phân loại sản phẩm</h5>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Products -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Sản phẩm mới nhất</h5>
                <a href="/admin/products" class="btn btn-sm btn-primary">Xem tất cả</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>SKU</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentProducts ?? [] as $product)
                        <tr>
                            <td>
                                @if($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                @else
                                <div style="width: 50px; height: 50px; background: #f0f0f0; border-radius: 8px;"></div>
                                @endif
                            </td>
                            <td><strong>{{ Str::limit($product->name, 40) }}</strong></td>
                            <td>{{ $product->id ?? 'N/A' }}</td>
                            <td><strong class="text-primary">{{ number_format($product->price, 0, ',', '.') }}đ</strong></td>
                            <td>
                                @if($product->stock > 10)
                                <span class="badge bg-success">{{ $product->stock }}</span>
                                @elseif($product->stock > 0)
                                <span class="badge bg-warning">{{ $product->stock }}</span>
                                @else
                                <span class="badge bg-danger">Hết hàng</span>
                                @endif
                            </td>
                            <td>
                                @if($product->is_active)
                                <span class="badge bg-success">Đang bán</span>
                                @else
                                <span class="badge bg-secondary">Ngừng bán</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Edit</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Chưa có sản phẩm nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Prepare monthly revenue data
    @php
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $labels = [];
        $data = [];
        
        // Get last 12 months
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthNum = $date->month;
            $year = $date->year;
            
            $labels[] = 'Tháng ' . $monthNum;
            
            $revenue = $monthlyRevenue->where('month', $monthNum)->where('year', $year)->first();
            $data[] = $revenue ? round($revenue['revenue'] / 1000000, 2) : 0;
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
                label: 'Doanh thu (triệu đ)',
                data: {!! json_encode($data) !!},
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + 'M';
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
                    '#667eea',
                    '#f093fb',
                    '#4facfe',
                    '#fa709a',
                    '#30b0ce',
                    '#f5a623',
                    '#4cb73d'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush

