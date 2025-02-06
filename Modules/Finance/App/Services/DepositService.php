<?php

namespace Modules\Finance\App\Services;

use App\Enums\FeeSettingLevelEnum;
use App\Enums\PaymentRequestStatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Enums\TxnTypeEnum;
use App\Enums\WalletManageLogEnum;
use App\Services\AcceptCurrencyService;
use App\Services\CoinPaymentService;
use App\Services\Customer\CustomerService;
use App\Services\FeeSettingService;
use App\Services\NotificationService;
use App\Services\PaymentGatewayService;
use App\Services\PaymentRequestService;
use App\Services\SettingService;
use App\Services\StripeService;
use Illuminate\Support\Str;
use App\Services\TxnFeeReportService;
use App\Services\TxnReportService;
use App\Services\WalletManageService;
use App\Services\WalletTransactionLogService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Finance\App\Enums\DepositEnum;
use Modules\Finance\App\Repositories\Interfaces\DepositRepositoryInterface;
use Modules\Merchant\App\Services\MerchantFeeService;

class DepositService
{
    /**
     * DepositService constructor.
     *
     * @param DepositRepositoryInterface $depositRepository
     * @param WalletTransactionLogService $walletTransactionLogService
     */
    public function __construct(
        private DepositRepositoryInterface $depositRepository,
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
            'user_id'            => $attributes['user_id'],
            'customer_id'        => $attributes['customer_id'],
            'amount'             => $attributes['amount'],
            'fees'               => 0,
            'comment'            => $attributes['note'],
        ]);
    }

    public function createDeposit(array $attributes): ?object
    {

        // dd($attributes);
        $amount           = $attributes['amount'];
        $acceptCurrencyId = $attributes['accept_currency_id'];
        $userId           = $attributes['user_id'];

        $depositData = [
            'customer_id'        => $attributes['customer_id'],
            'accept_currency_id' => $acceptCurrencyId,
            'user_id'            => $userId,
            'amount'             => $amount,
            'method'             => $attributes['method'] ?? 'Credited',
            'fees'               => $attributes['fees'],
            'comments'           => $attributes['comment'],
            'date'               => Carbon::now(),
            'status'             => DepositEnum::CONFIRM->value,
        ];

        $createDeposit = $this->depositRepository->create($depositData);

        if ($createDeposit) {

            if (isset($attributes['method'])) {
                $newArray = [
                    'deposit'     => $amount,
                    'deposit_fee' => $attributes['fees'],
                ];
                $walletLogTransaction = WalletManageLogEnum::DEPOSIT->value;
            } else {
                $newArray = [
                    'credited' => $amount,
                ];
                $walletLogTransaction = WalletManageLogEnum::CREDITED->value;
            }

            $balance = $amount;

            if ($attributes['fees'] > 0) {
                $balance = $balance - $attributes['fees'];
            }

            $walletManage = $this->walletManageService->create([
                'accept_currency_id' => $acceptCurrencyId,
                'user_id'            => $userId,
                'balance'            => $balance,
                ...$newArray,
            ]);

            if ($walletManage) {
                $this->walletTransactionLogService->create([
                    'user_id'            => $userId,
                    'accept_currency_id' => $acceptCurrencyId,
                    'transaction'        => $walletLogTransaction,
                    'transaction_type'   => TransactionTypeEnum::CREDIT->value,
                    'amount'             => $balance,
                ]);
            }

        } else {
            return null;
        }

        return $createDeposit;
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

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Deposit update error"),
                'title'   => localize('Deposit'),
                'errors'  => $exception,
            ], 422));
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

        if (isset($attributes['buyerEmail'])) {
            $buyerEmail = $attributes['buyerEmail'];
        } else {
            $buyerEmail = auth()->user()->email;
        }

        if (isset($attributes['user'])) {
            $userId = $attributes['user'];
        } else {
            $userId = auth()->user()->user_id;
        }

        $usdValue = $paymentAmount;

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
                return (object) ["status" => "error", "message" => localize("The payment amount must be grater than or equal to ") . $gatewayInfo->min_deposit . ' USD'];
            } else

            if ($paymentAmount > $gatewayInfo->max_deposit) {
                return (object) ["status" => "error", "message" => localize("The payment amount must be less than or equal to ") . $gatewayInfo->max_deposit . ' USD'];
            }

        }

        if ($gatewayInfo->name == "CoinPayments") {
            $publicKey  = $gatewayInfo->credential->where('type', 'public_key')->first()->credentials;
            $privateKey = $gatewayInfo->credential->where('type', 'private_key')->first()->credentials;

            if (!$publicKey || !$privateKey) {
                return (object) ["status" => "error", "message" => localize("The payment method has been deactivated."), "redirect" => false];
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
                    'ipn_url'     => $attributes['coinPayment_callback'],
                    'public_key'  => $publicKey,
                    'private_key' => $privateKey,
                ]);

                // if ($responseData->status != "success") {
                //     return $responseData;
                // }

                $responseData->redirect = false;
                $paymentAmount          = $paymentAmount;
            }

        } elseif ($gatewayInfo->name == "Stripe") {

            $publishableKey = $gatewayInfo->credential->where('type', 'publishable_key')->first()->credentials;
            $secretKey      = $gatewayInfo->credential->where('type', 'secret_key')->first()->credentials;

            if (!$publishableKey || !$secretKey) {
                return (object) ["status" => "error", "message" => localize("The payment method has been deactivated."), "redirect" => false];
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
                    'success_url'  => $attributes['stripe_success_callback'],
                    'cancel_url'   => $attributes['stripe_cancel_callback'],
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
            "txn_token"          => Str::random(16),
            "currency"           => $paymentCurrency,
            "txn_amount"         => $paymentAmount,
            "usd_value"          => $usdValue,
            "fees"               => $fees,
            "user"               => $userId,
            "txn_data"           => json_encode($paymentMethodId),
            "comment"            => $depositComments ?? null,
            "ip_address"         => $attributes['ipAddress'],
        ];

        if (isset($responseData->data['expires_at'])) {
            $addData['expired_at'] = $responseData->data['expires_at'];
        }

        if (isset($attributes['txn_id'])) {
            $addData['txn_id'] = $attributes['txn_id'];
        }

        if (isset($attributes['merchant_payment_url_id'])) {
            $addData['merchant_payment_url_id'] = $attributes['merchant_payment_url_id'];
        }

        $createResult = $this->paymentRequestService->create($addData);

        if ($createResult->status != "success") {
            return $createResult;
        }

        return $responseData;
    }

    public function verifyTransaction(string $txnToken, Request $request = null): object
    {
        $paymentData = $this->paymentRequestService->findTxByToken($txnToken);

        if ($paymentData) {

            if ($paymentData->tx_status->value == PaymentRequestStatusEnum::PENDING->value) {
                $gatewayInfo = $this->paymentGatewayService->find($paymentData->payment_gateway_id);

                if (!$gatewayInfo) {
                    return (object) ["status" => "error", "message" => localize("The payment method has been deactivated.")];
                }

                if ($gatewayInfo->name == "CoinPayments") {

                    $merchantId = $gatewayInfo->credential->where('type', 'merchant_id')->first()->credentials;
                    $ipnSecret  = $gatewayInfo->credential->where('type', 'ipn_secret')->first()->credentials;

                    if (!$merchantId || !$ipnSecret) {
                        return (object) ["status" => "error", "message" => localize("The payment method has been deactivated."), "redirect" => false];
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
                        return (object) ["status" => "error", "message" => localize("The payment method has been deactivated."), "redirect" => false];
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
                    return (object) ['status' => 'error', 'message' => localize('Something went wrong, please try again!')];
                }

            } else {
                return (object) ['status' => 'error', 'message' => localize('Something went wrong, please try again!')];
            }

        } else {
            return (object) ['status' => 'error', 'message' => localize('Invalid Transaction')];
        }

    }

    public function makeSystemDeposit(object $attributes): object
    {
        $paymentRequestId = $attributes->id;
        $userId           = $attributes->user;
        $amount           = $attributes->txn_amount;
        $usdAmount        = $attributes->usd_amount;

        if ($amount <= 0 || $usdAmount <= 0) {
            return (object) ['status' => 'error', 'message' => localize('Something went wrong')];
        }

        $currencyInfo = $this->acceptCurrencyService->findCurrencyBySymbol($attributes->currency);

        if (!$currencyInfo) {
            return (object) ['status' => 'error', 'message' => localize('Invalid Currency!')];
        }

        $customerInfo = $this->customerService->findCustomerByUserId($userId);

        if (!$customerInfo) {
            return (object) ['status' => 'error', 'message' => localize('Invalid Customer Id')];
        }

        try {
            DB::beginTransaction();

            $this->createDeposit([
                'accept_currency_id' => $currencyInfo->id,
                'user_id'            => $userId,
                'customer_id'        => $customerInfo->id,
                'method'             => $attributes->method,
                'amount'             => $amount,
                'fees'               => $attributes->fees,
                'comment'            => $attributes->comment,
            ]);

            $this->paymentRequestService->changePaymentStatus($paymentRequestId, [
                'usd_value' => $usdAmount,
                'tx_status' => PaymentRequestStatusEnum::SUCCESS->value,
            ]);

            $this->txnReportService->create([
                'customer_id'        => $customerInfo->id,
                'accept_currency_id' => $currencyInfo->id,
                'txn_type'           => TxnTypeEnum::DEPOSIT->value,
                'amount'             => $amount,
                'usd_value'          => $usdAmount,
            ]);

            if ($attributes->fees > 0) {
                $currencyUsdRate = $usdAmount / $amount;
                $feesUsdValue    = number_format($currencyUsdRate * $attributes->fees, 2, '.', '');
                $this->txnFeeService->create([
                    'customer_id'        => $customerInfo->id,
                    'accept_currency_id' => $currencyInfo->id,
                    'txn_type'           => TxnTypeEnum::DEPOSIT->value,
                    'fee_amount'         => $attributes->fees,
                    'usd_value'          => $feesUsdValue,
                ]);
            }

            $this->notificationService->create([
                'customer_id'       => $customerInfo->id,
                'notification_type' => 'deposit',
                'subject'           => 'Deposit',
                'details'           => 'Your deposit of ' . $amount . ' ' . $attributes->currency . ' has been successfully processed.',
            ]);

            DB::commit();

            return (object) ['status' => 'success'];

        } catch (Exception $exception) {

            DB::rollBack();

            return (object) ['status' => 'error', 'message' => $exception->getMessage()];
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

}
