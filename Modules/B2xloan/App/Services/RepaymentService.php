<?php

namespace Modules\B2xloan\App\Services;

use App\Enums\FeeSettingLevelEnum;
use App\Enums\PaymentRequestStatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Enums\WalletManageLogEnum;
use App\Repositories\Interfaces\WalletManageRepositoryInterface;
use App\Services\AcceptCurrencyService;
use App\Services\CoinPaymentService;
use App\Services\Customer\CustomerService;
use App\Services\FeeSettingService;
use App\Services\NotificationService;
use App\Services\PaymentGatewayService;
use App\Services\PaymentRequestService;
use App\Services\SettingService;
use App\Services\StripeService;
use App\Services\TxnFeeReportService;
use App\Services\TxnReportService;
use App\Services\WalletManageService;
use App\Services\WalletTransactionLogService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\B2xloan\App\Enums\B2xLoanRepaymentStatusEnum;
use Modules\B2xloan\App\Enums\B2xLoanStatusEnum;
use Modules\B2xloan\App\Repositories\Interfaces\B2xLoanRepayRepositoryInterface;
use Modules\Finance\App\Repositories\Interfaces\DepositRepositoryInterface;
use Modules\Merchant\App\Services\MerchantFeeService;

class RepaymentService
{
    /**
     * DepositService constructor.
     *
     * @param DepositRepositoryInterface $depositRepository
     * @param WalletManageRepositoryInterface $walletManageRepository
     * @param WalletTransactionLogService $walletTransactionLogService
     */
    public function __construct(
        private DepositRepositoryInterface $depositRepository,
        private WalletManageRepositoryInterface $walletManageRepository,
        private WalletTransactionLogService $walletTransactionLogService,
        private PaymentGatewayService $paymentGatewayService,
        private PaymentRequestService $paymentRequestService,
        private CoinPaymentService $coinPaymentService,
        private FeeSettingService $feeSettingService,
        private StripeService $stripeService,
        private WalletManageService $walletManageService,
        private AcceptCurrencyService $acceptCurrencyService,
        private CustomerService $customerService,
        private MerchantFeeService $merchantFeeService,
        private TxnReportService $txnReportService,
        private TxnFeeReportService $txnFeeService,
        private NotificationService $notificationService,
        private B2xLoanRepayRepositoryInterface $b2xLoanRepayRepository,
        private B2xLoanService $b2xLoanService,
        private WalletTransactionLogService $transactionLogService,
        protected SettingService $settingService
    ) {
    }

    /**
     * get data by id
     * @param mixed $id
     * @return object
     */
    public function findById($id): object
    {
        return $this->depositRepository->find($id);
    }

    /**
     * get data by id
     * @param array $attributes
     * @return object
     */
    public function getAll(array $attributes): object
    {
        return $this->depositRepository->getAll($attributes);
    }

    /**
     * get data by id
     * @param mixed $id
     * @return object
     */
    public function creditDetails($id): object
    {
        return $this->depositRepository->creditDetails($id);
    }

