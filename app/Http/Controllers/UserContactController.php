<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class UserContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show user's contact messages and replies
     */
    public function index()
    {
        $messages = ContactMessage::where('email', auth()->user()->email)
            ->latest()
            ->paginate(10);

        return view('user.contact.messages', compact('messages'));
    }

    /**
     * Show detail of a contact message with reply
     */
    public function show(ContactMessage $contactMessage)
    {
        // Use the route-bound model and ensure it belongs to the authenticated user
        if ($contactMessage->email !== auth()->user()->email) {
            abort(403);
        }

        // Keep variable name expected by the view
        $message = $contactMessage;

        return view('user.contact.show', compact('message'));
    }
}
