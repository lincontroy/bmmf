<?php

namespace App\Http\Middleware;

use App\Enums\AuthGuardEnum;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request)
    {

        if (!$request->expectsJson()) {

            if ($request->routeIs('admin.*')) {
                return route('loginCheck');
            }

            return route('customer.login');
        }

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards) // Use the imported Closure here
    {
        $this->authenticate($request, $guards);

        if (empty($guards)) {
            $guards = [null];
        }

        /**
         * Check auth is customer
         */

        if (in_array(AuthGuardEnum::CUSTOMER->value, $guards)) {

            /**
             * Check two factor authentication
             */

            if ($request->session()->has("user_2fa_authentication") && !$request->is('customer/auth-verify')) {

                if ($request->ajax()) {
                    throw new HttpResponseException(response()->json([
                        'success' => false,
                        'message' => localize("Please Verify your account"),
                    ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
                } else {
                    return redirect()->route('customer.auth-verify');
                }

            }

        }

        return $next($request);
    }

}
