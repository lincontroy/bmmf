<?php

namespace Modules\B2xloan\App\Http\Controllers\Customer;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Interfaces\ExternalApiRepositoryInterface;
use App\Services\AcceptCurrencyService;
use App\Services\CustomerWithdrawAccountService;
use App\Services\HomeService;
use App\Services\PaymentGatewayService;
use App\Services\SettingService;
use App\Services\WalletManageService;
use App\Services\WalletTransactionLogService;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\B2xloan\App\DataTables\Customer\LoansDataTable;
use Modules\B2xloan\App\Enums\B2xLoanStatusEnum;
use Modules\B2xloan\App\Enums\B2xLoanWithdrawStatusEnum;
use Modules\B2xloan\App\Http\Requests\B2xLoanCalculatorRequest;
use Modules\B2xloan\App\Http\Requests\B2xLoanWithdrawRequest;
use Modules\B2xloan\App\Services\B2xLoanApiService;
use Modules\B2xloan\App\Services\B2xLoanService;
use Modules\B2xloan\App\Services\PackageService;
use Symfony\Component\HttpFoundation\Response;

class B2xLoanController extends Controller
{
    use ResponseTrait;

    /**
     * B2xloanController constructor
     *
     */
    public function __construct(
        private B2xLoanService $b2xLoanService,
        private B2xLoanApiService $b2xLoanApiService,
        private CustomerRepository $customerRepository,
        private PackageService $packageService,
        private AcceptCurrencyService $acceptCurrencyService,
        private WalletManageService $walletManageService,
        private ExternalApiRepositoryInterface $externalApiRepository,
        private HomeService $homeService,
        private SettingService $settingService,
        private CustomerWithdrawAccountService $customerWithdrawAccountService,
        private PaymentGatewayService $paymentGatewayService,
        private WalletTransactionLogService $transactionLogService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        cs_set('theme', [
            'title'       => localize('B2x Loan Calculator'),
            'description' => localize('B2x Loan Calculator'),
        ]);

        $userId = Auth::user()->user_id;

        $currency   = $this->acceptCurrencyService->findCurrencyBySymbol('BTC');
        $btcBalance = $this->walletManageService->btcBalance($currency->id, $userId);
        $packages   = $this->packageService->allActive();

        $user = Auth::user();

        return view('b2xloan::customer.index', compact('packages', 'btcBalance', 'user'));
    }

    public function b2xLoanList(LoansDataTable $loansDataTable)
    {
        cs_set('theme', [
            'title'       => localize('B2x Loans'),
            'description' => localize('B2x Loans'),
        ]);


        $attributes['customer_id'] = Auth::id();
        $paymentGateway            = $this->paymentGatewayService->findGateway();

        return $loansDataTable->render('b2xloan::customer.loans', compact('paymentGateway'));
    }

    public function userLoanWithdrawRequest(B2xLoanWithdrawRequest $request)
    {
        $data = $request->validated();

        $loanId                           = $data['loanId'];
        $attributes['customer_id']        = Auth::id();
        $attributes['loan_id']            = $loanId;
        $attributes['payment_gateway_id'] = $data['payment_method'];

        $loan = $this->b2xLoanService->checkLoan($attributes);

        if ($loan && $loan->status->value == B2xLoanStatusEnum::APPROVED->value) {
            $dataValue['loan_id']          = $loan->id;
            $dataValue['payment_method']   = $data['payment_method'];
            $dataValue['payment_currency'] = $data['payment_currency'];
            $dataValue['withdraw_status']  = B2xLoanWithdrawStatusEnum::PENDING->value;

            $res = $this->b2xLoanService->withdrawRequestUpdate($dataValue);

            return response()->json([
                'success' => true,
                'message' => localize("Your withdraw request send successfully!"),
                'title'   => localize("Loan Withdraw"),
                'segment' => "loan",
                'data'    => $res,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => localize("Invalid Loan"),
                'title'   => localize("Loan Withdraw"),
                'segment' => "loan",
                'data'    => null,
            ]);
        }
    }

    public function userWithdrawAccount(Request $request)
    {
        $attributes['customer_id']        = Auth::id();
        $attributes['payment_gateway_id'] = $request['payment_gateway_id'];

        $withdrawMethod = $this->customerWithdrawAccountService->userWithdrawAccount($attributes);

        if (!empty($withdrawMethod)) {
            return response()->json([
                'success' => true,
                'message' => "",
                'title'   => localize("Withdraw Account"),
                'segment' => "loan",
                'data'    => $withdrawMethod,
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => "",
                'title'   => localize("Withdraw Account"),
                'segment' => "loan",
                'data'    => null,
            ]);
        }
    }

