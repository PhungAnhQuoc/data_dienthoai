<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    /**
     * Show user dashboard
     */
    public function dashboard()
    {
        /** @var User $user */
        $user = Auth::user();
        $orders = $user->orders()
            ->latest()
            ->paginate(10);

        $reviews = $user->reviews()
            ->latest()
            ->paginate(5);

        $wishlists = $user->wishlists()
            ->with('product')
            ->paginate(12);

        return view('user.dashboard', compact('user', 'orders', 'reviews', 'wishlists'));
    }

    /**
     * Show profile page
     */
    public function profile()
    {
        /** @var User $user */
        $user = Auth::user();
        $addresses = $user->addresses()->get();

        return view('user.profile', compact('user', 'addresses'));
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($validated);

        return back()->with('success', 'Hồ sơ đã được cập nhật');
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Mật khẩu đã được thay đổi');
    }

    /**
     * Show order history
     */
    public function orderHistory()
    {
        /** @var User $user */
        $user = Auth::user();
        $orders = $user->orders()
            ->with('items.product')
            ->latest()
            ->paginate(20);

        return view('user.orders', compact('orders'));
    }

    /**
     * Show order details
     */
    public function orderDetail($orderId)
    {
        /** @var User $user */
        $user = Auth::user();
        $order = $user->orders()
            ->with('items.product')
            ->findOrFail($orderId);

        return view('user.order-detail', compact('order'));
    }

    /**
     * Cancel order request
     */
    public function requestCancel($orderId)
    {
        /** @var User $user */
        $user = Auth::user();
        $order = $user->orders()->findOrFail($orderId);

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Chỉ có thể hủy đơn hàng đang chờ xử lý');
        }

        $order->update(['status' => 'cancelled', 'cancelled_at' => now()]);

        return back()->with('success', 'Đơn hàng đã được hủy');
    }
}
