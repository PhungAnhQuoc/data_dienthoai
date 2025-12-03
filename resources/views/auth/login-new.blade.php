@extends('layouts.app')

@section('title', 'Đăng nhập - MobileShop')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    <!-- Logo -->
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-2">
                            <span class="text-primary">Mobile</span>Shop
                        </h2>
                        <p class="text-muted fs-6">Đăng nhập vào tài khoản của bạn</p>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <!-- Warning Message -->
                    @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <!-- Errors -->
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <strong>Lỗi đăng nhập!</strong>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <!-- Login Form -->
                    <form action="{{ route('login.post') }}" method="POST" novalidate>
                        @csrf

                        <!-- Email -->
                        <div class="mb-4">
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

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold text-dark">Mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-lock text-primary"></i>
                                </span>
                                <input type="password" class="form-control border-0 @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Nhập mật khẩu" required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember" value="1">
                                <label class="form-check-label" for="remember">
                                    Ghi nhớ tôi
                                </label>
                            </div>
                            <a href="{{ route('password.request') }}" class="text-primary text-decoration-none small">Quên mật khẩu?</a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold mb-4 rounded-3">
                            <i class="bi bi-door-open me-2"></i>Đăng nhập
                        </button>
                    </form>

                    <!-- Divider -->
                    <hr class="my-4">

                    <!-- Sign Up Link -->
                    <p class="text-center text-muted mb-0">
                        Chưa có tài khoản?
                        <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">
                            Đăng ký ngay
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
