@extends('layouts.app')

@section('title', 'Tra cứu đơn hàng - MobileShop')

@section('content')
<div class="container py-5">
    <!-- Search Section -->
    <div class="bg-light rounded-3 p-5 mb-5">
        <h2 class="text-center mb-2">Tra cứu đơn hàng</h2>
        <p class="text-center text-muted mb-4">Nhập mã đơn hàng hoặc số điện thoại để xem trạng thái giao hàng</p>
        
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="{{ route('orders.tracking.search') }}" method="POST" class="d-flex flex-column gap-3">
                    @csrf
                    <input type="text" 
                           class="form-control form-control-lg @error('order_number') is-invalid @enderror" 
                           name="order_number" 
                           placeholder="Mã đơn hàng (ví dụ: ORD-202512001)"
                           value="{{ old('order_number') }}"
                           required>
                    <input type="email" 
                           class="form-control form-control-lg @error('email') is-invalid @enderror" 
                           name="email" 
                           placeholder="Email đặt hàng"
                           value="{{ old('email') }}"
                           required>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-search me-2"></i>Tra cứu
                    </button>
                </form>
                @error('order_number')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
                @error('email')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            <strong>Lỗi!</strong> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Help Section -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">
                        <i class="bi bi-question-circle me-2"></i>Không tìm thấy đơn hàng?
                    </h6>
                    <ul class="mb-0 ps-3">
                        <li class="mb-2">Kiểm tra lại mã đơn hàng trong email xác nhận</li>
                        <li class="mb-2">
                            Nếu đã đăng nhập, bạn có thể xem đơn hàng tại 
                            <a href="{{ route('account.orders') }}" class="text-decoration-none fw-bold">tài khoản của tôi</a>
                        </li>
                        <li>
                            Liên hệ với chúng tôi qua 
                            <a href="{{ route('contact.index') }}" class="text-decoration-none fw-bold">trang liên hệ</a>
                        </li>
                    </ul>
                </div>
            </div>

            @if (Auth::check())
                <div class="mt-4 text-center">
                    <p class="text-muted mb-2">Bạn đã đăng nhập?</p>
                    <a href="{{ route('account.orders') }}" class="btn btn-outline-primary">

                        <i class="bi bi-arrow-right me-2"></i>Xem đơn hàng của tôi
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
