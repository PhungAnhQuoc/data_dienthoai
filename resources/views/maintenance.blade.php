@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="mb-3">Website đang bảo trì</h2>
                    <p class="lead">{{ $message ?? 'Hệ thống đang trong thời gian bảo trì. Vui lòng thử lại sau.' }}</p>

                    @if (! empty($ends_at))
                        <p class="text-muted">Dự kiến kết thúc: {{ $ends_at->format('d/m/Y H:i') }}</p>
                    @endif

                    <p class="mt-3"><a href="{{ route('home') }}" class="btn btn-secondary">Quay về trang chủ</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
