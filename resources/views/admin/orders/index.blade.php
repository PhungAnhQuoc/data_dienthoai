@extends('layouts.admin')

@section('title', 'Order Management')

@section('content')
<style>
:root {
    --primary: #0066ff;
    --secondary: #667eea;
    --danger: #dc3545;
    --warning: #ffc107;
    --success: #28a745;
    --info: #17a2b8;
    --light: #f8f9fa;
    --dark: #1f2937;
    --text-muted: #6b7280;
    --border: #e5e7eb;
}

.orders-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 30px;
}

.orders-header h1 {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 5px;
}

.orders-header p {
    color: var(--text-muted);
    margin: 0;
}

/* Filter Tabs */
.orders-filters {
    background: white;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 30px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.filters-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.filter-tabs {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.filter-tab {
    padding: 8px 16px;
    border: 2px solid var(--border);
    background: white;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    color: var(--text-muted);
    transition: all 0.3s ease;
    white-space: nowrap;
    font-size: 0.9rem;
}

.filter-tab:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: rgba(0, 102, 255, 0.05);
}

.filter-tab.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

/* Orders Table */
.orders-table-wrapper {
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
}

.orders-table thead {
    background: var(--light);
    border-bottom: 2px solid var(--border);
}

.orders-table th {
    padding: 16px;
    text-align: left;
    font-weight: 600;
    color: var(--dark);
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.orders-table tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background-color 0.2s;
}

.orders-table tbody tr:hover {
    background-color: var(--light);
}

.orders-table tbody tr:last-child {
    border-bottom: none;
}

.orders-table td {
    padding: 16px;
    vertical-align: middle;
}

.order-number {
    font-weight: 600;
    color: var(--primary);
    font-size: 0.95rem;
}

.customer-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.customer-name {
    font-weight: 600;
    color: var(--dark);
    font-size: 0.95rem;
}

.customer-email {
    color: var(--text-muted);
    font-size: 0.85rem;
}

.order-amount {
    font-weight: 700;
    color: var(--primary);
    font-size: 1rem;
}

.badge-custom {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.badge-cyan {
    background: #cff0f9;
    color: #0891b2;
}

.badge-danger {
    background: #fee2e2;
    color: #991b1b;
}

.badge-warning {
    background: #fef3c7;
    color: #92400e;
}

.badge-success {
    background: #dcfce7;
    color: #166534;
}

.badge-info {
    background: #dbeafe;
    color: #0c4a6e;
}

.order-date {
    color: var(--text-muted);
    font-size: 0.9rem;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    font-size: 0.9rem;
}

.action-btn:hover {
    background: #0052cc;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.4;
}

.empty-state h3 {
    color: var(--dark);
    margin-bottom: 10px;
}

.empty-state p {
    color: var(--text-muted);
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid var(--border);
}

.pagination {
    display: flex;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination li {
    display: flex;
}

.pagination a,
.pagination span {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 28px;
    height: 28px;
    padding: 0 6px;
    border-radius: 4px;
    border: 1px solid var(--border);
    color: var(--dark);
    text-decoration: none;
    transition: all 0.2s;
    font-weight: 500;
    font-size: 0.75rem;
}

.pagination a:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: translateY(-2px);
}

.pagination .active span {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

.pagination .disabled span {
    color: var(--border);
    cursor: not-allowed;
}

/* Responsive */
@media (max-width: 1200px) {
    .orders-table th,
    .orders-table td {
        padding: 12px;
        font-size: 0.9rem;
    }
}

@media (max-width: 768px) {
    .orders-header {
        flex-direction: column;
    }

    .orders-table {
        font-size: 0.85rem;
    }

    .orders-table th,
    .orders-table td {
        padding: 10px;
    }

    .filter-tabs {
        gap: 8px;
    }

    .filter-tab {
        padding: 6px 12px;
        font-size: 0.85rem;
    }

    .customer-info {
        gap: 2px;
    }

    .customer-name,
    .order-number {
        font-size: 0.9rem;
    }

    .action-btn {
        width: 28px;
        height: 28px;
    }
}
</style>

<!-- Page Header -->
<div class="orders-header">
    <div>
        <h1>Orders</h1>
        <p>Manage and view the details of all customer orders.</p>
    </div>
</div>

<!-- Filters -->
<div class="orders-filters">
    <div class="filters-label">Filter by Status</div>
    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterOrders(this, 'all')">All Orders</button>
        <button class="filter-tab" onclick="filterOrders(this, 'pending')">Pending</button>
        <button class="filter-tab" onclick="filterOrders(this, 'confirmed')">Confirmed</button>
        <button class="filter-tab" onclick="filterOrders(this, 'shipped')">Shipped</button>
        <button class="filter-tab" onclick="filterOrders(this, 'delivered')">Delivered</button>
        <button class="filter-tab" onclick="filterOrders(this, 'cancelled')">Cancelled</button>
    </div>
</div>

<!-- Orders Table -->
<div class="orders-table-wrapper">
    <table class="orders-table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Items</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Date</th>
                <th width="60">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>
                    <span class="order-number">{{ $order->order_number }}</span>
                </td>
                <td>
                    <div class="customer-info">
                        <span class="customer-name">{{ $order->shipping_name }}</span>
                        <span class="customer-email">{{ $order->user->email ?? $order->shipping_email }}</span>
                    </div>
                </td>
                <td>
                    <span class="order-amount">{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
                </td>
                <td>
                    <span class="badge-custom badge-cyan">{{ $order->items->count() }} Items</span>
                </td>
                <td>
                    @switch($order->status)
                        @case('pending')
                            <span class="badge-custom badge-warning">Pending</span>
                            @break
                        @case('confirmed')
                            <span class="badge-custom badge-info">Confirmed</span>
                            @break
                        @case('shipped')
                            <span class="badge-custom badge-info">Shipped</span>
                            @break
                        @case('delivered')
                            <span class="badge-custom badge-success">Delivered</span>
                            @break
                        @case('cancelled')
                            <span class="badge-custom badge-danger">Cancelled</span>
                            @break
                    @endswitch
                </td>
                <td>
                    @if($order->payment_status === 'paid')
                        <span class="badge-custom badge-success">Paid</span>
                    @elseif($order->payment_status === 'refunded')
                        <span class="badge-custom" style="background: #f3f4f6; color: #6b7280;">Refunded</span>
                    @else
                        <span class="badge-custom badge-warning">Unpaid</span>
                    @endif
                </td>
                <td>
                    <span class="order-date">{{ $order->created_at->format('M d, Y') }}</span>
                </td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="action-btn" title="View Details">
                        <i class="bi bi-eye" style="font-size: 0.85rem;"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">
                    <div class="empty-state">
                        <div class="empty-state-icon">📦</div>
                        <h3>No Orders Found</h3>
                        <p>There are no orders to display at the moment.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($orders instanceof \Illuminate\Pagination\LengthAwarePaginator && $orders->hasPages())
<div class="pagination-wrapper">
    {{ $orders->links() }}
</div>
@endif

<script>
function filterOrders(element, type) {
    // Remove active class from all tabs
    document.querySelectorAll('.filter-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Add active class to clicked tab
    element.classList.add('active');
    
    // TODO: Implement actual filtering logic
    console.log('Filtering by:', type);
}
</script>

@endsection
