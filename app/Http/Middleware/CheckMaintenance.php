<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckMaintenance
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Allow artisan/console, or requests from internal tools
        if (app()->runningInConsole()) {
            return $next($request);
        }

        // Always allow admin routes and logged in admins to access
        if ($request->is('admin*')) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        $settings = Setting::instance();

        if (! $settings) {
            return $next($request);
        }

        if ($settings->maintenance_enabled) {
            // If there's an end time and it's passed, treat as off
            if ($settings->maintenance_ends_at && $settings->maintenance_ends_at->isPast()) {
                return $next($request);
            }

            // Show maintenance view for non-admins
            return response()->view('maintenance', [
                'message' => $settings->maintenance_message,
                'ends_at' => $settings->maintenance_ends_at,
            ], 503);
        }

        return $next($request);
    }
}
