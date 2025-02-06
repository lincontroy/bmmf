<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Services\HomeService;
use App\Services\WebsiteService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AboutController extends Controller
{
    use ResponseTrait;

    /**
     * WebsiteController constructor
     *
     */
    public function __construct(
        private HomeService $homeService,
        private WebsiteService $websiteService,
    ) {

    }

    /**
     * Fetch about us by language
     * @return \Illuminate\Http\JsonResponse
     */
    public function homeAbout(): JsonResponse
    {
        $languageId = app()->make('language_id');

        return $this->sendJsonResponse(
            'home_about',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->homeService->findManyArticles('home_about', $languageId)->first(),
        );
    }

    /**
     * Fetch about us by language
     * @return \Illuminate\Http\JsonResponse
     */
    public function about(): JsonResponse
    {
        $languageId     = app()->make('language_id');
        $bannerData     = $this->homeService->findManyArticles('about_us_banner', $languageId);
        $teamHeaderData = $this->homeService->findLangArticle('team_header', $languageId);
        $faqHeaderData  = $this->homeService->findLangArticle('faq_header', $languageId);

        return $this->sendJsonResponse(
            'about',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'about_banner'  => $this->formateResponse($bannerData),
                'about_content' => $this->homeService->findManyArticles('home_about', $languageId)->first(),
                'team_header'   => $this->formateResponse($teamHeaderData),
                'team'          => $this->websiteService->findTeamMembers(request()->input('page_no', 1)),
                'faq_header'    => $this->formateResponse($faqHeaderData),
                'faq_body'      => $this->homeService->findFaqArticles('faq_content', $languageId),
            ]
        );
    }
}
