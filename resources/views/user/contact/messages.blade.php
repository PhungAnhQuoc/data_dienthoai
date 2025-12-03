@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 mb-0">
                <i class="bi bi-envelope"></i> Tin nhắn liên hệ của tôi
            </h1>
            <small class="text-muted">Xem tất cả tin nhắn và phản hồi từ admin</small>
        </div>
    </div>

    @if ($messages->count() > 0)
        <div class="row">
            @foreach ($messages as $message)
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="card-title mb-2">{{ $message->subject }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit($message->message, 100) }}</p>
                                    <small class="text-muted">
                                        Gửi ngày: {{ $message->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="mb-2">
                                        @if ($message->status === 'pending')
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-hourglass-split"></i> Chờ xử lý
                                            </span>
                                        @elseif ($message->status === 'read')
                                            <span class="badge bg-info">
                                                <i class="bi bi-eye"></i> Đã nhận
                                            </span>
                                        @elseif ($message->status === 'replied')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Đã phản hồi
                                            </span>
                                        @endif
                                    </div>
                                    <a href="{{ route('user.contact.show', $message) }}" class="btn btn-sm btn-primary">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $messages->links() }}
        </div>
    @else
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
            <p class="mt-3 mb-0">Bạn chưa gửi tin nhắn liên hệ nào. <a href="{{ route('contact.index') }}">Gửi tin nhắn</a></p>
        </div>
    @endif
</div>
@endsection
