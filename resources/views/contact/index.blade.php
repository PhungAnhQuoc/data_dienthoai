@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="h2 fw-bold mb-2">Chúng tôi có thể giúp gì cho bạn?</h1>
            <p class="text-muted">Nếu bạn có bất kỳ câu hỏi hay thắc mắc nào, đừng ngần ngại liên hệ với chúng tôi. Chúng tôi luôn sẵn sàng hỗ trợ.</p>
        </div>
    </div>

    <div class="row">
        <!-- Contact Information -->
        <div class="col-lg-5 mb-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">
                        <i class="bi bi-geo-alt text-primary"></i> Địa chỉ
                    </h5>
                    <p class="text-muted mb-0">123 Đường ABC, Quận 1, TP. HCM Mỹ Phẩm</p>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">
                        <i class="bi bi-telephone text-primary"></i> Điện thoại
                    </h5>
                    <p class="text-muted mb-2">
                        Kinh doanh: <a href="tel:0281234567" class="text-decoration-none">028.1234.567</a>
                    </p>
                    <p class="text-muted mb-0">
                        Kỹ thuật: <a href="tel:0281234789" class="text-decoration-none">028.1234.789</a>
                    </p>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">
                        <i class="bi bi-envelope text-primary"></i> Email
                    </h5>
                    <p class="text-muted mb-0">
                        <a href="mailto:support@mobileshop.com.vn" class="text-decoration-none">support@mobileshop.com.vn</a>
                    </p>
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">
                        <i class="bi bi-clock text-primary"></i> Giờ làm việc
                    </h5>
                    <p class="text-muted mb-2">Thứ 2 - Thứ 6: 8:00 - 22:00</p>
                    <p class="text-muted mb-0">Thứ 7 - Chủ nhật: 9:00 - 20:00</p>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <h4 class="card-title fw-bold mb-4">Gửi tin nhắn cho chúng tôi</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Vui lòng sửa lỗi sau:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf

                        <!-- Name Field -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                                   placeholder="Nhập họ và tên của bạn" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                                   placeholder="your@example.com" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Field -->
                        <div class="mb-4">
                            <label for="phone" class="form-label fw-bold">Số điện thoại</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" 
                                   placeholder="0123456789" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Subject Field -->
                        <div class="mb-4">
                            <label for="subject" class="form-label fw-bold">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" 
                                   placeholder="Tiêu đề tin nhắn của bạn" value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Message Field -->
                        <div class="mb-4">
                            <label for="message" class="form-label fw-bold">Nội dung tin nhắn <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="6" 
                                      placeholder="Vui lòng nhập nội dung chi tiết..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-send"></i> Gửi tin nhắn
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="fw-bold mb-4">Tìm chúng tôi trên bản đồ</h4>
            <div style="border-radius: 12px; overflow: hidden; height: 400px; background: #e9ecef;">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4901484630896!2d106.65946231533648!3d10.777888361910732!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f1f7e2f0001%3A0x1234567890!2s123%20%C4%90%C6%B0%E1%BB%9Dng%20ABC%2C%20Qu%E1%BA%ADn%201%2C%20TP.%20HCM!5e0!3m2!1svi!2s!4v1234567890"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</div>
@endsection
