@extends('layouts.admin')

@section('title', 'Phụ kiện')

@section('content')
<div class="page-header">
    <div>
        <h1>Quản lý Phụ kiện</h1>
        <p class="text-muted">Quản lý các phụ kiện sản phẩm</p>
    </div>
    <a href="{{ route('admin.accessories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm Phụ kiện
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
                    <th>Hình ảnh</th>
                    <th>Tên Phụ kiện</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($accessories as $accessory)
                        <tr>
                            <td>
                                @if($accessory->image)
                                    <img src="{{ asset('storage/' . $accessory->image) }}" alt="{{ $accessory->name }}" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <span class="badge bg-secondary">Không có ảnh</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $accessory->name }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit($accessory->description, 50) }}</small>
                            </td>
                            <td>{{ number_format($accessory->price, 0, ',', '.') }}đ</td>
                            <td>
                                <span class="badge {{ $accessory->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $accessory->stock }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $accessory->is_active ? 'bg-info' : 'bg-secondary' }}">
                                    {{ $accessory->is_active ? 'Hoạt động' : 'Ẩn' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.accessories.edit', $accessory->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.accessories.destroy', $accessory->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Bạn chắc chắn muốn xóa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="text-muted">Chưa có phụ kiện nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
