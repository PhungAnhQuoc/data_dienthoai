@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <!-- Total Orders -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-gray-500 text-sm font-semibold">TỔNG ĐƠN HÀNG</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_orders'] }}</p>
                </div>
                <div class="text-blue-500 text-4xl">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-gray-500 text-sm font-semibold">DOANH THU</p>
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($stats['total_revenue'], 0, ',', '.') }}đ</p>
                </div>
                <div class="text-green-500 text-4xl">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-gray-500 text-sm font-semibold">ĐƠN CHỜ XỬ LÝ</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['pending_orders'] }}</p>
                </div>
                <div class="text-yellow-500 text-4xl">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

        <!-- Customers -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-gray-500 text-sm font-semibold">KHÁCH HÀNG</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_customers'] }}</p>
                </div>
                <div class="text-purple-500 text-4xl">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Products -->
    @if($stats['low_stock_products'] > 0)
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-8">
        <strong>⚠️ Cảnh báo:</strong> Có {{ $stats['low_stock_products'] }} sản phẩm sắp hết hàng!
    </div>
    @endif
</div>
@endsection
