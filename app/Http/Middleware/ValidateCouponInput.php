<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateCouponInput
{
    public function handle(Request $request, Closure $next): Response
    {
        // Validate coupon input to prevent brute force
        $request->validate([
            'code' => 'required|string|max:50|regex:/^[A-Z0-9\-]+$/',
        ], [
            'code.regex' => 'Mã giảm giá không hợp lệ',
        ]);

        return $next($request);
    }
}
