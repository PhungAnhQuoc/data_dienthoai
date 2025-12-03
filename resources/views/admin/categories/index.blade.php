@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="page-header">
    <div>
        <h1>Quản lý Danh Mục</h1>
        <p class="text-muted">Quản lý các danh mục sản phẩm</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">
        <i class="bi bi-plus-circle"></i> Thêm Danh Mục
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
                    <th>Tên Danh Mục</th>
                    <th>Slug</th>
                    <th>Số Sản Phẩm</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td><code>{{ $category->slug }}</code></td>
                        <td>
                            <span class="badge bg-info">{{ $category->products_count ?? 0 }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $category->is_active ? 'Hoạt động' : 'Ẩn' }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#categoryModal" 
                                    onclick="editCategory({{ $category->toJson() }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Xóa danh mục này?');">
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
                            <p class="text-muted">Chưa có danh mục nào</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $categories->links() }}
</div>

<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Thêm Danh Mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="categoryForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên Danh Mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="categoryName" required>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="categoryActive" value="1">
                        <label class="form-check-label" for="categoryActive">
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
function editCategory(category) {
    document.getElementById('modalTitle').innerText = 'Sửa Danh Mục';
    document.getElementById('categoryForm').action = `/admin/categories/${category.id}`;
    document.getElementById('categoryForm').innerHTML = '@csrf @method("PUT")' +
        '<div class="modal-body">' +
        '<div class="mb-3"><label class="form-label">Tên Danh Mục <span class="text-danger">*</span></label>' +
        '<input type="text" class="form-control" name="name" value="' + category.name + '" required></div>' +
        '<div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" ' + (category.is_active ? 'checked' : '') + '>' +
        '<label class="form-check-label">Kích hoạt</label></div></div>' +
        '<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>' +
        '<button type="submit" class="btn btn-primary">Cập nhật</button></div>';
}

document.getElementById('categoryModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('modalTitle').innerText = 'Thêm Danh Mục';
    document.getElementById('categoryForm').action = '/admin/categories';
    document.getElementById('categoryForm').method = 'POST';
    document.getElementById('categoryForm').innerHTML = '@csrf<div class="modal-body">' +
        '<div class="mb-3"><label class="form-label">Tên Danh Mục <span class="text-danger">*</span></label>' +
        '<input type="text" class="form-control" name="name" required></div>' +
        '<div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1">' +
        '<label class="form-check-label">Kích hoạt</label></div></div>' +
        '<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>' +
        '<button type="submit" class="btn btn-primary">Lưu</button></div>';
});
</script>
@endsection