    /**
     * Update deposit
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $depositId          = $attributes['deposit_id'];
        $data['status']     = $attributes['set_status'];
        $data['updated_by'] = $attributes['updated_by'];

        try {
            DB::beginTransaction();

            $this->depositRepository->updateById($depositId, $data);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => localize("Deposit update error"),
                    'title'   => localize('Deposit'),
                    'errors'  => $exception,
                ], 422)
            );
        }

    }

    public function makeDeposit(array $attributes): object
    {
        $paymentMethodId = $attributes['payment_method'];
        $paymentAmount   = $attributes['deposit_amount'];
        $paymentCurrency = $attributes['payment_currency'];
        $fiatCurrency    = $attributes['fiat_currency'] ?? 'USD';
        $depositComments = $attributes['deposit_comments'];
        $txnType         = $attributes['txn_type'];
        $feesType        = $attributes['fees_type'];
        $gatewayInfo     = $this->paymentGatewayService->find($paymentMethodId);
        $buyerEmail      = auth()->user()->email;
        $userId          = auth()->user()->user_id;
        $usdValue        = $paymentAmount;

        if (!$gatewayInfo) {
            return (object) ["status" => "error", "message" => localize("The payment method has been deactivated.")];
        }

        $oldRequest = $this->paymentRequestService->findTxnId([
            "gatewayId" => $paymentMethodId,
            "user"      => $userId,
            "currency"  => $paymentCurrency,
            "amount"    => $paymentAmount,
            "txnType"   => $txnType,
        ]);

        if (!$oldRequest) {

            if ($paymentAmount < $gatewayInfo->min_deposit) {
                return (object) [
                    "status"  => "error",
                    "message" => localize(
                        "The payment amount must be grater than or equal to "
                    ) . $gatewayInfo->min_deposit . ' USD',
                ];
            } else {

                if ($paymentAmount > $gatewayInfo->max_deposit) {
                    return (object) [
                        "status"  => "error",
                        "message" => localize(
                            "The payment amount must be less than or equal to "
                        ) . $gatewayInfo->max_deposit . ' USD',
                    ];
                }

            }

        }

        if ($gatewayInfo->name == "CoinPayments") {
            $publicKey  = $gatewayInfo->credential->where('type', 'public_key')->first()->credentials;
            $privateKey = $gatewayInfo->credential->where('type', 'private_key')->first()->credentials;

            if (!$publicKey || !$privateKey) {
                return (object) [
                    "status"   => "error",
                    "message"  => localize("The payment method has been deactivated."),
                    "redirect" => false,
                ];
            }

            if ($oldRequest) {
                $responseData = json_decode($oldRequest->txn_data);

                return (object) ["status" => "success", "data" => $responseData, "redirect" => false];
            } else {
                $responseData = $this->coinPaymentService->createDepositTxn([
                    'amount'      => $paymentAmount,
                    'currency1'   => $fiatCurrency,
                    'currency2'   => $paymentCurrency,
                    'buyer_email' => $buyerEmail,
                    'ipn_url'     => route('coinpayment.ipn'),
                    'public_key'  => $publicKey,
                    'private_key' => $privateKey,
                ]);

                if ($responseData->status != "success") {
                    return $responseData;
                }

                $responseData->redirect = false;
                $paymentAmount          = $responseData->data['amount'];
            }

        } elseif ($gatewayInfo->name == "Stripe") {
            $publishableKey = $gatewayInfo->credential->where('type', 'publishable_key')->first()->credentials;
            $secretKey      = $gatewayInfo->credential->where('type', 'secret_key')->first()->credentials;

            if (!$publishableKey || !$secretKey) {
                return (object) [
                    "status"   => "error",
                    "message"  => localize("The payment method has been deactivated."),
                    "redirect" => false,
                ];
            }

            if ($oldRequest && !Carbon::parse($oldRequest->expired_at)->isPast()) {
                $stripeResponse = $this->stripeService->checkValidSession([
                    'secret_key' => $secretKey,
                    'session_id' => $oldRequest->txn_token,
                ]);

                if ($stripeResponse->status != "success") {
                    return $stripeResponse;
                }

                $responseData = json_decode($oldRequest->txn_data, true);

                return (object) ["status" => "success", "data" => $responseData, "redirect" => true];
            } else {

                $settingsInfo = $this->settingService->findById();

                $stripeResponse = $this->stripeService->createDepositTxn([
                    'currency'     => $paymentCurrency,
                    'amount'       => $paymentAmount,
                    'secret_key'   => $secretKey,
                    'success_url'  => route('stripe.success'),
                    'cancel_url'   => route('stripe.cancel'),
                    'company_logo' => $settingsInfo->logo ? storage_asset($settingsInfo->logo) : assets('img/logo.png'),
                ]);

                if ($stripeResponse->status != "success") {
                    return $stripeResponse;
                }

                $dateData  = Carbon::createFromTimestamp($stripeResponse->data->expires_at);
                $expiredAt = $dateData->format('Y-m-d H:i:s');

                $responseData = (object) [
                    'status'   => 'success',
                    'redirect' => true,
                    'data'     => (array) [
                        'txn_id'       => $stripeResponse->data->id,
                        'redirect_url' => $stripeResponse->data->url,
                        'expires_at'   => $expiredAt,
                    ],
                ];
            }

        }

        $fees = 0;

        if ($feesType == FeeSettingLevelEnum::MERCHANT->value) {
            $currencyInfo = $this->acceptCurrencyService->findCurrencyBySymbol($paymentCurrency);

            if ($currencyInfo) {
                $feesInfo = $this->merchantFeeService->findFeesByAcceptCurrency($currencyInfo->id);

                if ($feesInfo) {
                    $fees = $paymentAmount * ($feesInfo->percent / 100);
                }

            }

        } else {
            $feesInfo = $this->feeSettingService->findFeeByLevel($feesType);

            if ($feesInfo) {
                $fees = $paymentAmount * ($feesInfo->fee / 100);
            }

        }

        $addData = [
            "payment_gateway_id" => $paymentMethodId,
            "txn_type"           => $txnType,
            "txn_token"          => $responseData->data['txn_id'],
            "currency"           => $paymentCurrency,
            "txn_amount"         => $paymentAmount,
            "usd_value"          => $usdValue,
            "fees"               => $fees,
            "user"               => $userId,
            "txn_data"           => json_encode($responseData->data),
            "comment"            => $depositComments ?? null,
            "ip_address"         => $attributes['ipAddress'],
        ];

        if (isset($responseData->data['expires_at'])) {
            $addData['expired_at'] = $responseData->data['expires_at'];
        }

        $createResult = $this->paymentRequestService->create($addData);

        if ($createResult->status != "success") {
            return $createResult;
        }

        return $responseData;
    }

    /**
     * Create credit
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        return $this->createDeposit([
            'accept_currency_id' => $attributes['accept_currency_id'],
            'customer_id'        => $attributes['customer_id'],
            'b2x_loan_id'        => $attributes['b2x_loan_id'],
            'amount'             => $attributes['amount'],
            'method'             => $attributes['method'],
            'fees'               => 0,
            'status'             => $attributes['status'],
        ]);
    }

    public function createDeposit(array $attributes): ?object
    {
        $amount           = $attributes['amount'];
        $acceptCurrencyId = $attributes['accept_currency_id'];
        $userId           = $attributes['user_id'];

        $depositData = [
            'accept_currency_id' => $attributes['accept_currency_id'],
            'customer_id'        => $attributes['customer_id'],
            'b2x_loan_id'        => $attributes['b2x_loan_id'],
            'amount'             => $attributes['amount'],
            'method'             => $attributes['method'],
            'fees'               => 0,
            'status'             => $attributes['status'],
        ];

        $repaymentProcess = $this->b2xLoanRepayRepository->create($depositData);

        if ($repaymentProcess) {
            $this->walletTransactionLogService->create([
                'user_id'            => $userId,
                'accept_currency_id' => $acceptCurrencyId,
                'transaction'        => WalletManageLogEnum::REPAYMENT->value,
                'transaction_type'   => TransactionTypeEnum::CREDIT->value,
                'amount'             => $amount,
            ]);
        }

        return $repaymentProcess;
    }

    public function verifyTransaction(string $txnToken, Request $request = null): object
    {
        $paymentData = $this->paymentRequestService->findTxByToken($txnToken);

        if ($paymentData) {

            if ($paymentData->tx_status->value == PaymentRequestStatusEnum::PENDING->value) {
                $gatewayInfo = $this->paymentGatewayService->find($paymentData->payment_gateway_id);

                if (!$gatewayInfo) {
                    return (object) [
                        "status"  => "error",
                        "message" => localize("The payment method has been deactivated."),
                    ];
                }

                if ($gatewayInfo->name == "CoinPayments") {
                    $merchantId = $gatewayInfo->credential->where('type', 'merchant_id')->first()->credentials;
                    $ipnSecret  = $gatewayInfo->credential->where('type', 'ipn_secret')->first()->credentials;

                    if (!$merchantId || !$ipnSecret) {
                        return (object) [
                            "status"   => "error",
                            "message"  => localize("The payment method has been deactivated."),
                            "redirect" => false,
                        ];
                    }

                    $verifyPaymentData = $this->coinPaymentService->paymentVerify([
                        'merchant_id' => $merchantId,
                        'ipn_secret'  => $ipnSecret,
                        'orderAmount' => $paymentData->txn_amount,
                    ], $request);

                    if ($verifyPaymentData->status == "cancelled") {
                        $this->paymentCancel($txnToken);

                        return $verifyPaymentData;
                    }

                    if ($verifyPaymentData->status != "success") {
                        return $verifyPaymentData;
                    }

                    $paymentData->usd_amount = $verifyPaymentData->data['usd_value'];
                    $paymentData->method     = $verifyPaymentData->data['method'];

                    return (object) ['status' => 'success', 'data' => $paymentData];
                } elseif ($gatewayInfo->name == "Stripe") {
                    $publishableKey = $gatewayInfo->credential->where('type', 'publishable_key')->first()->credentials;
                    $secretKey      = $gatewayInfo->credential->where('type', 'secret_key')->first()->credentials;

                    if (!$publishableKey || !$secretKey) {
                        return (object) [
                            "status"   => "error",
                            "message"  => localize("The payment method has been deactivated."),
                            "redirect" => false,
                        ];
                    }

                    $verifySessionData = $this->stripeService->checkPaidSession([
                        "secret_key" => $secretKey,
                        "session_id" => $txnToken,
                    ]);

                    if ($verifySessionData->status != "success") {
                        return $verifySessionData;
                    }

                    return (object) ['status' => 'success', 'data' => $paymentData];
                } else {
                    return (object) [
                        'status'  => 'error',
                        'message' => localize('Something went wrong, please try again!'),
                    ];
                }

            } else {
                return (object) ['status' => 'error', 'message' => localize('Something went wrong, please try again!')];
            }

        } else {
            return (object) ['status' => 'error', 'message' => localize('Invalid Transaction')];
        }

    }

    public function paymentCancel(string $txnToken): bool
    {
        $paymentData = $this->paymentRequestService->findTxByToken($txnToken);

        if ($paymentData) {
            return $this->paymentRequestService->changePaymentStatus($paymentData->id, [
                'tx_status' => PaymentRequestStatusEnum::CANCEL->value,
            ]);
        } else {
            return false;
        }

    }

    public function makeSystemDeposit(object $attributes): object
    {
        $paymentRequestId = $attributes->id;
        $userId           = $attributes->user;
        $amount           = $attributes->txn_amount;
        $usdAmount        = $attributes->usd_amount;
        $loanId           = $attributes->txn_id;

        if ($amount <= 0 || $usdAmount <= 0) {
            return (object) ['status' => 'error', 'message' => localize('Something went wrong')];
        }

        $currencyInfo = $this->acceptCurrencyService->findCurrencyBySymbol($attributes->currency);
        $customerInfo = $this->customerService->findCustomerByUserId($userId);

        $checkLoan['loan_id']     = $loanId;
        $checkLoan['customer_id'] = $customerInfo->id;
        $loan                     = $this->b2xLoanService->checkLoan($checkLoan);

        if (!$currencyInfo) {
            return (object) ['status' => 'error', 'message' => 'Invalid Currency!'];
        }

        $walletCurrency = $this->acceptCurrencyService->findCurrencyBySymbol("BTC");

        $userWallet = $this->walletManageRepository->findDoubleWhereFirst(
            'user_id',
            $userId,
            'accept_currency_id',
            $walletCurrency->id
        );

        if (!$customerInfo) {
            return (object) ['status' => 'error', 'message' => localize('Invalid Customer Id')];
        }

        try {
            DB::beginTransaction();

            $this->createDeposit([
                'accept_currency_id' => $currencyInfo->id,
                'b2x_loan_id'        => $loanId,
                'customer_id'        => $customerInfo->id,
                'user_id'            => $userId,
                'amount'             => $amount,
                'fees'               => $attributes->fees,
                'method'             => $attributes->method,
                'status'             => B2xLoanRepaymentStatusEnum::SUCCESS->value,
            ]);
            $loanData = [
                'paid_installment'      => $loan->paid_installment + 1,
                'remaining_installment' => $loan->remaining_installment - 1,
            ];

            if ($loan->remaining_installment === "1.000000") {
                $loanData['status'] = B2xLoanStatusEnum::CLOSED->value;

                $walletData['balance']        = $loan->hold_btc_amount;
                $walletData['freeze_balance'] = $loan->hold_btc_amount;

                $this->walletManageService->freezeBalanceDeduct($walletData, $userWallet->id);

                $logData['user_id']            = $customerInfo->user_id;
                $logData['accept_currency_id'] = $currencyInfo->id;
                $logData['transaction']        = "Hold_BTC";
                $logData['transaction_type']   = "Credit";
                $logData['amount']             = $loan->hold_btc_amount;
                $this->transactionLogService->create($logData);
            }

            $this->b2xLoanService->repayLoanUpdate($loanId, $loanData);

            $this->paymentRequestService->changePaymentStatus($paymentRequestId, [
                'usd_value' => $usdAmount,
                'tx_status' => PaymentRequestStatusEnum::SUCCESS->value,
            ]);

            $this->notificationService->create([
                'customer_id'       => $customerInfo->id,
                'notification_type' => 'repayment',
                'subject'           => 'Repayment',
                'details'           => 'Your repayment of ' . $amount . ' ' . $attributes->currency . ' has been successfully processed.',
            ]);

            DB::commit();

            return (object) ['status' => 'success'];
        } catch (Exception $exception) {
            DB::rollBack();

            return (object) ['status' => 'error', 'message' => $exception->getMessage()];
        }

    }

}
