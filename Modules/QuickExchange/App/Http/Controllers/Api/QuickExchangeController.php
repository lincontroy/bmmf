<?php

namespace Modules\QuickExchange\App\Http\Controllers\Api;

use App\Enums\ErrorEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Services\HomeService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\QuickExchange\App\Http\Requests\QuickExchangeCoinRequest;
use Modules\QuickExchange\App\Http\Requests\QuickExchangeRateRequest;
use Modules\QuickExchange\App\Http\Requests\QuickExchangeRequest;
use Modules\QuickExchange\App\Services\QuickExchangeService;
use Symfony\Component\HttpFoundation\Response;

class QuickExchangeController extends Controller
{
    use ResponseTrait;

    /**
     * WebsiteController constructor
     *
     */
    public function __construct(
        private QuickExchangeService $quickExchangeService,
        private HomeService $homeService,
    ) {

    }

    /**
     * Fetch Quick Exchange Calculator Data
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickExchange(): JsonResponse
    {
        $languageId = app()->make('language_id');
        $cmsData = $this->homeService->findManyArticles('quick_exchange', $languageId);

        return $this->sendJsonResponse(
            'quick_exchange',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'quick_exchange_cms'  => $this->formateResponse($cmsData),
                'quick_exchange_content' => $this->quickExchangeService->quickExchange(),
            ]
        );
    }

    /**
     * Fetch all quick exchange supported coin
     * @param \Modules\QuickExchange\App\Http\Requests\QuickExchangeCoinRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickExchangeSupportCoins(QuickExchangeCoinRequest $request): JsonResponse
    {
        $sellCurrency = $request->get('sell_currency');

        return $this->sendJsonResponse(
            'quick_exchange_coins',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->quickExchangeService->supportCoins($sellCurrency),
        );
    }

    /**
     * Fetch Quick Exchange Rate
     * @param \Modules\QuickExchange\App\Http\Requests\QuickExchangeRateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickExchangeRate(QuickExchangeRateRequest $request): JsonResponse
    {
        $validateData = $this->quickExchangeService->quickExchangeNextValidate($request->all());

        if ($validateData->status == StatusEnum::SUCCESS->value) {
            $rateData = $this->quickExchangeService->quickExchangeRate([
                'validateData' => $validateData->data,
                'sell_coin'    => $request->sell_coin,
                'buy_coin'     => $request->buy_coin,
                'sell_amount'  => $request->sell_amount,
                'buy_amount'   => $request->buy_amount,
            ]);

            if ($rateData->status == StatusEnum::SUCCESS->value) {
                return $this->sendJsonResponse(
                    'quick_exchange_rate',
                    StatusEnum::SUCCESS->value,
                    Response::HTTP_OK,
                    '',
                    (object) $rateData->data,
                );
            } else {
                return $this->sendErrorResponse(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    ErrorEnum::FILTER_ERROR->value,
                    (object) $rateData->errorData,
                );
            }

        } else {
            return $this->sendErrorResponse(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                ErrorEnum::FILTER_ERROR->value,
                (object) $validateData->errorData,
            );
        }

    }

    /**
     * Quick Exchange Transaction List
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickExchangeTransaction(Request $request): JsonResponse
    {
        $transaction = $this->quickExchangeService->quickExchangeTransaction($request->input('page_no', 1));
        return $this->sendJsonResponse(
            'quick_exchange_transaction',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            (object) [
                'transaction'   => $transaction,
                'totalDataRows' => $transaction->total(),
            ],
        );
    }

    /**
     * Action of Quick Exchange Next
     * @param \Modules\QuickExchange\App\Http\Requests\QuickExchangeRateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickExchangeNext(QuickExchangeRateRequest $request): JsonResponse
    {
        $validateData = $this->quickExchangeService->quickExchangeNextValidate($request->all());

        if ($validateData->status == StatusEnum::SUCCESS->value) {
            $rateData = $this->quickExchangeService->quickExchangeNext([
                'validateData' => $validateData->data,
                'sell_coin'    => $request->sell_coin,
                'buy_coin'     => $request->buy_coin,
                'sell_amount'  => $request->sell_amount,
                'buy_amount'   => $request->buy_amount,
            ]);

            if ($rateData->status == StatusEnum::SUCCESS->value) {
                return $this->sendJsonResponse(
                    'quick_exchange_next',
                    StatusEnum::SUCCESS->value,
                    Response::HTTP_OK,
                    '',
                    (object) $rateData->data,
                );
            } else {
                return $this->sendErrorResponse(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    ErrorEnum::FILTER_ERROR->value,
                    (object) $rateData->errorData,
                );
            }

        } else {
            return $this->sendErrorResponse(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                ErrorEnum::FILTER_ERROR->value,
                (object) $validateData->errorData,
            );
        }

    }

    /**
     * Store Quick Exchange Data
     * @param \Modules\QuickExchange\App\Http\Requests\QuickExchangeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickExchangeStore(QuickExchangeRequest $request): JsonResponse
    {
        $rateData = $this->quickExchangeService->quickExchangeRequest($request->all());

        if ($rateData->status == StatusEnum::SUCCESS->value) {
            return $this->sendJsonResponse(
                'quick_exchange_request',
                StatusEnum::SUCCESS->value,
                Response::HTTP_OK,
                $rateData->message,
                (object) [],
            );
        } else {
            return $this->sendErrorResponse(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                ErrorEnum::FILTER_ERROR->value,
                (object) $rateData->errorData,
            );
        }

    }

}