    public function loanCalculator(B2xLoanCalculatorRequest $request)
    {
        $month                        = $request['package_month'];
        $attributes['holding_amount'] = $request['holding_amount'];
        $attributes['package_month']  = $request['package_month'];
        $externalApiData              = $this->externalApiRepository->firstWhere('name', 'coinmarketcap');
        $feeInfo                      = $this->packageService->feeInfo($month);
        $setting                      = $this->settingService->findById();

        $headerData         = $this->homeService->findLangArticle(
            'b2x_loan_details_header',
            $setting->language_id
        )->first();
        $loanDetailsContent = $this->b2xLoanApiService->findLangManyArticles(
            'b2x_loan_details_content',
            $setting->language_id
        );

        if ($feeInfo) {
            $attributes['interest_percent'] = $feeInfo->interest_percent;
            $result                         = $this->b2xLoanApiService->b2xLoanCalculator($attributes);
            $responseDataSet                = [];
            foreach ($result as $key => $value) {
                $responseDataSet[] = [
                    "label" => $loanDetailsContent[0]->articleLangData[$key]->small_content,
                    "value" => $value,
                ];
            }

            $viewHtml = view('b2xloan::customer.calculator', compact('responseDataSet', 'headerData'))->render();

            return response()->json([
                'content' => $viewHtml,
            ], 200);

        } else {

            return $this->sendJsonResponse(
                'external_api_info',
                StatusEnum::SUCCESS->value,
                Response::HTTP_OK,
                localize('This packages are not found!'),
                (object)[],
            );
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(B2xLoanCalculatorRequest $request): JsonResponse
    {
        $data                         = $request->validated();
        $userId                       = Auth::user()->user_id;
        $customerId                   = Auth::id();
        $month                        = $data['package_month'];
        $holdAmount                   = $data['holding_amount'];
        $attributes['holding_amount'] = $holdAmount;
        $attributes['package_month']  = $month;
        $currency                     = $this->acceptCurrencyService->findCurrencyBySymbol('BTC');
        $btcBalance                   = $this->walletManageService->btcBalance($currency->id, $userId);
        $feeInfo                      = $this->packageService->feeInfo($month);

        $this->b2xLoanService->pendingAndSuccessLoanAmount($customerId);

        if (!empty($btcBalance) && $btcBalance->balance >= $holdAmount) {
            $calculation = $this->b2xLoanApiService->b2xLoanCalculator($attributes);

            $loanAmount        = 0;
            $installmentAmount = 0;
            foreach ($calculation as $key => $item) {
                if ($key == 0) {
                    $loanAmount = $item;
                } elseif ($key == 1) {
                    $installmentAmount = $item;
                }
            }

            $loanData = [
                'customer_id'           => $customerId,
                'b2x_loan_package_id'   => $feeInfo->id,
                'interest_percent'      => $feeInfo->interest_percent,
                'loan_amount'           => $loanAmount,
                'hold_btc_amount'       => $holdAmount,
                'installment_amount'    => $installmentAmount,
                'number_of_installment' => $month,
                'remaining_installment' => $month,
            ];

            $res                          = $this->b2xLoanService->create($loanData);
            $walletData['freeze_balance'] = $btcBalance->freeze_balance + $holdAmount;
            $walletData['balance']        = $btcBalance->balance - $holdAmount;
            $this->walletManageService->updateUserWallet($walletData, $btcBalance->id);

            $logData['user_id']            = $userId;
            $logData['accept_currency_id'] = $currency->id;
            $logData['transaction']        = "Hold_BTC";
            $logData['transaction_type']   = "debit";
            $logData['amount']             = $holdAmount;
            $this->transactionLogService->create($logData);

            return response()->json([
                'success' => true,
                'message' => localize("Your loan request successfully done!"),
                'title'   => localize("B2x-Loan"),
                'data'    => $res,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => localize('you_have_not_enough_btc_balance'),
                'title'   => localize("B2x-Loan"),
                'data'    => '',
            ]);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('b2xloan::show');
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
        $data['set_status']   = $request['set_status'];
        $data['checker_note'] = $request['checker_note'];
        $loan                 = $this->b2xLoanService->update($data);

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
