<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\GlobalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $settings = Setting::first();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'maintenance_enabled' => 'nullable|boolean',
            'maintenance_message' => 'nullable|string',
            'maintenance_starts_at' => 'nullable|date_format:Y-m-d\TH:i',
            'maintenance_ends_at' => 'nullable|date_format:Y-m-d\TH:i',
            'notify_message' => 'nullable|string',
            'notify_type' => 'nullable|in:info,warning,important',
            'send_notification' => 'nullable',
        ]);

        $settings = Setting::first();
        if (! $settings) {
            $settings = new Setting();
        }

        $settings->maintenance_enabled = (bool) $request->has('maintenance_enabled');
        $settings->maintenance_message = $request->input('maintenance_message');
        $settings->maintenance_starts_at = $request->input('maintenance_starts_at') ?: null;
        $settings->maintenance_ends_at = $request->input('maintenance_ends_at') ?: null;
        $settings->save();

        // Optionally send notification to all users
        if ($request->has('send_notification') && $request->filled('notify_message')) {
            $notify = $request->input('notify_message');
            $users = User::all();
            Notification::send($users, new GlobalNotification($notify));
        }

        return redirect()->back()->with('success', 'Cài đặt đã được cập nhật.');
    }
}