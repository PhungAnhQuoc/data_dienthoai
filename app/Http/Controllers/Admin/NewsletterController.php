<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscriber;
use App\Services\NewsletterService;
use Illuminate\Http\Request;

class NewsletterController
{
    /**
     * Show newsletter management page
     */
    public function index()
    {
        $subscribers = Subscriber::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        $stats = [
            'total_subscribers' => Subscriber::count(),
            'active_subscribers' => Subscriber::where('is_active', true)->count(),
            'inactive_subscribers' => Subscriber::where('is_active', false)->count(),
        ];

        return view('admin.newsletter.index', compact('subscribers', 'stats'));
    }

    /**
     * Send promotion email
     */
    public function sendPromotion(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'button_url' => 'required|url',
            'button_text' => 'required|string|max:100',
        ]);

        $result = NewsletterService::sendPromotion(
            $validated['title'],
            $validated['content'],
            $validated['button_url'],
            $validated['button_text']
        );

        return back()->with('success', "Đã gửi email đến {$result['sent_to']} người theo dõi");
    }

    /**
     * Export subscribers list
     */
    public function export()
    {
        $subscribers = Subscriber::where('is_active', true)->get();

        $csv = "Email,Name,Subscribed At\n";
        foreach ($subscribers as $subscriber) {
            $csv .= "\"{$subscriber->email}\",\"{$subscriber->name}\",\"{$subscriber->subscribed_at}\"\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="subscribers.csv"',
        ]);
    }

    /**
     * Delete subscriber
     */
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return back()->with('success', 'Đã xóa người theo dõi');
    }
}
