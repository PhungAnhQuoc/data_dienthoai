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

        // Get monthly revenue for the last 12 months
        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total_amount) as revenue')
            ->where('status', '!=', 'cancelled')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function($item) {
                return [
                    'month' => $item->month,
                    'year' => $item->year,
                    'revenue' => $item->revenue ?? 0
                ];
            });

        // Get category breakdown
        $categoryBreakdown = Product::selectRaw('categories.name, COUNT(products.id) as count')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('categories.name')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProducts', 'lowStockProducts', 'monthlyRevenue', 'categoryBreakdown'));
    }
}
