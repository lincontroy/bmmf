<?php

namespace App\Traits;

use App\Enums\PermissionActionEnum;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Enums\AuthGuardEnum;

trait ChecksPermissionTrait
{
    public function callAction($method, $parameters)
    {

        if (isset($this->mapActionPermission)) {
            $actionPermissionMap = $this->mapActionPermission;
        } else {

            if (isset($this->permissionPrefix)) {
                $resourceName = $this->permissionPrefix;
            } else {
                $fullClass    = explode('\\', Route::currentRouteAction());
                $segments     = explode('@', $fullClass[count($fullClass) - 1]);
                $resourceName = Str::of(str_replace('Controller', '', $segments[0]))
                    ->lower()
                    ->singular();
            }

            $actionPermissionMap = [
                'index'   => $resourceName . '.' . PermissionActionEnum::READ->value,
                'show'    => $resourceName . '.' . PermissionActionEnum::READ->value,
                'create'  => $resourceName . '.' . PermissionActionEnum::CREATE->value,
                'store'   => $resourceName . '.' . PermissionActionEnum::CREATE->value,
                'edit'    => $resourceName . '.' . PermissionActionEnum::UPDATE->value,
                'update'  => $resourceName . '.' . PermissionActionEnum::UPDATE->value,
                'destroy' => $resourceName . '.' . PermissionActionEnum::DELETE->value,
            ];

            if (isset($this->mapExtraActionPermission)) {
                $actionPermissionMap = array_merge($actionPermissionMap, $this->mapExtraActionPermission);
            }

        }

        if (!in_array($method, ($this->skipActions ?? []), true)) {

            if (isset($actionPermissionMap[$method])) {
                static::abort($actionPermissionMap[$method]);
            }

        }

        return $this->{$method}

        (...array_values($parameters));
    }

    protected static function abort($permission)
    {
        /**
         * Check if the user has the required permission
         */

        if (!optional(Auth::guard(AuthGuardEnum::ADMIN->value)->user())->can($permission)) {

            /**
             * Check if the request is an AJAX request
             */

            if (request()->ajax()) {
                throw new HttpResponseException(response()->json([
                    'success' => false,
                    'message' => localize('You have no right to access'),
                ], JsonResponse::HTTP_FORBIDDEN));
            } else {
                abort(JsonResponse::HTTP_FORBIDDEN, localize('You have no right to access'));
            }

        }

    }

}
