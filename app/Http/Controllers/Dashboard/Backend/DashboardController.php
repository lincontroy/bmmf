<?php

namespace App\Http\Controllers\Dashboard\Backend;

use App\Enums\StatusEnum;
use App\Enums\TxnTypeEnum;
use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use App\Services\InvestmentService;
use App\Services\TxnFeeReportService;
use App\Services\TxnReportService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private CustomerService $customerService,
        private TxnReportService $txnReportService,
        private TxnFeeReportService $txnFeeReportService,
        private InvestmentService $investmentService,
    ) {
    }

    /**
     * Index
     *
     * @return View
     */
    public function index(): View
    {
        cs_set('theme', [
            'title'       => localize('Dashboard'),
            'description' => localize('Dashboard'),
        ]);

        $data = $this->txnReportService->latestTxnData();

        $data['customerReport']        = $this->customerService->report();
        $data['depositReport']         = $this->txnReportService->report(TxnTypeEnum::DEPOSIT->value);
        $data['withdrawReport']        = $this->txnReportService->report(TxnTypeEnum::WITHDRAW->value);
        $data['transferReport']        = $this->txnReportService->report(TxnTypeEnum::TRANSFER->value);
        $data['investmentReport']      = $this->investmentService->report();
        $data['depositFeeReport']      = $this->txnFeeReportService->report(TxnTypeEnum::DEPOSIT->value);
        $data['withdrawFeeReport']     = $this->txnFeeReportService->report(TxnTypeEnum::WITHDRAW->value);
        $data['transferFeeReport']     = $this->txnFeeReportService->report(TxnTypeEnum::TRANSFER->value);
        $data['transactionFeeData']    = $this->txnFeeReportService->recentFeeData();
        $data['allTransactionData']    = $this->txnReportService->recentTnxData();
        $data['investmentHistoryData'] = $this->investmentService->investmentHistoryData();

        return view('backend.dashboard', $data);
    }

    public function create()
    {
        $data['title'] = localize("Dashboard");

        return view('dashboard.backend.dashboard', $data);
    }

    /**
     * Fetch all customer report data
     * @return JsonResponse
     */
    public function customerChartData(): JsonResponse
    {
        return $this->sendJsonResponse(
            'customer_chart',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->customerService->customerChartData(),
        );
    }

    /**
     * txn chart data
     * @param Request $request
     * @return JsonResponse
     */
    public function txnChartData(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'txn_type' => 'required|string|in:deposit,transfer,withdraw',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => localize('Validation failed'),
                'errors'  => $e->validator->errors()->all(),
            ], 422);
        }

        $txnType = $validatedData['txn_type'];

        if ($txnType == 'deposit') {
            $txnType = TxnTypeEnum::DEPOSIT->value;
        } elseif ($txnType == 'withdraw') {
            $txnType = TxnTypeEnum::WITHDRAW->value;
        } elseif ($txnType == 'transfer') {
            $txnType = TxnTypeEnum::TRANSFER->value;
        } else {
            $txnType = '';
        }

        return $this->sendJsonResponse(
            'txn_chart',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->txnReportService->chartData($txnType),
        );
    }

    /**
     * txn chart data
     * @param Request $request
     * @return JsonResponse
     */
    public function txnFeeChartData(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'txn_type' => 'required|string|in:deposit,transfer,withdraw',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => localize('Validation failed'),
                'errors'  => $e->validator->errors()->all(),
            ], 422);
        }

        $txnType = $validatedData['txn_type'];

        if ($txnType == 'deposit') {
            $txnType = TxnTypeEnum::DEPOSIT->value;
        } elseif ($txnType == 'withdraw') {
            $txnType = TxnTypeEnum::WITHDRAW->value;
        } elseif ($txnType == 'transfer') {
            $txnType = TxnTypeEnum::TRANSFER->value;
        } else {
            $txnType = '';
        }

        return $this->sendJsonResponse(
            'txn_chart',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->txnFeeReportService->chartData($txnType),
        );
    }

    /**
     * Fetch all investment chart data
     * @return JsonResponse
     */
    public function investmentChartData(): JsonResponse
    {
        return $this->sendJsonResponse(
            'investment_chart',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->investmentService->chartData(),
        );
    }

    public function txnHistory(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'txn_type'  => 'required|string|in:deposit,transfer,withdraw,investment',
                'data_type' => 'required|string|in:m,y',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $e->validator->errors()->all(),
            ], 422);
        }

        $txnType  = $validatedData['txn_type'];
        $dataType = $validatedData['data_type'];

        if ($txnType == "investment") {
            $historyData = $this->investmentService->historyChart($dataType);
        } else {

            if ($txnType == 'deposit') {
                $txnType = TxnTypeEnum::DEPOSIT->value;
            } elseif ($txnType == 'withdraw') {
                $txnType = TxnTypeEnum::WITHDRAW->value;
            } elseif ($txnType == 'transfer') {
                $txnType = TxnTypeEnum::TRANSFER->value;
            } else {
                $txnType = '';
            }

            $historyData = $this->txnReportService->historyChartData($txnType, $dataType);
        }

        return $this->sendJsonResponse(
            'txn_history_chart',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $historyData,
        );
    }

    /**
     * Accept Currency Chart Data
     * @return \Illuminate\Http\JsonResponse
     */
    public function acceptCurrencyChart(): JsonResponse
    {
        return $this->sendJsonResponse(
            'accept_currency_chart',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->txnReportService->currencyChartData(),
        );
    }

}
