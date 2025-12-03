@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('user.contact.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Message Details -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0 fw-bold">{{ $message->subject }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4 pb-3 border-bottom">
                        <small class="text-muted d-block mb-2">Gửi ngày</small>
                        <p class="mb-0">{{ $message->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Nội dung tin nhắn:</h6>
                        <div class="bg-light p-3 rounded">
                            {{ nl2br(e($message->message)) }}
                        </div>
                    </div>

                    <!-- Admin Reply -->
                    @if ($message->admin_reply)
                        <div class="alert alert-success mb-0">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-reply"></i> Phản hồi từ admin
                            </h6>
                            <p class="mb-2">{{ nl2br(e($message->admin_reply)) }}</p>
                            <small class="text-muted">
                                Phản hồi lúc: {{ $message->replied_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-hourglass-split"></i> 
                            Admin chưa có phản hồi. Vui lòng chờ...
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">Thông tin tin nhắn</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Trạng thái</label>
                        <p>
                            @if ($message->status === 'pending')
                                <span class="badge bg-warning text-dark fs-6">
                                    <i class="bi bi-hourglass-split"></i> Chờ xử lý
                                </span>
                            @elseif ($message->status === 'read')
                                <span class="badge bg-info fs-6">
                                    <i class="bi bi-eye"></i> Đã nhận
                                </span>
                            @elseif ($message->status === 'replied')
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-check-circle"></i> Đã phản hồi
                                </span>
                            @endif
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small">Email</label>
                        <p>{{ $message->email }}</p>
                    </div>

                    @if ($message->phone)
                        <div class="mb-3">
                            <label class="form-label text-muted small">Điện thoại</label>
                            <p>
                                <a href="tel:{{ $message->phone }}" class="text-decoration-none">
                                    {{ $message->phone }}
                                </a>
                            </p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label text-muted small">Tiêu đề</label>
                        <p>{{ $message->subject }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
