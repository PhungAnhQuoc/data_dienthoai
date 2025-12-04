@extends('layouts.admin')

@section('title', 'Chỉnh sửa mã ưu đãi - Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0">
                <i class="bi bi-pencil-square"></i> Chỉnh sửa mã ưu đãi
            </h2>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            <strong>Lỗi kiểm tra dữ liệu:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="code" class="form-label fw-bold">Mã ưu đãi <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('code') is-invalid @enderror" 
                                   id="code" 
                                   name="code" 
                                   placeholder="VD: SUMMER20"
                                   value="{{ old('code', $promotion->code) }}"
                                   required
                                   style="text-transform: uppercase;">
                            @error('code')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Mã phải duy nhất và viết bằng chữ hoa</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Mô tả</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Mô tả chi tiết về mã ưu đãi...">{{ old('description', $promotion->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount_type" class="form-label fw-bold">Loại giảm giá <span class="text-danger">*</span></label>
                                    <select class="form-select @error('discount_type') is-invalid @enderror" 
                                            id="discount_type" 
                                            name="discount_type"
                                            required>
                                        <option value="">-- Chọn loại --</option>
                                        <option value="percentage" {{ old('discount_type', $promotion->discount_type) === 'percentage' ? 'selected' : '' }}>Phần trăm (%)</option>
                                        <option value="fixed" {{ old('discount_type', $promotion->discount_type) === 'fixed' ? 'selected' : '' }}>Cố định (₫)</option>
                                    </select>
                                    @error('discount_type')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount_value" class="form-label fw-bold">Giá trị <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           class="form-control @error('discount_value') is-invalid @enderror" 
                                           id="discount_value" 
                                           name="discount_value" 
                                           placeholder="0"
                                           value="{{ old('discount_value', $promotion->discount_value) }}"
                                           step="0.01"
                                           min="0"
                                           required>
                                    @error('discount_value')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted" id="discount_unit">Nhập giá trị giảm giá</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label fw-bold">Ngày bắt đầu <span class="text-danger">*</span></label>
                                    <input type="date" 
                                           class="form-control @error('start_date') is-invalid @enderror" 
                                           id="start_date" 
                                           name="start_date" 
                                           value="{{ old('start_date', $promotion->start_date->format('Y-m-d')) }}"
                                           required>
                                    @error('start_date')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label fw-bold">Ngày kết thúc <span class="text-danger">*</span></label>
                                    <input type="date" 
                                           class="form-control @error('end_date') is-invalid @enderror" 
                                           id="end_date" 
                                           name="end_date" 
                                           value="{{ old('end_date', $promotion->end_date->format('Y-m-d')) }}"
                                           required>
                                    @error('end_date')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', $promotion->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    <strong>Kích hoạt mã ưu đãi</strong>
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Cập nhật
                            </button>
                            <a href="{{ route('admin.promotions.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('discount_type').addEventListener('change', function() {
    const unit = this.value === 'percentage' ? '%' : '₫';
    document.getElementById('discount_unit').textContent = `Nhập giá trị giảm giá (${unit})`;
});

// Trigger on page load to show correct unit
document.getElementById('discount_type').dispatchEvent(new Event('change'));
</script>
@endpush
@endsection
