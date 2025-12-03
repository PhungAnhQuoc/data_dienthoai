@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Bài Viết')

@section('content')
<div class="mb-4">
    <h2>Chỉnh Sửa Bài Viết</h2>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu Đề</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ $blog->title }}" required>
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ $blog->slug }}" required>
                        @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Tóm Tắt</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3">{{ $blog->excerpt }}</textarea>
                        @error('excerpt')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Nội Dung</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="8" required>{{ $blog->content }}</textarea>
                        @error('content')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Hình Ảnh</label>
                        @if ($blog->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" style="max-width: 200px;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        @error('image')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1" {{ $blog->is_published ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_published">Xuất Bản</label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Cập Nhật
                        </button>
                        <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
