<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Enums\StatusEnum;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Services\HomeService;
use App\Traits\ResponseTrait;

class OurServiceController extends Controller
{
    use ResponseTrait;

    /**
     * WebsiteController constructor
     *
     */
    public function __construct(
        private HomeService $homeService,
    ) {

    }

    /**
     * Fetch Blog us by language
     * @return \Illuminate\Http\JsonResponse
     */
    public function ourServices(): JsonResponse
    {
        $languageId = app()->make('language_id');
        $headerData = $this->homeService->findLangArticle('our_service_header', $languageId);
        $bannerData = $this->homeService->findManyArticles('service_top_banner', $languageId);

        return $this->sendJsonResponse(
            'our_services',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'our_service_banner' => $this->formateResponse($bannerData),
                'our_service_header' => $this->formateResponse($headerData),
                'our_service_content' => $this->homeService->findLangManyArticles('our_service', $languageId),
            ]
        );
    }
}