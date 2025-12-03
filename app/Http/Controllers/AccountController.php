<?php
// app/Http/Controllers/AccountController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Order;
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

    // Danh sách yêu thích
    public function wishlist()
    {
        // This will be implemented when you create Wishlist feature
        return view('account.wishlist');
    }
}