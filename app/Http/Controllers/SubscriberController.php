<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Subscribe to newsletter
     */
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:subscribers,email',
            'name' => 'nullable|string|max:255',
        ]);

        Subscriber::create($validated);

        return response()->json([
            'message' => 'Cảm ơn bạn đã đăng ký nhận tin tức!',
            'success' => true,
        ]);
    }

    /**
     * Unsubscribe from newsletter
     */
    public function unsubscribe($token)
    {
        $subscriber = Subscriber::where('unsubscribe_token', $token)->first();

        if (!$subscriber) {
            return redirect('/')->with('error', 'Không tìm thấy email');
        }

        $subscriber->update([
            'is_active' => false,
            'unsubscribed_at' => now(),
        ]);

        return redirect('/')->with('success', 'Bạn đã hủy đăng ký nhận tin tức');
    }

    /**
     * Get all active subscribers (for admin)
     */
    public function getActiveSubscribers()
    {
        return Subscriber::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(50);
    }
}
