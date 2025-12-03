@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="page-header">
    <h1>Edit Product</h1>
    <p class="text-muted">Update mobile phone product information.</p>
</div>

<form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    @method('PUT')
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               name="name" 
                               value="{{ old('name', $product->name) }}"
                               required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    name="category_id" 
                                    required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Brand <span class="text-danger">*</span></label>
                            <select class="form-select @error('brand_id') is-invalid @enderror" 
                                    name="brand_id" 
                                    required>
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">SKU <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('sku') is-invalid @enderror" 
                               name="sku" 
                               value="{{ old('sku', $product->sku) }}"
                               required>
                        @error('sku')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  name="description" 
                                  rows="3">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Specifications</label>
                        <textarea class="form-control @error('specifications') is-invalid @enderror" 
                                  name="specifications" 
                                  rows="5">{{ old('specifications', $product->specifications) }}</textarea>
                        <small class="text-muted">You can use HTML for formatting</small>
                        @error('specifications')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Pricing & Stock</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Original Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       name="price" 
                                       value="{{ old('price', $product->price) }}"
                                       step="0.01"
                                       required>
                                <span class="input-group-text">đ</span>
                            </div>
                            @error('price')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Sale Price</label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control @error('sale_price') is-invalid @enderror" 
                                       name="sale_price" 
                                       value="{{ old('sale_price', $product->sale_price) }}"
                                       step="0.01">
                                <span class="input-group-text">đ</span>
                            </div>
                            @error('sale_price')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Stock <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('stock') is-invalid @enderror" 
                                   name="stock" 
                                   value="{{ old('stock', $product->stock) }}"
                                   required>
                            @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accessories -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Phụ Kiện Đi Kèm</h5>
                </div>
                <div class="card-body">
                    @if($accessories->count() > 0)
                        <div class="list-group">
                            @foreach($accessories as $accessory)
                                <label class="list-group-item">
                                    <input class="form-check-input me-1" 
                                           type="checkbox" 
                                           name="accessories[]" 
                                           value="{{ $accessory->id }}"
                                           {{ in_array($accessory->id, old('accessories', $selectedAccessories ?? [])) ? 'checked' : '' }}>
                                    <span>{{ $accessory->name }}</span>
                                    <small class="text-muted d-block ms-4">{{ number_format($accessory->price, 0, ',', '.') }}đ</small>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Chưa có phụ kiện nào. <a href="{{ route('admin.accessories.create') }}">Thêm mới</a></p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Main Image -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Main Image</h5>
                </div>
                <div class="card-body">
                    @if($product->main_image)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 250px;">
                        <small class="text-muted d-block mt-2">Current image</small>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Change Image (Optional)</label>
                        <input type="file" 
                               class="form-control @error('main_image') is-invalid @enderror" 
                               name="main_image" 
                               id="main_image"
                               accept="image/*"
                               onchange="previewImage(event)">
                        @error('main_image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="image-preview" class="text-center d-none">
                        <img src="" alt="Preview" class="img-fluid rounded" style="max-height: 250px;">
                    </div>
                </div>
            </div>

            <!-- Options -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Options</h5>
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="is_active" 
                               id="is_active"
                               value="1"
                               {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="is_featured" 
                               id="is_featured"
                               value="1"
                               {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            Featured Product
                        </label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="is_new" 
                               id="is_new"
                               value="1"
                               {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_new">
                            New Product
                        </label>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="is_bestseller" 
                               id="is_bestseller"
                               value="1"
                               {{ old('is_bestseller', $product->is_bestseller) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_bestseller">
                            Bestseller
                        </label>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-check-circle me-2"></i>Update Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary w-100">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
.page-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e9ecef;
}

.page-header h1 {
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
}

.card {
    border: none;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.card-header {
    border-bottom: 1px solid #e9ecef;
}

.form-label {
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
}

.form-control, .form-select {
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 10px 12px;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    transition: all 0.3s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: #e9ecef;
    color: #333;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    transition: all 0.3s;
}

.btn-secondary:hover {
    background: #dee2e6;
    color: #333;
}

.form-check-input {
    width: 1.5em;
    height: 1.5em;
    margin-top: 0.3em;
    cursor: pointer;
}

.form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
}
</style>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#description'), {
        toolbar: {
            items: ['bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'link', 'blockQuote', 'imageUpload', 'insertTable'],
            shouldNotGroupWhenFull: true
        },
        image: {
            toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side']
        },
        table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
        }
    })
    .then(editor => {
        console.log('CKEditor loaded');
    })
    .catch(error => {
        console.error(error);
    });

function previewImage(event) {
    const preview = document.getElementById('image-preview');
    const img = preview.querySelector('img');
    
    if (event.target.files && event.target.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('d-none');
        }
        
        reader.readAsDataURL(event.target.files[0]);
    }
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.needs-validation');
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>
@endpush
