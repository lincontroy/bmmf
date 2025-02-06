<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class HandleMethodNotAllowed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (MethodNotAllowedHttpException $e) {
            return response()->json([
                'error'   => localize('Method not allowed'),
                'message' => localize('The requested method is not supported for this endpoint'),
            ], 405);
        }
    }
}
