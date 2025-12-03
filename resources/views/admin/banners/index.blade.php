@extends('layouts.admin')

@section('title', 'Quản lý Banner')

@section('content')
<div class="page-header">
    <div>
        <h1>Quản lý Banner</h1>
        <p class="text-muted">Quản lý các banner hiển thị trên trang chủ</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bannerModal">
        <i class="bi bi-plus-lg"></i> Thêm Banner Mới
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
                    <th style="width: 80px;">Ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
                    <th style="width: 80px;">Thứ tự</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $banner)
                    <tr>
                        <td>
                            @if($banner->image)
                                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" 
                                     style="width: 60px; height: 50px; object-fit: cover; border-radius: 4px;">
                            @else
                                <span class="badge bg-secondary">No Image</span>
                            @endif
                        </td>
                        <td><strong>{{ $banner->title }}</strong></td>
                        <td>
                            <small class="text-muted">{{ Str::limit($banner->description, 50) }}</small>
                        </td>
                        <td>{{ $banner->sort_order }}</td>
                        <td>
                            <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $banner->is_active ? 'Hoạt động' : 'Ẩn' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#bannerModal" 
                                        onclick="editBanner({{ $banner->toJson() }})" title="Chỉnh sửa">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Xóa banner này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Xóa">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <p class="text-muted">Chưa có banner nào</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $banners->links() }}
</div>

<!-- Modal -->
<div class="modal fade" id="bannerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Thêm Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bannerForm" method="POST" enctype="multipart/form-data" action="/admin/banners">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" id="bannerTitle" required>
                        @error('title')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" name="description" id="bannerDescription" rows="3"></textarea>
                        @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ảnh <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="image" id="bannerImage" accept="image/*" required>
                        <div id="imagePreview" class="mt-2"></div>
                        @error('image')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link</label>
                        <input type="url" class="form-control" name="link" id="bannerLink" placeholder="https://example.com">
                        @error('link')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Thứ tự</label>
                            <input type="number" class="form-control" name="sort_order" id="bannerSortOrder" min="0" value="0">
                            @error('sort_order')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" name="is_active" id="bannerActive" value="1" checked>
                                <label class="form-check-label" for="bannerActive">
                                    Kích hoạt
                                </label>
                            </div>
                        </div>
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

<script>
document.getElementById('bannerImage').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(event) {
            preview.innerHTML = '<img src="' + event.target.result + '" style="max-width: 200px; max-height: 150px; border-radius: 4px;">';
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

function editBanner(banner) {
    document.getElementById('modalTitle').innerText = 'Sửa Banner';
    const form = document.getElementById('bannerForm');
    form.action = `/admin/banners/${banner.id}`;
    form.enctype = 'multipart/form-data';
    
    document.getElementById('bannerTitle').value = banner.title;
    document.getElementById('bannerDescription').value = banner.description || '';
    document.getElementById('bannerLink').value = banner.link || '';
    document.getElementById('bannerSortOrder').value = banner.sort_order;
    document.getElementById('bannerActive').checked = banner.is_active;
    
    // Make image optional when editing
    document.getElementById('bannerImage').removeAttribute('required');
    
    const preview = document.getElementById('imagePreview');
    if (banner.image) {
        preview.innerHTML = '<img src="/storage/' + banner.image + '" style="max-width: 200px; max-height: 150px; border-radius: 4px;">';
    } else {
        preview.innerHTML = '';
    }
    
    // Add PUT method
    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        form.insertBefore(methodInput, form.firstChild.nextSibling);
    }
    methodInput.value = 'PUT';
}

document.getElementById('bannerModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('modalTitle').innerText = 'Thêm Banner';
    const form = document.getElementById('bannerForm');
    form.action = '/admin/banners';
    form.method = 'POST';
    form.reset();
    
    // Make image required for adding new banners
    document.getElementById('bannerImage').setAttribute('required', 'required');
    
    // Remove PUT method if exists
    const methodInput = form.querySelector('input[name="_method"]');
    if (methodInput) {
        methodInput.remove();
    }
    
    document.getElementById('imagePreview').innerHTML = '';
    document.getElementById('bannerActive').checked = true;
    document.getElementById('bannerSortOrder').value = 0;
});
</script>
@endsection
