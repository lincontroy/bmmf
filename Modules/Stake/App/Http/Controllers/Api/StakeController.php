<?php

namespace Modules\Stake\App\Http\Controllers\Api;

use App\Enums\StatusEnum;
use Illuminate\Http\Request;
use App\Services\HomeService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Modules\Stake\App\Services\StakePlanService;

class StakeController extends Controller
{
    use ResponseTrait;

    /**
     * WebsiteController constructor
     *
     */
    public function __construct(
        private StakePlanService $stakePlanService,
        private HomeService $homeService
    ) {

    }

    /**
     * Fetch all active stakes
     * @return \Illuminate\Http\JsonResponse
     */
    public function stakes(Request $request): JsonResponse
    {
        $languageId = app()->make('language_id');
        $headerData = $this->homeService->findManyArticles('stake_banner', $languageId);
        $stakeData  = $this->stakePlanService->findStakePlans($request->input('page_no', 1));
        return $this->sendJsonResponse(
            'stakes',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'stake_banner'  => $this->formateResponse($headerData),
                'stake_content' => $stakeData,
                'totalDataRows' => $stakeData->total(),
            ]
        );
    }
}