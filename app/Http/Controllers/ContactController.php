<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Show contact form
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * Store contact message
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:5',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'subject.required' => 'Vui lòng nhập tiêu đề',
            'message.required' => 'Vui lòng nhập nội dung tin nhắn',
            'message.min' => 'Nội dung tin nhắn phải có ít nhất 5 ký tự',
        ]);

        // Add user_id if user is authenticated
        if (Auth::check()) {
            $validated['user_id'] = Auth::id();
        }

        $contact = ContactMessage::create($validated);

        // Send notification to admin (in a real app, use queue + Mail)
        // For now, just save to DB and admin can view in admin panel
        
        return redirect()->route('contact.index')
            ->with('success', 'Cảm ơn bạn! Chúng tôi đã nhận được tin nhắn của bạn và sẽ phản hồi trong thời gian sớm nhất.');
    }
}
