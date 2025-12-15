<?php
// app/Http/Controllers/AccountController.php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\ContactMessage;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Hiển thị trang profile
    public function profile()
    {
        $user = Auth::user();
        $messages = ContactMessage::where('email', $user->email)
            ->orWhere('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('account.profile', compact('user', 'messages'));
    }

    // Cập nhật profile
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:15'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update($validated);
        
        // Refresh the user in the session
        Auth::setUser($user->fresh());

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    // avatar feature removed

    // Đổi mật khẩu
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Check current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác']);
        }

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

    // Đơn hàng của tôi
    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('account.orders', compact('orders'));
    }

    // Get order details (API)
    public function getOrderDetails($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            
            // Verify ownership
            if ($order->user_id !== Auth::id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $order->load('items.product');

            return response()->json([
                'id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'created_at' => $order->created_at->format('d/m/Y H:i'),
                'shipping_name' => $order->shipping_name,
                'shipping_phone' => $order->shipping_phone,
                'shipping_address' => $order->shipping_address,
                'shipping_email' => $order->shipping_email,
                'items' => $order->items->map(function($item) {
                    $price = $item->unit_price > 0 ? $item->unit_price : ($item->product->sale_price > 0 ? $item->product->sale_price : $item->product->price);
                    return [
                        'name' => $item->product->name ?? $item->product_name,
                        'price' => $price,
                        'quantity' => $item->quantity,
                        'total' => $item->total_price > 0 ? $item->total_price : ($price * $item->quantity),
                    ];
                }),
                'subtotal' => $order->total_amount - ($order->shipping_cost ?? 0) - ($order->tax_amount ?? 0),
                'shipping_cost' => $order->shipping_cost ?? 0,
                'tax' => $order->tax_amount ?? 0,
                'total' => $order->total_amount,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Danh sách yêu thích
    public function wishlist()
    {
        // This will be implemented when you create Wishlist feature
        return view('account.wishlist');
    }
}