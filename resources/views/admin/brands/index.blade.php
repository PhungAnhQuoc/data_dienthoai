@extends('layouts.admin')

@section('title', 'Brands')

@section('content')
<div class="page-header">
    <div>
        <h1>Quản lý Thương Hiệu</h1>
        <p class="text-muted">Quản lý các thương hiệu sản phẩm</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#brandModal">
        <i class="bi bi-plus-circle"></i> Thêm Thương Hiệu
    </button>
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
                    <th>Logo</th>
                    <th>Tên Thương Hiệu</th>
                    <th>Slug</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                    <tr>
                        <td>
                            @if($brand->logo)
                                <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" 
                                     style="width: 40px; height: 40px; object-fit: contain;">
                            @else
                                <span class="badge bg-secondary">No Logo</span>
                            @endif
                        </td>
                        <td><strong>{{ $brand->name }}</strong></td>
                        <td><code>{{ $brand->slug }}</code></td>
                        <td>
                            <span class="badge {{ $brand->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $brand->is_active ? 'Hoạt động' : 'Ẩn' }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#brandModal" 
                                    onclick="editBrand({{ $brand->toJson() }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Xóa thương hiệu này?');">
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
                        <td colspan="5" class="text-center py-4">
                            <p class="text-muted">Chưa có thương hiệu nào</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $brands->links() }}
</div>

<!-- Modal -->
<div class="modal fade" id="brandModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Thêm Thương Hiệu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="brandForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên Thương Hiệu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="brandName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" class="form-control" name="logo" id="brandLogo" accept="image/*">
                        <div id="logoPreview" class="mt-2"></div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="brandActive" value="1">
                        <label class="form-check-label" for="brandActive">
                            Kích hoạt
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editBrand(brand) {
    document.getElementById('modalTitle').innerText = 'Sửa Thương Hiệu';
    const form = document.getElementById('brandForm');
    form.action = `/admin/brands/${brand.id}`;
    form.enctype = 'multipart/form-data';
    form.innerHTML = '@csrf @method("PUT")' +
        '<div class="modal-body">' +
        '<div class="mb-3"><label class="form-label">Tên Thương Hiệu <span class="text-danger">*</span></label>' +
        '<input type="text" class="form-control" name="name" value="' + brand.name + '" required></div>' +
        '<div class="mb-3"><label class="form-label">Logo</label>' +
        '<input type="file" class="form-control" name="logo" accept="image/*">' +
        (brand.logo ? '<img src="/storage/' + brand.logo + '" style="width:80px; margin-top:10px;">' : '') +
        '</div>' +
        '<div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" ' + (brand.is_active ? 'checked' : '') + '>' +
        '<label class="form-check-label">Kích hoạt</label></div></div>' +
        '<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>' +
        '<button type="submit" class="btn btn-primary">Cập nhật</button></div>';
}

document.getElementById('brandModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('modalTitle').innerText = 'Thêm Thương Hiệu';
    const form = document.getElementById('brandForm');
    form.action = '/admin/brands';
    form.method = 'POST';
    form.enctype = 'multipart/form-data';
    form.innerHTML = '@csrf<div class="modal-body">' +
        '<div class="mb-3"><label class="form-label">Tên Thương Hiệu <span class="text-danger">*</span></label>' +
        '<input type="text" class="form-control" name="name" required></div>' +
        '<div class="mb-3"><label class="form-label">Logo</label>' +
        '<input type="file" class="form-control" name="logo" accept="image/*"></div>' +
        '<div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1">' +
        '<label class="form-check-label">Kích hoạt</label></div></div>' +
        '<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>' +
        '<button type="submit" class="btn btn-primary">Lưu</button></div>';
});
</script>
@endsection
