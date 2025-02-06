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

class TeamMemberController extends Controller
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
     * Fetch Team Members
     * @return \Illuminate\Http\JsonResponse
     */
    public function teamMember(Request $request): JsonResponse
    {
        $languageId = app()->make('language_id');
        $bannerData = $this->homeService->findManyArticles('team_member_banner', $languageId);
        $teamData   = $this->websiteService->findTeamMembers($request->input('page_no', 1));
        return $this->sendJsonResponse(
            'team_members',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'banner'        => $this->formateResponse($bannerData),
                'team'          => $teamData,
                'totalDataRows' => $teamData->total(),
            ]
        );
    }
}
