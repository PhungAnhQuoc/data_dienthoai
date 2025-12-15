<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitPayment
{
    public function __construct(protected RateLimiter $limiter)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('web')->user();
        $userId = $user?->id ?? 'guest';
        $key = 'payment_' . $userId . '_' . $request->ip();

        // 5 payment attempts per minute
        if ($this->limiter->tooManyAttempts($key, 5)) {
            return response()->json([
                'message' => 'Quá nhiều yêu cầu thanh toán. Vui lòng thử lại sau 1 phút.',
                'retry_after' => $this->limiter->availableIn($key),
            ], 429);
        }

        $this->limiter->hit($key, 60);

        return $next($request);
    }
}
