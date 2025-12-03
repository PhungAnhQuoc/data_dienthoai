<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index()
    {
        return view('orders.tracking');
    }

    public function search(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'email' => 'required|email',
        ]);

        $order = Order::where('order_number', $request->order_number)
            ->where('shipping_email', $request->email)
            ->with('items.product')
            ->first();

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng. Vui lòng kiểm tra mã đơn và email.');
        }

        return view('orders.tracking-detail', compact('order'));
    }
}
