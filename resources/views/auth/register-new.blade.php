@extends('layouts.app')

@section('title', 'Đăng ký - MobileShop')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    <!-- Logo -->
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-2">
                            <span class="text-primary">Mobile</span>Shop
                        </h2>
                        <p class="text-muted fs-6">Tạo tài khoản mới để bắt đầu mua sắm</p>
                    </div>

                    <!-- Errors -->
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <strong>Lỗi đăng ký!</strong>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <!-- Register Form -->
                    <form action="{{ route('register.post') }}" method="POST" novalidate>
                        @csrf

                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold text-dark">Họ và tên</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-person text-primary"></i>
                                </span>
                                <input type="text" class="form-control border-0 @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" 
                                       placeholder="Nhập họ tên của bạn" required>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold text-dark">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-envelope text-primary"></i>
                                </span>
                                <input type="email" class="form-control border-0 @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" 
                                       placeholder="Nhập email của bạn" required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Phone (Optional) -->
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold text-dark">Số điện thoại <span class="text-muted">(Tùy chọn)</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-telephone text-primary"></i>
                                </span>
                                <input type="tel" class="form-control border-0 @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}" 
                                       placeholder="Nhập số điện thoại">
                            </div>
                            @error('phone')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Address (Optional) -->
                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold text-dark">Địa chỉ <span class="text-muted">(Tùy chọn)</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-geo-alt text-primary"></i>
                                </span>
                                <input type="text" class="form-control border-0 @error('address') is-invalid @enderror" 
                                       id="address" name="address" value="{{ old('address') }}" 
                                       placeholder="Nhập địa chỉ của bạn">
                            </div>
                            @error('address')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold text-dark">Mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-lock text-primary"></i>
                                </span>
                                <input type="password" class="form-control border-0 @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Tối thiểu 8 ký tự" required>
                            </div>
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle me-1"></i>
                                Mật khẩu phải có ít nhất 8 ký tự bao gồm chữ hoa, chữ thường, số
                            </small>
                            @error('password')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-bold text-dark">Xác nhận mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-lock-check text-primary"></i>
                                </span>
                                <input type="password" class="form-control border-0 @error('password_confirmation') is-invalid @enderror" 
                                       id="password_confirmation" name="password_confirmation" 
                                       placeholder="Nhập lại mật khẩu" required>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold mb-4 rounded-3">
                            <i class="bi bi-person-plus me-2"></i>Đăng ký
                        </button>
                    </form>

                    <!-- Divider -->
                    <hr class="my-4">

                    <!-- Sign In Link -->
                    <p class="text-center text-muted mb-0">
                        Đã có tài khoản?
                        <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">
                            Đăng nhập ngay
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
