@extends('layouts.admin')

@section('title', 'Order Management')

@section('content')
<div class="page-header">
    <h1>Order Management</h1>
    <p class="text-muted">View and manage all customer orders.</p>
</div>

<!-- Filters -->
<div class="tabs-filter">
    <button class="tab-btn active" onclick="filterOrders('all')">All Orders</button>
    <button class="tab-btn" onclick="filterOrders('pending')">Pending</button>
    <button class="tab-btn" onclick="filterOrders('confirmed')">Confirmed</button>
    <button class="tab-btn" onclick="filterOrders('shipped')">Shipped</button>
    <button class="tab-btn" onclick="filterOrders('delivered')">Delivered</button>
    <button class="tab-btn" onclick="filterOrders('cancelled')">Cancelled</button>
</div>

<!-- Orders Table -->
<div class="card">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Items</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>
                    <strong>{{ $order->order_number }}</strong>
                </td>
                <td>
                    <strong>{{ $order->shipping_name }}</strong><br>
                    <small class="text-muted">{{ $order->user->email ?? $order->shipping_email }}</small>
                </td>
                <td>
                    <strong>{{ number_format($order->total_amount, 0, ',', '.') }}đ</strong>
                </td>
                <td>
                    <span class="badge bg-info">{{ $order->items->count() }} items</span>
                </td>
                <td>
                    @switch($order->status)
                        @case('pending')
                            <span class="badge bg-warning">Pending</span>
                            @break
                        @case('confirmed')
                            <span class="badge bg-info">Confirmed</span>
                            @break
                        @case('shipped')
                            <span class="badge bg-primary">Shipped</span>
                            @break
                        @case('delivered')
                            <span class="badge bg-success">Delivered</span>
                            @break
                        @case('cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                            @break
                    @endswitch
                </td>
                <td>
                    @if($order->payment_status === 'paid')
                        <span class="badge bg-success">Paid</span>
                    @elseif($order->payment_status === 'refunded')
                        <span class="badge bg-secondary">Refunded</span>
                    @else
                        <span class="badge bg-warning">Unpaid</span>
                    @endif
                </td>
                <td>
                    <small>{{ $order->created_at->format('M d, Y') }}</small>
                </td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary" title="View">
                        <i class="bi bi-eye"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-4">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">No orders found</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $orders->links() }}
</div>

<style>
.page-header {
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

.tabs-filter {
    margin-bottom: 20px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.tab-btn {
    background: white;
    border: 1px solid #e9ecef;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s;
    white-space: nowrap;
}

.tab-btn:hover {
    border-color: #667eea;
    color: #667eea;
}

.tab-btn.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}

.card {
    border: none;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.table {
    margin-bottom: 0;
}

.table thead th {
    border-bottom: 2px solid #f0f0f0;
    background-color: #f9f9f9;
    font-weight: 600;
    color: #333;
    padding: 12px;
}

.table tbody tr {
    border-bottom: 1px solid #f0f0f0;
}

.table tbody tr:hover {
    background-color: #f9f9f9;
}

.btn-sm {
    padding: 4px 8px;
    font-size: 0.85rem;
}

.badge {
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 0.85rem;
}
</style>
@endsection

@push('scripts')
<script>
function filterOrders(type) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    console.log('Filter by:', type);
    // TODO: Implement actual filtering
}
</script>
@endpush
