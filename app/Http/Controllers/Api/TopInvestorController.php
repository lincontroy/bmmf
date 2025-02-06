<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Services\HomeService;
use App\Services\WebsiteService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TopInvestorController extends Controller
{
    use ResponseTrait;

    /**
     * WebsiteController constructor
     *
     */
    public function __construct(
        private HomeService $homeService,
        private WebsiteService $websiteService
    ) {

    }

    /**
     * Fetch all top investors
     * @return \Illuminate\Http\JsonResponse
     */
    public function topInvestors(Request $request): JsonResponse
    {
        $languageId   = app()->make('language_id');
        $bannerData   = $this->homeService->findManyArticles('top_investor_banner', $languageId);
        $topInvestors = $this->homeService->findTopInvestors($request->input('page_no', 1));
        $topInvestors = (object) [
            "banner"        => $this->formateResponse($bannerData),
            "investors"     => $topInvestors,
            "totalDataRows" => $topInvestors->total(),
        ];
        return $this->sendJsonResponse(
            'top_investors',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $topInvestors,
        );
    }

    /**
     * Fetch all top investors
     * @return \Illuminate\Http\JsonResponse
     */
    public function homeTopInvestors(Request $request): JsonResponse
    {
        $languageId   = app()->make('language_id');
        $headerData   = $this->homeService->findManyArticles('top_investor_header', $languageId);
        $topInvestors = $this->homeService->findTopInvestors($request->input('page_no', 1));
        $topInvestors = (object) [
            "header"        => $this->formateResponse($headerData),
            "investors"     => $topInvestors,
            "totalDataRows" => $topInvestors->total(),
        ];
        return $this->sendJsonResponse(
            'top_investors',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $topInvestors,
        );
    }
}
