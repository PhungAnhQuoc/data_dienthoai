<?php

namespace App\Http\Controllers;

use App\Models\FlashSale;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    /**
     * Lấy danh sách flash sales đang chạy và sắp bắt đầu
     */
    public function index()
    {
        $flashSales = FlashSale::getActiveAndUpcoming();
        
        return view('flash-sales.index', compact('flashSales'));
    }

    /**
     * API endpoint: Lấy dữ liệu flash sales hiện tại (JSON)
     */
    public function getCurrent()
    {
        $flashSales = FlashSale::getCurrentFlashSales()
            ->map(function ($sale) {
                return [
                    'id' => $sale->id,
                    'title' => $sale->title,
                    'description' => $sale->description,
                    'image' => $sale->image ? asset('storage/' . $sale->image) : null,
                    'original_price' => $sale->original_price,
                    'sale_price' => $sale->sale_price,
                    'discount_percentage' => $sale->discount_percentage,
                    'stock' => $sale->stock,
                    'sold' => $sale->sold,
                    'remaining_stock' => $sale->getRemainingStock(),
                    'sold_percentage' => $sale->getSoldPercentage(),
                    'starts_at' => $sale->starts_at->toIso8601String(),
                    'ends_at' => $sale->ends_at->toIso8601String(),
                    'time_remaining' => $sale->getTimeRemaining(),
                    'color_badge' => $sale->color_badge,
                    'has_stock' => $sale->hasStock(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $flashSales,
            'current_time' => now()->toIso8601String(),
        ]);
    }

    /**
     * API endpoint: Lấy dữ liệu flash sale modal (hiển thị trên home page)
     */
    public function getModal()
    {
        $flashSales = FlashSale::getCurrentFlashSales()
            ->take(3)
            ->map(function ($sale) {
                return [
                    'id' => $sale->id,
                    'title' => $sale->title,
                    'description' => $sale->description,
                    'image' => $sale->image ? asset('storage/' . $sale->image) : null,
                    'sale_price' => $sale->sale_price,
                    'original_price' => $sale->original_price,
                    'discount_percentage' => $sale->discount_percentage,
                    'remaining_stock' => $sale->getRemainingStock(),
                    'sold_percentage' => $sale->getSoldPercentage(),
                    'ends_at' => $sale->ends_at->toIso8601String(),
                    'color_badge' => $sale->color_badge,
                ];
            });

        return response()->json([
            'success' => true,
            'has_flash_sales' => count($flashSales) > 0,
            'data' => $flashSales,
        ]);
    }

    /**
     * Hiển thị chi tiết 1 flash sale
     */
    public function show($id)
    {
        $flashSale = FlashSale::findOrFail($id);
        
        return view('flash-sales.show', compact('flashSale'));
    }

    /**
     * API: Cập nhật số lượng đã bán (khi có đơn hàng)
     */
    public function updateSold(Request $request, $id)
    {
        $flashSale = FlashSale::findOrFail($id);
        
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($flashSale->getRemainingStock() < $validated['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng còn lại không đủ',
            ], 400);
        }

        $flashSale->increment('sold', $validated['quantity']);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thành công',
            'remaining_stock' => $flashSale->getRemainingStock(),
        ]);
    }
}
