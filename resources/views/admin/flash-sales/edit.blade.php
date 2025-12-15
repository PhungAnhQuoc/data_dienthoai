@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Flash Sale')

@section('content')
<div class="page-header">
    <div>
        <h1>Chỉnh Sửa Flash Sale</h1>
        <p class="text-muted">Cập nhật thông tin khuyến mãi flash sale</p>
    </div>
    <a href="{{ route('admin.flash-sales.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Quay Lại
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.flash-sales.update', $flashSale->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Thông Tin Cơ Bản -->
                <div class="col-md-8">
                    <h5 class="mb-4 fw-bold">Thông Tin Flash Sale</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Chọn Sản Phẩm (Tùy Chọn)</label>
                        <select class="form-select @error('product_id') is-invalid @enderror" 
                                name="product_id" id="productSelect">
                            <option value="">-- Không chọn sản phẩm --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                        data-name="{{ $product->name }}"
                                        data-price="{{ $product->price }}"
                                        {{ old('product_id', $flashSale->product_id) == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} ({{ number_format($product->price, 0, ',', '.') }}₫)
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tên Flash Sale <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               name="title" value="{{ old('title', $flashSale->title) }}" 
                               placeholder="VD: iPhone 15 Pro Max" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô Tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  name="description" rows="3"
                                  placeholder="Mô tả ngắn về sản phẩm flash sale...">{{ old('description', $flashSale->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giá Gốc <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('original_price') is-invalid @enderror" 
                                   name="original_price" value="{{ old('original_price', $flashSale->original_price) }}" 
                                   step="1000" min="0" required>
                            @error('original_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giá Khuyến Mãi <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('sale_price') is-invalid @enderror" 
                                   name="sale_price" value="{{ old('sale_price', $flashSale->sale_price) }}" 
                                   step="1000" min="0" required>
                            @error('sale_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số Lượng <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   name="stock" value="{{ old('stock', $flashSale->stock) }}" min="1" required>
                            <small class="text-muted">Đã bán: {{ $flashSale->sold }}</small>
                            @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Màu Badge <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color @error('color_badge') is-invalid @enderror" 
                                       name="color_badge" value="{{ old('color_badge', $flashSale->color_badge) }}" required>
                                <input type="text" class="form-control" value="{{ old('color_badge', $flashSale->color_badge) }}" readonly>
                            </div>
                            @error('color_badge')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <h5 class="mb-3 fw-bold mt-5">Thời Gian Flash Sale</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bắt Đầu Lúc <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('starts_at') is-invalid @enderror" 
                                   name="starts_at" 
                                   value="{{ old('starts_at', $flashSale->starts_at->format('Y-m-d\TH:i')) }}" required>
                            @error('starts_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kết Thúc Lúc <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('ends_at') is-invalid @enderror" 
                                   name="ends_at" 
                                   value="{{ old('ends_at', $flashSale->ends_at->format('Y-m-d\TH:i')) }}" required>
                            @error('ends_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Hình Ảnh & Cài Đặt -->
                <div class="col-md-4">
                    <h5 class="mb-4 fw-bold">Hình Ảnh & Cài Đặt</h5>

                    <div class="mb-3">
                        <label class="form-label">Hình Ảnh</label>
                        <div class="mb-2">
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   name="image" accept="image/*" id="flashSaleImage">
                            <small class="text-muted">Để trống nếu không muốn thay đổi</small>
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div id="imagePreview" class="mt-3">
                            @if($flashSale->image)
                                <img src="{{ asset('storage/' . $flashSale->image) }}" 
                                     style="max-width: 200px; max-height: 200px; border-radius: 8px; object-fit: cover;">
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Độ Ưu Tiên</label>
                        <input type="number" class="form-control" name="sort_order" 
                               value="{{ old('sort_order', $flashSale->sort_order) }}" min="0">
                        <small class="text-muted">Số càng nhỏ, vị trí càng trước</small>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" 
                               value="1" id="flashSaleActive" 
                               {{ old('is_active', $flashSale->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="flashSaleActive">
                            Kích Hoạt Flash Sale
                        </label>
                    </div>

                    <div class="alert alert-info">
                        <strong>📊 Thống Kê:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Tổng: {{ $flashSale->stock }} sản phẩm</li>
                            <li>Đã bán: {{ $flashSale->sold }} sản phẩm</li>
                            <li>Còn lại: {{ $flashSale->getRemainingStock() }} sản phẩm</li>
                            <li>Tỉ lệ bán: {{ $flashSale->getSoldPercentage() }}%</li>
                        </ul>
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Cập Nhật Flash Sale
                </button>
                <a href="{{ route('admin.flash-sales.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Hủy
                </a>
            </div>
        </form>
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
}
</style>

<script>
document.getElementById('productSelect').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    
    if (this.value) {
        const name = selectedOption.dataset.name;
        const price = selectedOption.dataset.price;
        
        document.querySelector('input[name="title"]').value = name;
        document.querySelector('input[name="original_price"]').value = price;
        
        // Optional: Set sale price to 80% of original
        document.querySelector('input[name="sale_price"]').value = Math.floor(price * 0.8);
    }
});

document.getElementById('flashSaleImage').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(event) {
            preview.innerHTML = '<img src="' + event.target.result + 
                              '" style="max-width: 200px; max-height: 200px; border-radius: 8px; object-fit: cover;">';
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

// Update color display
document.querySelector('input[name="color_badge"]').addEventListener('change', function(e) {
    document.querySelector('input[readonly]').value = e.target.value;
});
</script>
@endsection
