@extends('layouts.admin')

@section('title', 'Quản Lý Blog')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Blog</h2>
    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm Bài Viết
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tiêu Đề</th>
                    <th>Slug</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Tạo</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($blogs as $blog)
                    <tr>
                        <td>{{ $blog->id }}</td>
                        <td>{{ $blog->title }}</td>
                        <td><span class="badge bg-secondary">{{ $blog->slug }}</span></td>
                        <td>
                            @if ($blog->is_published)
                                <span class="badge bg-success">Xuất Bản</span>
                            @else
                                <span class="badge bg-warning">Nháp</span>
                            @endif
                        </td>
                        <td>{{ $blog->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.blog.edit', $blog) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.blog.destroy', $blog) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn không?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Chưa có bài viết nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $blogs->links('pagination::bootstrap-5') }}
</div>
@endsection
