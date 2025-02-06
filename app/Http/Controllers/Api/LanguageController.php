<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\StatusEnum;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Services\WebsiteService;

class LanguageController extends Controller
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
     * Fetch All Languages List
     * @return \Illuminate\Http\JsonResponse
     */
    public function languages(): JsonResponse
    {
        return $this->sendJsonResponse(
            'social_icon',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->websiteService->languages()
        );
    }
}
