@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Quản lý Bản tin</h1>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-500 text-sm">Tổng cộng</p>
            <p class="text-3xl font-bold">{{ $stats['total_subscribers'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-500 text-sm">Đang theo dõi</p>
            <p class="text-3xl font-bold text-green-600">{{ $stats['active_subscribers'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-500 text-sm">Đã hủy</p>
            <p class="text-3xl font-bold text-red-600">{{ $stats['inactive_subscribers'] }}</p>
        </div>
    </div>

    <!-- Send Promotion -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Gửi Email Khuyến Mãi</h2>
        <form method="POST" action="{{ route('admin.newsletter.send-promotion') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Tiêu đề</label>
                <input type="text" name="title" class="w-full px-4 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nội dung</label>
                <textarea name="content" rows="6" class="w-full px-4 py-2 border rounded" required></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">URL Nút</label>
                    <input type="url" name="button_url" class="w-full px-4 py-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Text Nút</label>
                    <input type="text" name="button_text" class="w-full px-4 py-2 border rounded" required>
                </div>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Gửi cho {{ $stats['active_subscribers'] }} người
            </button>
        </form>
    </div>

    <!-- Subscribers List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Tên</th>
                    <th class="px-6 py-3 text-left">Ngày đăng ký</th>
                    <th class="px-6 py-3 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $subscriber)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-3">{{ $subscriber->email }}</td>
                    <td class="px-6 py-3">{{ $subscriber->name ?? '-' }}</td>
                    <td class="px-6 py-3">{{ $subscriber->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-3 text-center">
                        <form method="POST" action="{{ route('admin.newsletter.destroy', $subscriber) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Xác nhận xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-3 text-center text-gray-500">Không có người theo dõi nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $subscribers->links() }}
    </div>
</div>
@endsection
