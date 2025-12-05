@extends('layouts.admin')

@section('title', 'Order Details - ' . $order->order_number)

@section('content')
<div class="order-details-container">
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Order Details</h1>
            <p class="page-subtitle">Manage and view the details of a customer's order.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Order Items -->
            <div class="card order-items-card">
                <div class="card-header-custom">
                    <h5 class="mb-0">Order Items</h5>
                </div>
                <div class="card-body">
                    <div class="items-list">
                        @foreach($order->items as $item)
                        @php
                            $price = $item->unit_price > 0 ? $item->unit_price : ($item->product->sale_price > 0 ? $item->product->sale_price : $item->product->price);
                            $totalPrice = $item->total_price > 0 ? $item->total_price : ($price * $item->quantity);
                        @endphp
                        <div class="order-item">
                            <!-- Product Image -->
                            <div class="item-image">
                                @if($item->product->main_image)
                                    <img src="{{ asset('storage/' . $item->product->main_image) }}" alt="{{ $item->product->name }}">
                                @else
                                    <div class="placeholder-image">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Details -->
                            <div class="item-details">
                                <h6 class="item-name">{{ $item->product->name }}</h6>
                                <p class="item-sku">SKU: {{ $item->product->sku }}</p>
                            </div>

                            <!-- Price Info -->
                            <div class="item-price">
                                <p class="price-total">{{ number_format($totalPrice, 0, ',', '.') }}đ</p>
                                <p class="price-breakdown">{{ $item->quantity }} × {{ number_format($price, 0, ',', '.') }}đ</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Price Summary -->
                    <div class="price-summary">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span class="summary-value">{{ number_format($order->total_amount - $order->shipping_cost - $order->tax_amount, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax:</span>
                            <span class="summary-value">{{ number_format($order->tax_amount, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping:</span>
                            <span class="summary-value">{{ number_format($order->shipping_cost, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total Amount:</span>
                            <span class="summary-value">{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Customer Information -->
            <div class="card sidebar-card">
                <div class="card-header-custom">
                    <h5 class="mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="customer-info">
                        <div class="info-group">
                            <label>Name:</label>
                            <p class="info-text">{{ $order->shipping_name ?? $order->user->name }}</p>
                        </div>
                        <div class="info-group">
                            <label>Email:</label>
                            <p class="info-text">{{ $order->shipping_email ?? $order->user->email }}</p>
                        </div>
                        <div class="info-group">
                            <label>Phone:</label>
                            <p class="info-text">{{ $order->shipping_phone }}</p>
                        </div>
                        <div class="info-group">
                            <label>Address:</label>
                            <p class="info-text">{{ $order->shipping_address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Status -->
            <div class="card sidebar-card">
                <div class="card-header-custom">
                    <h5 class="mb-0">Order Status</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="status-form">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="order-status" class="form-label">Order Status</label>
                            <select class="form-select" id="order-status" name="status" required>
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="payment-status" class="form-label">Payment Status</label>
                            <select class="form-select" id="payment-status" name="payment_status" required>
                                <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-update-status w-100">
                            <i class="bi bi-check-circle"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Shipment Information -->
            <div class="card sidebar-card">
                <div class="card-header-custom">
                    <h5 class="mb-0">Shipment Information</h5>
                </div>
                <div class="card-body">
                    <div class="shipment-info">
                        <div class="info-group">
                            <label>Payment Method:</label>
                            <div class="method-badge">
                                @switch($order->payment_method)
                                    @case('cod')
                                        <span class="badge-cod">Cash on Delivery</span>
                                        @break
                                    @case('credit_card')
                                        <span class="badge-card">Credit Card</span>
                                        @break
                                    @case('transfer')
                                        <span class="badge-transfer">Bank Transfer</span>
                                        @break
                                    @default
                                        <span class="badge-default">Not Specified</span>
                                @endswitch
                            </div>
                        </div>

                        @if($order->shipped_at)
                        <div class="info-group">
                            <label>Shipped:</label>
                            <p class="info-text">{{ $order->shipped_at->format('M d, Y H:i') }}</p>
                        </div>
                        @endif

                        @if($order->delivered_at)
                        <div class="info-group">
                            <label>Delivered:</label>
                            <p class="info-text">{{ $order->delivered_at->format('M d, Y H:i') }}</p>
                        </div>
                        @endif

                        <div class="info-group">
                            <label>Created:</label>
                            <p class="info-text">{{ $order->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
* {
    --primary-color: #0066ff;
    --secondary-color: #f0f2f5;
    --border-color: #e0e0e0;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --success-color: #10b981;
}

.order-details-container {
    padding: 20px 0;
}

/* Page Header */
.page-header-top {
    margin-bottom: 30px;
}

.page-title {
    font-size: 28px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 5px;
}

.page-subtitle {
    font-size: 14px;
    color: var(--text-secondary);
    margin: 0;
}

/* Cards */
.card {
    border: none;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    margin-bottom: 20px;
    overflow: hidden;
}

.card-header-custom {
    background-color: #ffffff;
    border-bottom: 1px solid var(--border-color);
    padding: 16px 20px;
}

.card-header-custom h5 {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
}

.card-body {
    padding: 20px;
}

/* Order Items */
.order-items-card {
    background: #ffffff;
}

.items-list {
    margin-bottom: 20px;
}

.order-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid var(--secondary-color);
}

.order-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.item-image {
    flex-shrink: 0;
}

.item-image img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 6px;
}

.placeholder-image {
    width: 80px;
    height: 80px;
    background: var(--secondary-color);
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
}

.placeholder-image i {
    font-size: 24px;
}

.item-details {
    flex: 1;
}

.item-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 5px;
}

.item-sku {
    font-size: 12px;
    color: var(--text-secondary);
    margin: 0;
}

.item-price {
    text-align: right;
    flex-shrink: 0;
    min-width: 120px;
}

.price-total {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 3px;
}

.price-breakdown {
    font-size: 12px;
    color: var(--text-secondary);
    margin: 0;
}

/* Price Summary */
.price-summary {
    border-top: 2px solid var(--secondary-color);
    padding-top: 15px;
    margin-top: 20px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    font-size: 14px;
}

.summary-row span:first-child {
    color: var(--text-secondary);
}

.summary-value {
    color: var(--text-primary);
    font-weight: 500;
}

.summary-row.total {
    border-top: 1px solid var(--secondary-color);
    padding-top: 12px;
    margin-top: 12px;
    font-weight: 600;
    font-size: 16px;
}

.summary-row.total .summary-value {
    color: var(--primary-color);
    font-size: 18px;
}

/* Sidebar Cards */
.sidebar-card {
    background: #ffffff;
}

/* Customer Info */
.customer-info,
.shipment-info {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.info-group {
    padding-bottom: 15px;
    border-bottom: 1px solid var(--secondary-color);
}

.info-group:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.info-group label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
    margin-bottom: 5px;
    letter-spacing: 0.3px;
}

.info-text {
    font-size: 14px;
    color: var(--text-primary);
    margin: 0;
    word-break: break-word;
}

/* Form */
.status-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.form-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-primary);
}

.form-select {
    padding: 10px 12px;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 14px;
    color: var(--text-primary);
    background-color: #ffffff;
    cursor: pointer;
    transition: all 0.2s;
}

.form-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
}

.form-select:hover {
    border-color: #b0b0b0;
}

/* Button */
.btn-update-status {
    padding: 12px 16px;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 10px;
}

.btn-update-status:hover {
    background: #0052cc;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
}

.btn-update-status:active {
    transform: translateY(0);
}

.btn-update-status i {
    font-size: 16px;
}

/* Badges */
.method-badge {
    margin-top: 5px;
}

.method-badge span {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
}

.badge-cod {
    background: #dbeafe;
    color: #0369a1;
}

.badge-card {
    background: #fef3c7;
    color: #92400e;
}

.badge-transfer {
    background: #dbeafe;
    color: #0369a1;
}

.badge-default {
    background: #e5e7eb;
    color: #6b7280;
}

/* Responsive */
@media (max-width: 991px) {
    .page-title {
        font-size: 24px;
    }

    .item-image img {
        width: 70px;
        height: 70px;
    }

    .placeholder-image {
        width: 70px;
        height: 70px;
    }
}

@media (max-width: 768px) {
    .order-item {
        flex-wrap: wrap;
        gap: 10px;
    }

    .item-price {
        flex-basis: 100%;
        text-align: left;
        border-top: 1px solid var(--secondary-color);
        padding-top: 10px;
        margin-top: 10px;
    }
}
</style>
@endsection
