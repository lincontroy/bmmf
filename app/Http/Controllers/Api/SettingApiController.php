<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Services\HomeService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class SettingApiController extends Controller
{
    use ResponseTrait;

      /**
     * System Information
     *
     * @return mixed
     */
    public function systemInfo(Request $request)
    {
        return response()->success([], localize('System Information'));
    }
}
