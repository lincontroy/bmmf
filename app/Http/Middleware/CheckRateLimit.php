<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class CheckRateLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'cronjob-start';

        if (RateLimiter::tooManyAttempts($key, 3)) {
            return response()->json(['error' => 'Too many requests. Please wait a minute.'], 429);
        }

        RateLimiter::hit($key, 60);

        return $next($request);
    }

}
