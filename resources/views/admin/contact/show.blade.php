@extends('layouts.admin')

@section('title', 'Chi tiết Tin nhắn')

@section('content')
<div class="page-header mb-4">
    <div>
        <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
        <h1>{{ $contactMessage->subject }}</h1>
        <p class="text-muted">Từ: {{ $contactMessage->name }} ({{ $contactMessage->email }})</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-light border-bottom">
                <h5 class="mb-0">
                    <i class="bi bi-envelope-open"></i> Nội dung tin nhắn
                </h5>
            </div>
            <div class="card-body">
                <!-- From Information -->
                <div class="mb-4 pb-3 border-bottom">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="small text-muted mb-1">Từ</p>
                            <p class="mb-0">
                                <strong>{{ $contactMessage->name }}</strong><br>
                                    <a href="mailto:{{ $contactMessage->email }}" class="text-decoration-none">
                                        {{ $contactMessage->email }}
                                    </a>
                                    @if ($contactMessage->phone)
                                        <br>
                                        <a href="tel:{{ $contactMessage->phone }}" class="text-decoration-none">
                                            {{ $contactMessage->phone }}
                                        </a>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="small text-muted mb-1">Ngày gửi</p>
                                <p class="mb-0">{{ $contactMessage->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Message Content -->
                    <div class="mb-4">
                        <p class="text-muted">{{ nl2br(e($contactMessage->message)) }}</p>
                    </div>

                    <!-- Admin Reply -->
                    @if ($contactMessage->admin_reply)
                        <div class="alert alert-success mb-0">
                            <h6 class="fw-bold mb-2">
                                <i class="bi bi-chat-left-text"></i> Phản hồi của Admin
                            </h6>
                            <p class="mb-2">{{ nl2br(e($contactMessage->admin_reply)) }}</p>
                            <small class="text-muted">
                                Phản hồi vào: {{ $contactMessage->replied_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    @else
                        <!-- Reply Form -->
                        <form action="{{ route('admin.contact.reply', $contactMessage) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="admin_reply" class="form-label fw-bold">Phản hồi</label>
                                <textarea class="form-control @error('admin_reply') is-invalid @enderror" 
                                          id="admin_reply" name="admin_reply" rows="6" 
                                          placeholder="Nhập phản hồi của bạn..." required></textarea>
                                @error('admin_reply')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Gửi phản hồi
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0">Trạng thái</h6>
                </div>
                <div class="card-body">
                    @if ($contactMessage->status === 'pending')
                        <span class="badge bg-warning text-dark p-2">
                            <i class="bi bi-exclamation-circle"></i> Chưa đọc
                        </span>
                    @elseif ($contactMessage->status === 'read')
                        <span class="badge bg-info text-white p-2">
                            <i class="bi bi-eye"></i> Đã đọc
                        </span>
                    @elseif ($contactMessage->status === 'replied')
                        <span class="badge bg-success p-2">
                            <i class="bi bi-check-circle"></i> Đã phản hồi
                        </span>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0">Hành động</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.contact.destroy', $contactMessage) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash"></i> Xóa tin nhắn
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
