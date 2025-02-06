<?php

namespace Modules\B2xloan\App\Http\Controllers\Api;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ExternalApiRepositoryInterface;
use App\Services\HomeService;
use App\Services\WebsiteService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Modules\B2xloan\App\Http\Requests\B2xLoanCalculatorRequest;
use Modules\B2xloan\App\Repositories\Interfaces\PackageRepositoryInterface;
use Modules\B2xloan\App\Services\B2xLoanApiService;
use Symfony\Component\HttpFoundation\Response;

class B2xLoanController extends Controller
{
    use ResponseTrait;

    /**
     * B2xLoanController constructor
     *
     * @param B2xLoanApiService $b2xLoanService
     * @param ExternalApiRepositoryInterface $externalApiRepository
     * @param B2xLoanPackageRepositoryInterface $b2xLoanPackageRepository
     */
    public function __construct(
        private B2xLoanApiService $b2xLoanService,
        private WebsiteService $websiteService,
        private HomeService $homeService,
        private ExternalApiRepositoryInterface $externalApiRepository,
        private PackageRepositoryInterface $packageRepository,
    ) {
    }

    /**
     * Fetch b2x loan data by language
     *
     * @return JsonResponse
     */
    public function b2xLoan(): JsonResponse
    {
        $languageId = app()->make('language_id');
        $headerData = $this->homeService->findManyArticles('b2x_loan', $languageId);
        $bannerData = $this->homeService->findManyArticles('b2x_loan_banner', $languageId);

        return $this->sendJsonResponse(
            'b2xloan_data',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'b2x_banner'       => $this->formateResponse($bannerData),
                'b2x_loan_content' => $this->formateResponse($headerData),
            ]
        );
    }

    /**
     * Fetch Nishue difference data by language
     *
     * @return JsonResponse
     */
    public function difference(): JsonResponse
    {
        $languageId = app()->make('language_id');
        $headerData = $this->homeService->findLangArticle('our_difference_header', $languageId);

        return $this->sendJsonResponse(
            'our_difference',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'our_difference_header' => $this->formateResponse($headerData),
                'our_difference_body'   => $this->b2xLoanService->findLangManyArticles(
                    'our_difference_content',
                    $languageId
                ),
            ]
        );
    }

    /**
     * Fetch our rates data by language
     *
     * @return JsonResponse
     */
    public function ourRate(): JsonResponse
    {
        $languageId = app()->make('language_id');
        $headerData = $this->homeService->findLangArticle('our_rates_header', $languageId);

        return $this->sendJsonResponse(
            'our_rates',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'our_rate_header'  => $this->formateResponse($headerData),
                'our_rate_content' => $this->b2xLoanService->findLangManyArticles('our_rate_content', $languageId),
            ]
        );
    }

    /**
     * Fetch join with nishue data by language
     *
     * @return JsonResponse
     */
    public function joinToday(): JsonResponse
    {
        $languageId = app()->make('language_id');
        $headerData = $this->homeService->findLangArticle('join_us_today', $languageId);

        return $this->sendJsonResponse(
            'join_us_today',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) $this->formateResponse($headerData)
        );
    }

    public function b2xPackage(): JsonResponse
    {
        $languageId = app()->make('language_id');
        $headerData = $this->homeService->findLangArticle('b2x_calculator_header', $languageId);
        $btcRate    = $this->b2xLoanService->findData();

        return $this->sendJsonResponse(
            'b2xloan_packages',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'b2xpackage_header' => $this->formateResponse($headerData),
                'btcInfo'           => $btcRate,
                'packages'          => $this->b2xLoanService->packages(),
            ]
        );
    }

    /**
     * Fetch join with nishue data by language
     *
     * @return JsonResponse
     */
    public function b2xLoanCalculator(B2xLoanCalculatorRequest $request): JsonResponse
    {
        $languageId = app()->make('language_id');

        $month                        = $request['package_month'];
        $attributes['holding_amount'] = $request['holding_amount'];
        $attributes['package_month']  = $request['package_month'];
        $feeInfo                      = $this->packageRepository->firstWhere('no_of_month', $month);

        $headerData         = $this->homeService->findLangArticle('b2x_loan_details_header', $languageId);
        $loanDetailsContent = $this->b2xLoanService->findLangManyArticles('b2x_loan_details_content', 1);

        if ($feeInfo) {
            $result          = $this->b2xLoanService->b2xLoanCalculator($attributes);
            $responseDataSet = [];

            foreach ($result as $key => $value) {
                $responseDataSet[] = [
                    "label" => $loanDetailsContent[0]->articleLangData[$key]->small_content,
                    "value" => $value,
                ];
            }

            return $this->sendJsonResponse(
                'B2x_loan_calculation',
                StatusEnum::SUCCESS->value,
                Response::HTTP_OK,
                '',
                (object) [
                    "loan_header" => $this->formateResponse($headerData),
                    "loan_data"   => $responseDataSet,
                ],
            );
        } else {
            return $this->sendJsonResponse(
                'external_api_info',
                StatusEnum::SUCCESS->value,
                Response::HTTP_OK,
                'This packages are not found!',
                (object) [],
            );
        }

    }

}
