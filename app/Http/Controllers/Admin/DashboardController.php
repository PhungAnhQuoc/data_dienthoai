<?php
// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'total_categories' => Category::count(),
            'total_brands' => Brand::count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
            'total_orders' => Order::where('status', '!=', 'cancelled')->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'sold_count' => Order::where('status', 'completed')->count(),
        ];

        $recentProducts = Product::with(['category', 'brand'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('stock', '>', 0)
            ->where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // Get recent orders
        $recentOrders = Order::with(['user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get monthly revenue for the last 12 months
        $monthlyRevenue = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $revenue = Order::where('status', '!=', 'cancelled')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->sum('total_amount');
            
            $monthlyRevenue[] = [
                'month' => $month,
                'year' => $year,
                'month_name' => $date->format('M/Y'),
                'revenue' => $revenue ?? 0
            ];
        }

        // Get category breakdown
        $categoryBreakdown = Product::selectRaw('categories.name, COUNT(products.id) as count')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('categories.name')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProducts', 'lowStockProducts', 'monthlyRevenue', 'categoryBreakdown', 'recentOrders'));
    }
}
