<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdated;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
            'payment_status' => 'required|in:unpaid,paid,refunded'
        ]);

        $order->update($validated);

        // Send notification email to customer if email exists
        $to = $order->shipping_email ?? ($order->user->email ?? null);
        if ($to) {
            try {
                Mail::to($to)->send(new OrderStatusUpdated($order));
            } catch (\Exception $e) {
                // Log but do not interrupt user flow
                logger()->error('Failed to send order status email: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Order status updated successfully');
    }
}
