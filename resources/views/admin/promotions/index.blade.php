@extends('layouts.admin')

@section('title', 'Quản lý mã ưu đãi - Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0">
                <i class="bi bi-tag"></i> Quản lý mã ưu đãi
            </h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Thêm mã ưu đãi
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 15%">Mã</th>
                        <th style="width: 25%">Mô tả</th>
                        <th style="width: 15%">Loại & Giá trị</th>
                        <th style="width: 20%">Thời gian</th>
                        <th style="width: 10%">Trạng thái</th>
                        <th style="width: 15%" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promotions as $promotion)
                        <tr>
                            <td>
                                <span class="badge bg-info">{{ $promotion->code }}</span>
                            </td>
                            <td>
                                <small>{{ $promotion->description ?? 'Không có mô tả' }}</small>
                            </td>
                            <td>
                                <div class="fw-bold">
                                    @if($promotion->discount_type === 'percentage')
                                        {{ $promotion->discount_value }}%
                                    @else
                                        {{ number_format($promotion->discount_value, 0, ',', '.') }}₫
                                    @endif
                                </div>
                                <small class="text-muted">
                                    {{ $promotion->discount_type === 'percentage' ? 'Phần trăm' : 'Cố định' }}
                                </small>
                            </td>
                            <td>
                                <div class="small">
                                    <div>Từ: {{ date('d/m/Y', strtotime($promotion->start_date)) }}</div>
                                    <div>Đến: {{ date('d/m/Y', strtotime($promotion->end_date)) }}</div>
                                </div>
                            </td>
                            <td>
                                @if($promotion->is_active)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Hoạt động
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-x-circle me-1"></i>Không hoạt động
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.promotions.edit', $promotion->id) }}" 
                                       class="btn btn-outline-primary" title="Chỉnh sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" 
                                          action="{{ route('admin.promotions.destroy', $promotion->id) }}" 
                                          style="display:inline-block;"
                                          onsubmit="return confirm('Bạn chắc chắn muốn xóa mã ưu đãi này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Xóa">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Chưa có mã ưu đãi nào
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($promotions->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $promotions->links() }}
        </div>
    @endif
</div>
@endsection
