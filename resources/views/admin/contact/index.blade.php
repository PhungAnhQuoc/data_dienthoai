@extends('layouts.admin')

@section('title', 'Liên hệ')

@section('content')
<div class="page-header">
    <div>
        <h1>
            <i class="bi bi-envelope"></i> Tin nhắn liên hệ
        </h1>
        <p class="text-muted">Quản lý các tin nhắn từ khách hàng</p>
    </div>
    <span class="badge bg-danger fs-6">
        {{ $unread }} tin mới
    </span>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Người gửi</th>
                    <th>Email</th>
                    <th>Tiêu đề</th>
                    <th>Trạng thái</th>
                    <th>Ngày gửi</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($messages as $message)
                        <tr>
                            <td>
                                <strong>{{ $message->name }}</strong>
                                @if ($message->phone)
                                    <br><small class="text-muted">{{ $message->phone }}</small>
                                @endif
                            </td>
                            <td>
                                <a href="mailto:{{ $message->email }}" class="text-decoration-none">
                                    {{ $message->email }}
                                </a>
                            </td>
                            <td>
                                <strong>{{ Str::limit($message->subject, 50) }}</strong>
                            </td>
                            <td>
                                @if ($message->status === 'pending')
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-exclamation-circle"></i> Chưa đọc
                                    </span>
                                @elseif ($message->status === 'read')
                                    <span class="badge bg-info text-white">
                                        <i class="bi bi-eye"></i> Đã đọc
                                    </span>
                                @elseif ($message->status === 'replied')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Đã phản hồi
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $message->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                <a href="{{ route('admin.contact.show', $message) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Xem
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="mt-3 mb-0">Chưa có tin nhắn nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $messages->links() }}
    </div>
</div>
@endsection
