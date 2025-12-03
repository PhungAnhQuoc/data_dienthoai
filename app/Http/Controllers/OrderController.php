<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Cancel a pending order
     */
    public function cancel($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);

            // Authorization check - user can only cancel their own orders
            if ($order->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền hủy đơn hàng này'
                ], 403);
            }

            // Can only cancel pending orders
            if ($order->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Chỉ có thể hủy các đơn hàng đang chờ xử lý'
                ], 400);
            }

            // Update order status
            $order->update([
                'status' => 'cancelled',
                'cancelled_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đơn hàng đã được hủy thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
