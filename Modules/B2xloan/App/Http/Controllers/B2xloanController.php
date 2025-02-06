<?php

namespace Modules\B2xloan\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\CustomerRepository;
use App\Services\AcceptCurrencyService;
use App\Services\CustomerWithdrawAccountService;
use App\Services\WalletManageService;
use App\Services\WalletTransactionLogService;
use App\Traits\ChecksPermissionTrait;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\B2xloan\App\DataTables\B2xClosedLoanDataTable;
use Modules\B2xloan\App\DataTables\B2xLoanDataTable;
use Modules\B2xloan\App\DataTables\B2xLoanSummaryDataTable;
use Modules\B2xloan\App\Enums\B2xLoanStatusEnum;
use Modules\B2xloan\App\Services\B2xLoanService;

class B2xloanController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * B2xloanController constructor
     *
     */
    public function __construct(
        private B2xLoanService $b2xLoanService,
        private CustomerRepository $customerRepository,
        private CustomerWithdrawAccountService $customerWithdrawAccountService,
        private WalletManageService $walletManageService,
        private AcceptCurrencyService $acceptCurrencyService,
        private WalletTransactionLogService $transactionLogService,
    ) {
        $this->mapActionPermission = [
            'index'       => PermissionMenuEnum::B2X_LOAN_PENDING_LOANS->value . '.' . PermissionActionEnum::READ->value,
            'closedLoans' => PermissionMenuEnum::B2X_LOAN_CLOSED_LOANS->value . '.' . PermissionActionEnum::READ->value,
            'loanSummary' => PermissionMenuEnum::B2X_LOAN_LOAN_SUMMARY->value . '.' . PermissionActionEnum::READ->value,
            'show'        => PermissionMenuEnum::B2X_LOAN_PENDING_LOANS->value . '.' . PermissionActionEnum::READ->value,
            'getUser'     => PermissionMenuEnum::B2X_LOAN_PENDING_LOANS->value . '.' . PermissionActionEnum::READ->value,
            'update'      => PermissionMenuEnum::B2X_LOAN_PENDING_LOANS->value . '.' . PermissionActionEnum::READ->value,
            'destroy'     => PermissionMenuEnum::B2X_LOAN_PENDING_LOANS->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(B2xLoanDataTable $b2xLoanDataTable)
    {
        cs_set('theme', [
            'title'       => localize('B2x Loan'),
            'description' => localize('B2x Loan'),
        ]);

        return $b2xLoanDataTable->render('b2xloan::loan');
    }

    /**
     * Display a closed loan listing of the resource.
     */
    public function closedLoans(B2xClosedLoanDataTable $b2xClosedLoanDataTable)
    {
        cs_set('theme', [
            'title'       => localize('B2x Closed Loan'),
            'description' => localize('B2x Closed Loan'),
        ]);

        return $b2xClosedLoanDataTable->render('b2xloan::loan_closed');
    }

    /**
     * Display a listing of the resource.
     */
    public function loanSummary(B2xLoanSummaryDataTable $b2xLoanSummaryDataTable)
    {
        cs_set('theme', [
            'title'       => localize('B2x Loan Summary'),
            'description' => localize('B2x Loan Summary'),
        ]);

        return $b2xLoanSummaryDataTable->render('b2xloan::loan_summary');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('b2xloan::show');
    }

    /**
     * Display a listing of the resource.
     */
    public function getUser(Request $request): JsonResponse
    {
        $userId = (string) $request['user_id'];
        $loanId = $request['loanId'];

        $user = $this->customerRepository->firstWhere('id', $userId);

        if ($loanId > 0) {

            $loan = $this->b2xLoanService->findById($loanId);

            $attributes['customer_id']        = $user->id;
            $attributes['loan_id']            = $loanId;
            $attributes['payment_gateway_id'] = $loan->payment_gateway_id;

            $withdrawMethod = $this->customerWithdrawAccountService->userWithdrawAccount($attributes);

        }

        $user->payoutInfo = $withdrawMethod ?? null;

        return response()->json([
            'success' => true,
            'message' => $user ? "Your user is (" . $user->first_name . " " . $user->last_name . ")" : "User not found!",
            'title'   => "Add Credit",
            'data'    => $user ?? null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $data['loan_id']      = $id;
        $setStatus            = $request['set_status'];
        $data['set_status']   = $setStatus;
        $data['checker_note'] = $request['checker_note'];

        if ($setStatus === B2xLoanStatusEnum::REJECTED->value) {

            $loanInfo = $this->b2xLoanService->findById($id);
            $customer = $this->customerRepository->firstWhere('id', $loanInfo->customer_id);

            $currency   = $this->acceptCurrencyService->findCurrencyBySymbol('BTC');
            $btcBalance = $this->walletManageService->btcBalance($currency->id, $customer->user_id);

            $balance['freeze_balance'] = $loanInfo->hold_btc_amount;
            $balance['balance']        = $loanInfo->hold_btc_amount;

            $this->walletManageService->freezeBalanceDeduct($balance, $btcBalance->id);

            $logData['user_id']            = $customer->user_id;
            $logData['accept_currency_id'] = $currency->id;
            $logData['transaction']        = "Hold_BTC";
            $logData['transaction_type']   = "Credit";
            $logData['amount']             = $loanInfo->hold_btc_amount;
            $this->transactionLogService->create($logData);
        }

        $loan = $this->b2xLoanService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Loan update successfully"),
            'title'   => localize("B2xloan"),
            'segment' => "loan",
            'data'    => $loan,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @var int $id
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->b2xLoanService->destroy(['package_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Package delete successfully"),
            'title'   => localize("Package"),
        ]);

    }

}
