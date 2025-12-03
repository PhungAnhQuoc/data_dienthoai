@extends('layouts.app')

@section('title', 'Thanh toán bị huỷ')

@section('content')
<div class="container py-5">
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center">
            <h3 class="mb-3">Thanh toán bị huỷ</h3>
            <p class="text-muted">Giao dịch của bạn đã bị huỷ. Bạn có thể thử lại hoặc chọn phương thức thanh toán khác.</p>
            <a href="{{ route('checkout.index') }}" class="btn btn-primary">Quay lại thanh toán</a>
        </div>
    </div>
</div>
@endsection
