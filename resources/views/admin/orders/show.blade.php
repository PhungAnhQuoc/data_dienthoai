@extends('layouts.admin')

@section('title', 'Order Details - ' . $order->order_number)

@section('content')
<div class="page-header">
    <div>
        <h1>Order {{ $order->order_number }}</h1>
        <p class="text-muted">Order placed on {{ $order->created_at->format('M d, Y H:i') }}</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Orders
    </a>
</div>

<div class="row">
    <!-- Order Details -->
    <div class="col-lg-8">
        <!-- Order Items -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Order Items</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            @php
                                $price = $item->unit_price > 0 ? $item->unit_price : ($item->product->sale_price > 0 ? $item->product->sale_price : $item->product->price);
                                $totalPrice = $item->total_price > 0 ? $item->total_price : ($price * $item->quantity);
                            @endphp
                            <tr>
                                <td>
                                    <strong>{{ $item->product->name }}</strong>
                                </td>
                                <td>{{ $item->product->sku }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($price, 0, ',', '.') }}đ</td>
                                <td><strong>{{ number_format($totalPrice, 0, ',', '.') }}đ</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6 ms-auto">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Subtotal:</strong></td>
                                <td class="text-end">{{ number_format($order->total_amount - $order->shipping_cost - $order->tax_amount, 0, ',', '.') }}đ</td>
                            </tr>
                            <tr>
                                <td><strong>Tax:</strong></td>
                                <td class="text-end">{{ number_format($order->tax_amount, 0, ',', '.') }}đ</td>
                            </tr>
                            <tr>
                                <td><strong>Shipping:</strong></td>
                                <td class="text-end">{{ number_format($order->shipping_cost, 0, ',', '.') }}đ</td>
                            </tr>
                            <tr style="border-top: 2px solid #e9ecef;">
                                <td><strong>Total Amount:</strong></td>
                                <td class="text-end"><strong class="text-primary" style="font-size: 1.2rem;">{{ number_format($order->total_amount, 0, ',', '.') }}đ</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Notes -->
        @if($order->notes)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Notes</h5>
            </div>
            <div class="card-body">
                <p>{{ $order->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Customer Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Customer Information</h5>
            </div>
            <div class="card-body">
                <p>
                    <strong>Name:</strong><br>
                    {{ $order->shipping_name }}
                </p>
                <p>
                    <strong>Email:</strong><br>
                    {{ $order->shipping_email ?? $order->user->email }}
                </p>
                <p>
                    <strong>Phone:</strong><br>
                    {{ $order->shipping_phone }}
                </p>
                <p>
                    <strong>Address:</strong><br>
                    {{ $order->shipping_address }}
                </p>
                @if($order->user)
                <p>
                    <small class="text-muted">Registered as: <a href="#">{{ $order->user->name }}</a></small>
                </p>
                @endif
            </div>
        </div>

        <!-- Order Status -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Order Status</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Order Status</label>
                        <select class="form-select" name="status" required>
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Payment Status</label>
                        <select class="form-select" name="payment_status" required>
                            <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle me-2"></i>Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Shipment Info -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Shipment Information</h5>
            </div>
            <div class="card-body">
                <p>
                    <strong>Payment Method:</strong><br>
                    <span class="badge bg-info">
                        @switch($order->payment_method)
                            @case('cod')
                                Cash On Delivery
                                @break
                            @case('credit_card')
                                Credit Card
                                @break
                            @case('transfer')
                                Bank Transfer
                                @break
                            @default
                                Not Specified
                        @endswitch
                    </span>
                </p>

                @if($order->shipped_at)
                <p class="mt-3">
                    <strong>Shipped:</strong><br>
                    {{ $order->shipped_at->format('M d, Y H:i') }}
                </p>
                @endif

                @if($order->delivered_at)
                <p>
                    <strong>Delivered:</strong><br>
                    {{ $order->delivered_at->format('M d, Y H:i') }}
                </p>
                @endif

                <p class="mt-3">
                    <strong>Created:</strong><br>
                    {{ $order->created_at->format('M d, Y H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e9ecef;
}

.page-header h1 {
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
}

.card {
    border: none;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.card-header {
    border-bottom: 1px solid #e9ecef;
}

.form-label {
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
}

.form-select {
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 10px 12px;
}

.form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    transition: all 0.3s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: #e9ecef;
    color: #333;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
}

.badge {
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 0.85rem;
}

.table td {
    vertical-align: middle;
}

.table-borderless tr {
    border-bottom: none;
}

.table-borderless td {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}
</style>
@endsection
