@extends('layouts.app')

@section('title', 'Giỏ hàng - MobileShop')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Giỏ hàng của bạn</h2>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(count($cartItems) > 0)
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Đơn giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-center">Thành tiền</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $item['product']->main_image) }}" 
                                                 alt="{{ $item['product']->name }}"
                                                 class="rounded me-3"
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-1">
                                                    <a href="{{ route('products.show', $item['product']->slug) }}" 
                                                       class="text-decoration-none text-dark">
                                                        {{ $item['product']->name }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted">{{ $item['product']->brand->name }}</small>
                                                @if($item['product']->stock < 10)
                                                <div class="badge bg-warning text-dark mt-1">
                                                    Chỉ còn {{ $item['product']->stock }} sản phẩm
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-primary">
                                            {{ number_format($item['price'], 0, ',', '.') }}đ
                                        </strong>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="input-group" style="max-width: 130px;">
                                                <button class="btn btn-outline-secondary btn-sm" 
                                                        type="button"
                                                            onclick="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})"
                                                            @if($item['quantity'] <= 1) disabled @endif>
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" 
                                                       class="form-control form-control-sm text-center quantity-input"
                                                       id="quantity-{{ $item['id'] }}"
                                                       value="{{ $item['quantity'] }}" 
                                                       min="1"
                                                       max="{{ $item['product']->stock }}"
                                                       onchange="updateQuantity({{ $item['id'] }}, this.value)">
                                                <button class="btn btn-outline-secondary btn-sm" 
                                                        type="button"
                                                            onclick="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})"
                                                            @if($item['quantity'] >= $item['product']->stock) disabled @endif>
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-danger" id="subtotal-{{ $item['id'] }}">
                                            {{ number_format($item['subtotal'], 0, ',', '.') }}đ
                                        </strong>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('cart.remove', $item['id']) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-0">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between pt-3 border-top">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-outline-danger"
                                    onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">
                                <i class="bi bi-trash"></i> Xóa giỏ hàng
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Order Summary -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Tóm tắt đơn hàng</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <strong id="cart-total">{{ number_format($total, 0, ',', '.') }}đ</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển:</span>
                        <strong class="text-success">Miễn phí</strong>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <h6 class="mb-0">Tổng cộng:</h6>
                        <h5 class="text-danger mb-0" id="final-total">
                            {{ number_format($total, 0, ',', '.') }}đ
                        </h5>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-credit-card"></i> Thanh toán
                    </a>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="bi bi-shield-check"></i>
                            Thanh toán an toàn & bảo mật
                        </small>
                    </div>
                </div>
            </div>

            <!-- Coupon Code -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Mã giảm giá</h6>
                    <div class="input-group">
                        <input type="text" 
                               class="form-control" 
                               placeholder="Nhập mã giảm giá">
                        <button class="btn btn-outline-primary" type="button">
                            Áp dụng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-cart-x display-1 text-muted"></i>
        <h4 class="mt-4">Giỏ hàng của bạn đang trống</h4>
        <p class="text-muted mb-4">Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">
            <i class="bi bi-shop"></i> Khám phá sản phẩm
        </a>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function updateQuantity(productId, quantity) {
    quantity = parseInt(quantity);
    
    if (quantity < 1) {
        alert('Số lượng phải lớn hơn 0');
        return;
    }

    fetch(`/gio-hang/cap-nhat/${productId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`quantity-${productId}`).value = quantity;
            document.getElementById(`subtotal-${productId}`).textContent = data.subtotal;
            document.getElementById('cart-total').textContent = data.total;
            document.getElementById('final-total').textContent = data.total;
        } else {
            alert(data.message);
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra, vui lòng thử lại!');
    });
}
</script>
@endpush