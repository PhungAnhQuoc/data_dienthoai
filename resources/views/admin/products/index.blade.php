@extends('layouts.admin')

@section('title', 'Product Management')

@section('content')
<div class="page-header">
    <h1>Product Management</h1>
    <p class="text-muted">Manage all mobile phone products in your store.</p>
    <a href="{{ route('admin.products.create') }}" class="btn btn-add">
        <i class="bi bi-plus-circle"></i> Add New Product
    </a>
</div>

<div class="tabs-filter">
    <button class="tab-btn active" onclick="filterProducts('all')">All</button>
    <button class="tab-btn" onclick="filterProducts('active')">Active</button>
    <button class="tab-btn" onclick="filterProducts('inactive')">Inactive</button>
    <button class="tab-btn" onclick="filterProducts('low-stock')">Low Stock</button>
</div>

<div class="card">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                    @else
                        <div style="width: 50px; height: 50px; background: #e9ecef; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-image" style="color: #999;"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <strong>{{ $product->name }}</strong><br>
                    <small class="text-muted">{{ $product->brand->name ?? 'No Brand' }}</small>
                </td>
                <td>{{ $product->sku }}</td>
                <td>
                    <strong>{{ number_format($product->price, 0, ',', '.') }}đ</strong>
                    @if($product->sale_price)
                        <br><small class="text-danger">{{ number_format($product->sale_price, 0, ',', '.') }}đ</small>
                    @endif
                </td>
                <td>
                    <span class="badge bg-info">{{ $product->stock }} units</span>
                    @if($product->stock < 10)
                        <br><small class="text-danger">⚠️ Low Stock</small>
                    @endif
                </td>
                <td>
                    @if($product->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">No products found</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $products->links() }}
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

.btn-add {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s;
}

.btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    color: white;
}

.tabs-filter {
    margin-bottom: 20px;
    display: flex;
    gap: 10px;
}

.tab-btn {
    background: white;
    border: 1px solid #e9ecef;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s;
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
function filterProducts(type) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    console.log('Filter by:', type);
}
</script>
@endpush