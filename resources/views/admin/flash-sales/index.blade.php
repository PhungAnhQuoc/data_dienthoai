@extends('layouts.admin')

@section('title', 'Quản Lý Flash Sales')

@section('content')
<div class="page-header">
    <div>
        <h1>Quản Lý Flash Sales</h1>
        <p class="text-muted">Tạo và quản lý các đợt Flash Sale khuyến mãi</p>
    </div>
    <a href="{{ route('admin.flash-sales.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tạo Flash Sale
    </a>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Hình Ảnh</th>
                    <th>Tên Flash Sale</th>
                    <th>Sản Phẩm</th>
                    <th>Giá Gốc</th>
                    <th>Giá Khuyến Mãi</th>
                    <th>Giảm Giá</th>
                    <th>Thời Gian</th>
                    <th>Hàng Tồn / Đã Bán</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($flashSales as $sale)
                <tr>
                    <td>
                        @if($sale->image)
                            <img src="{{ asset('storage/' . $sale->image) }}" 
                                 alt="{{ $sale->title }}" 
                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $sale->title }}</strong><br>
                        <small class="text-muted">{{ Str::limit($sale->description, 50) }}</small>
                    </td>
                    <td>
                        @if($sale->product)
                            <a href="{{ route('admin.products.edit', $sale->product->id) }}" 
                               class="btn btn-sm btn-outline-info">
                                <i class="bi bi-box"></i> {{ $sale->product->name }}
                            </a>
                        @else
                            <span class="badge bg-light text-dark">Không liên kết</span>
                        @endif
                    </td>
                    <td>{{ number_format($sale->original_price, 0, ',', '.') }}đ</td>
                    <td class="text-danger fw-bold">{{ number_format($sale->sale_price, 0, ',', '.') }}đ</td>
                    <td>
                        <span class="badge bg-warning">-{{ $sale->discount_percentage }}%</span>
                    </td>
                    <td>
                        <small>
                            <strong>Từ:</strong> {{ $sale->starts_at->format('d/m H:i') }}<br>
                            <strong>Đến:</strong> {{ $sale->ends_at->format('d/m H:i') }}
                        </small>
                    </td>
                    <td>
                        {{ $sale->getRemainingStock() }} / {{ $sale->sold }}
                        <div class="progress mt-1" style="height: 4px;">
                            <div class="progress-bar bg-danger" role="progressbar" 
                                 style="width: {{ $sale->getSoldPercentage() }}%"></div>
                        </div>
                    </td>
                    <td>
                        @if($sale->is_active)
                            <span class="badge bg-success">Kích Hoạt</span>
                        @else
                            <span class="badge bg-secondary">Vô Hiệu</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.flash-sales.edit', $sale->id) }}" 
                           class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.flash-sales.destroy', $sale->id) }}" 
                              method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Xóa flash sale này?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-4">
                        <p class="text-muted">Chưa có Flash Sale nào</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $flashSales->links() }}
</div>

<style>
.page-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.page-header h1 {
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
}

.table-light th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    opacity: 0.9;
}
</style>
@endsection
