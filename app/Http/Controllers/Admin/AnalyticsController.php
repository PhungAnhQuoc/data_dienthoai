<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class AnalyticsController
{
    /**
     * Get dashboard statistics
     */
    public function getStats()
    {
        $startDate = now()->subDays(30);

        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')
                ->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_customers' => User::count(),
            'new_customers_30d' => User::where('created_at', '>=', $startDate)->count(),
            'low_stock_products' => Product::where('stock', '<', 10)->count(),
            'total_products' => Product::count(),
        ];

        return $stats;
    }

    /**
     * Get monthly revenue data
     */
    public function monthlyRevenue()
    {
        $data = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonths(12))
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->groupBy('month')
            ->get();

        return $data;
    }

    /**
     * Get top selling products
     */
    public function topProducts($limit = 10)
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.id', 'products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }

    /**
     * Get orders by status
     */
    public function ordersByStatus()
    {
        return Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();
    }

    /**
     * Get product ratings distribution
     */
    public function ratingDistribution()
    {
        return Review::where('is_approved', true)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderBy('rating')
            ->get();
    }

    /**
     * Get customer insights
     */
    public function customerInsights()
    {
        return [
            'total_orders_avg' => User::withCount('orders')
                ->average('orders_count'),
            'total_spending_avg' => User::select('users.id')
                ->join('orders', 'users.id', '=', 'orders.user_id')
                ->selectRaw('AVG(orders.total_amount) as avg_spending')
                ->first()?->avg_spending ?? 0,
            'repeat_customers' => User::withCount('orders')
                ->having('orders_count', '>', 1)
                ->count(),
        ];
    }
}
