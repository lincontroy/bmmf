<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\StatusEnum;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Services\WebsiteService;

class SettingsController extends Controller
{
    use ResponseTrait;

    /**
     * WebsiteController constructor
     *
     */
    public function __construct(
        private WebsiteService $websiteService
    ) {

    }

    /**
     * Fetch setting data
     * @return \Illuminate\Http\JsonResponse
     */
    public function settingInfo(): JsonResponse
    {
        return $this->sendJsonResponse(
            'setting',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->websiteService->settingInfo()
        );
    }
}