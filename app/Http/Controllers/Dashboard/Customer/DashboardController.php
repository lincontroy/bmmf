<?php

namespace App\Http\Controllers\Dashboard\Customer;

use App\Enums\StatusEnum;
use App\Enums\TxnTypeEnum;
use App\Http\Controllers\Controller;
use App\Services\CustomerDashboardService;
use App\Services\CustomerService;
use App\Services\InvestmentEarningService;
use App\Services\InvestmentService;
use App\Services\TxnReportService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Modules\Package\App\Services\PackageService;
use Modules\Package\App\Services\TeamBonusService;
use Modules\Stake\App\Services\StakePlanService;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    use ResponseTrait;

    /**
     * DashboardController of __construct
     *
     * @param PackageService $packageService
     * @param CustomerDashboardService $customerDashboardService
     */
    public function __construct(
        protected PackageService $packageService,
        protected StakePlanService $stakePlanService,
        protected CustomerDashboardService $customerDashboardService,
        private TxnReportService $txnReportService,
        private CustomerService $customerService,
        private InvestmentService $investmentService,
        private InvestmentEarningService $investmentEarningService,
        private TeamBonusService $teamBonusService,
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
            'title'       => localize('Customer Dashboard'),
            'description' => localize('Customer Dashboard'),
        ]);

        $customerId = Auth::id();
        $userId     = Auth::user()->user_id;

        $data                 = $this->customerDashboardService->latestTxnData();
        $data['totalBalance'] = $this->customerDashboardService->getBalance();
        $data['packages']     = $this->packageService->allActivePackages();
        $data['stakes']       = $this->stakePlanService->allActive();
        $data['investments']  = $this->customerDashboardService->recentInvestment();

        $data['depositReport']         = $this->txnReportService->report(TxnTypeEnum::DEPOSIT->value, $customerId);
        $data['withdrawReport']        = $this->txnReportService->report(TxnTypeEnum::WITHDRAW->value, $customerId);
        $data['transferReport']        = $this->txnReportService->report(TxnTypeEnum::TRANSFER->value, $customerId);
        $data['investmentReport']      = $this->investmentService->report($userId);
        $data['investmentRoi']         = $this->investmentEarningService->report($userId);
        $data['teamTurnOverReport']    = $this->teamBonusService->report($userId, 'team');
        $data['sponsorTurnoverReport'] = $this->teamBonusService->report($userId, 'sponsor');

        return view('customer.dashboard', $data);
    }

    /**
     * txn chart data
     *
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

        $customerId = Auth::id();

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
            $this->txnReportService->chartData($txnType, $customerId),
        );
    }

    /**
     * investment chart data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function investmentChartData(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'txn_type' => 'required|string|in:investment',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => localize('Validation failed'),
                'errors'  => $e->validator->errors()->all(),
            ], 422);
        }

        $userId = Auth::user()->user_id;

        return $this->sendJsonResponse(
            'investment_chart',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->investmentService->chartData($userId),
        );
    }

    /**
     * payout chart data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function payoutChartData(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'txn_type' => 'required|string|in:payout',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => localize('Validation failed'),
                'errors'  => $e->validator->errors()->all(),
            ], 422);
        }

        $userId = Auth::user()->user_id;

        return $this->sendJsonResponse(
            'txn_chart',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->investmentEarningService->chartData($userId),
        );
    }

    /**
     * team turnover chart data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function teamTurnoverChartData(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'txn_type' => 'required|string|in:team-turnover',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => localize('Validation failed'),
                'errors'  => $e->validator->errors()->all(),
            ], 422);
        }

        $txnType = $validatedData['txn_type'];
        $userId  = Auth::user()->user_id;

        return $this->sendJsonResponse(
            'txn_chart',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->teamBonusService->teamTurnoverChartData($userId, $txnType),
        );
    }

    /**
     * sponsor turn chart data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sponsorTurnoverChartData(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'txn_type' => 'required|string|in:sponsor-turnover',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => localize('Validation failed'),
                'errors'  => $e->validator->errors()->all(),
            ], 422);
        }

        $txnType = $validatedData['txn_type'];
        $userId  = Auth::user()->user_id;

        return $this->sendJsonResponse(
            'txn_chart',
            StatusEnum::SUCCESS->value,
            Response::HTTP_OK,
            '',
            $this->teamBonusService->teamTurnoverChartData($userId, $txnType),
        );
    }

}
