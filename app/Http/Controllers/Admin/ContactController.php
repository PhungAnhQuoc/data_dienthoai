<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Display a listing of contact messages
     */
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);
        $unread = ContactMessage::where('status', 'pending')->count();
        
        return view('admin.contact.index', compact('messages', 'unread'));
    }

    /**
     * Show detail of a contact message
     */
    public function show(ContactMessage $contactMessage)
    {
        // Mark as read
        if ($contactMessage->status === 'pending') {
            $contactMessage->update(['status' => 'read']);
        }

        return view('admin.contact.show', compact('contactMessage'));
    }

    /**
     * Store admin reply
     */
    public function reply(Request $request, ContactMessage $contactMessage)
    {
        $validated = $request->validate([
            'admin_reply' => 'required|string|min:10',
        ]);

        $contactMessage->update([
            'admin_reply' => $validated['admin_reply'],
            'status' => 'replied',
            'replied_at' => now(),
        ]);

        // In a real app, send email to user here
        // Mail::to($contactMessage->email)->send(new ContactReplyMail($contactMessage));

        return redirect()->route('admin.contact.show', $contactMessage)
            ->with('success', 'Phản hồi đã được gửi thành công!');
    }

    /**
     * Delete a contact message
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact.index')
            ->with('success', 'Tin nhắn đã được xóa!');
    }
}
