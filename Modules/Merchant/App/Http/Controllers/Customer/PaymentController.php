<?php

namespace Modules\Merchant\App\Http\Controllers\Customer;

use App\Enums\FeeSettingLevelEnum;
use App\Enums\PaymentRequestEnum;
use App\Enums\PaymentRequestStatusEnum;
use App\Http\Controllers\Controller;
use App\Services\AcceptCurrencyService;
use App\Services\PaymentGatewayService;
use App\Services\PaymentRequestService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Finance\App\Services\DepositService;
use Modules\Merchant\App\Http\Requests\PaymentPayCryptoCurrencyRequest;
use Modules\Merchant\App\Http\Requests\PaymentProcessCustomerRequest;
use Modules\Merchant\App\Services\MerchantCustomerInfoService;
use Modules\Merchant\App\Services\MerchantPaymentInfoService;
use Modules\Merchant\App\Services\MerchantPaymentTransactionService;
use Modules\Merchant\App\Services\MerchantPaymentUrlService;
use Modules\Merchant\App\Services\PaymentProcessCustomerService;

class PaymentController extends Controller
{
    /**
     * PaymentController of construct
     *
     * @param MerchantPaymentUrlService $merchantPaymentUrlService
     * @param MerchantCustomerInfoService $merchantCustomerInfoService
     * @param PaymentProcessCustomerService $paymentProcessCustomerService
     * @param AcceptCurrencyService $acceptCurrencyService
     * @param PaymentGatewayService $paymentGatewayService
     * @param DepositService $depositService
     * @param MerchantPaymentTransactionService $merchantPaymentTransactionService
     * @param MerchantPaymentInfoService $merchantPaymentInfoService
     */
    public function __construct(
        protected MerchantPaymentUrlService $merchantPaymentUrlService,
        protected MerchantCustomerInfoService $merchantCustomerInfoService,
        protected PaymentProcessCustomerService $paymentProcessCustomerService,
        protected AcceptCurrencyService $acceptCurrencyService,
        protected PaymentGatewayService $paymentGatewayService,
        protected DepositService $depositService,
        protected MerchantPaymentTransactionService $merchantPaymentTransactionService,
        protected MerchantPaymentInfoService $merchantPaymentInfoService,
        protected PaymentRequestService $paymentRequestService,
    ) {

    }

    /**
     * Display a listing of the resource.
     * @param int $int
     * @return View|RedirectResponse
     */
    public function index(string $uu_id): View | RedirectResponse
    {
        cs_set('theme', [
            'title'       => localize('Payment'),
            'description' => localize('Payment'),
        ]);

        $merchantPaymentUrl = $this->merchantPaymentUrlService->findByUuidWithCurrency($uu_id);

        if ($merchantPaymentUrl->duration->isPast()) {
            warning_message('Payment Url is expired');
            return redirect()->route('payment.expired', ['payment_url' => $uu_id]);
        }

        $paymentRequest = $this->paymentRequestService->findByAttributes([
            'merchant_payment_url_id' => $merchantPaymentUrl->id,
            'txn_type'                => PaymentRequestEnum::MERCHANT->value,
            'tx_status'               => PaymentRequestStatusEnum::SUCCESS->value,
        ]);

        // dd($paymentRequest);

        return view('merchant::payment.customer', compact('merchantPaymentUrl'));
    }

    /**
     * Display a listing of the resource.
     * @param int $int
     * @return View|RedirectResponse
     */
    public function paymentUrlExpired(string $uu_id): View | RedirectResponse
    {
        cs_set('theme', [
            'title'       => localize('Expired Payment'),
            'description' => localize('Expired Payment'),
        ]);

        $merchantPaymentUrl = $this->merchantPaymentUrlService->findByUuidWithCurrency($uu_id);

        if (!$merchantPaymentUrl->duration->isPast()) {
            warning_message('Payment Url is not expired yet');
            return redirect()->route('payment.index', ['payment_url' => $uu_id]);
        }

        return view('merchant::payment.expired-payment-url', compact('merchantPaymentUrl'));
    }

    /**
     * Process Customer
     *
     * @param PaymentProcessCustomerRequest $request
     * @return JsonResponse
     */
    public function processCustomer(PaymentProcessCustomerRequest $request, string $uu_id)
    {
        $data = $request->validated();

        $merchantPaymentUrl   = $this->merchantPaymentUrlService->findByUuidWithCurrency($uu_id);
        $merchantCustomerInfo = $this->merchantCustomerInfoService->findByAttributes([
            'merchant_account_id' => $merchantPaymentUrl->merchant_account_id,
            'email'               => $data['email'],
        ]);

        /**
         * Check Merchant info
         */

        if ($merchantCustomerInfo) {
            $crypto_currency_page = view('merchant::payment.crypto-currency', compact('merchantPaymentUrl', 'merchantCustomerInfo'))->render();

            return response()->json([
                'success' => true,
                'message' => localize("Customer found successfully"),
                'title'   => localize("Customer"),
                'data'    => $crypto_currency_page,
            ]);
        }

        /**
         * If not found merchant information and first name or last name is empty
         */

        if (!$merchantCustomerInfo && (!isset($data['first_name']) || !isset($data['last_name']))) {
            return response()->json([
                'success' => false,
                'message' => localize("Customer not found"),
                'title'   => localize("Customer"),
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $merchantCustomerInfo = $this->merchantCustomerInfoService->createFromCustomer([
            'merchant_account_id' => $merchantPaymentUrl->merchant_account_id,
            'email'               => $data['email'],
            'first_name'          => $data['first_name'],
            'last_name'           => $data['last_name'],
        ]);

        $crypto_currency_page = view('merchant::payment.crypto-currency', compact('merchantPaymentUrl', 'merchantCustomerInfo'))->render();

        return response()->json([
            'success' => true,
            'message' => localize("Customer create successfully"),
            'title'   => localize("Customer"),
            'data'    => $crypto_currency_page,
        ]);

    }

    /**
     * Pay Crypto Currency
     *
     * @param PaymentPayCryptoCurrencyRequest $request
     * @return JsonResponse
     */
    public function payCryptoCurrency(PaymentPayCryptoCurrencyRequest $request, string $merchant_payment_uu_id, string $customer_info_uuid)
    {
        $data = $request->validated();


        $accept_currency_id = $data['accept_currency_id'];

        $merchantPaymentUrl   = $this->merchantPaymentUrlService->findByUuidWithMerchantAcceptCoin($merchant_payment_uu_id, $accept_currency_id);
        $merchantCustomerInfo = $this->merchantCustomerInfoService->findByUuidWithMerchantAccount($customer_info_uuid);
        $acceptCurrency       = $this->acceptCurrencyService->find($accept_currency_id);

        /**
         * Check Accept Currency
         */

        if (!$acceptCurrency) {
            error_message(localize("Accept Currency not found!"));
            return back()->withInput();
        }

        /**
         * Check Accept Currency Symbol
         */

        if ($acceptCurrency->symbol == 'USD') {
            $paymentGateway = $this->paymentGatewayService->findByAttributes(['name' => 'Stripe']);
        } else {
            $paymentGateway = $this->paymentGatewayService->findByAttributes(['name' => 'CoinPayments']);
        }

        $validateData                            = [];
        $validateData['txn_id']                  = $merchantPaymentUrl->uu_id;
        $validateData['buyerEmail']              = $merchantCustomerInfo->email;
        $validateData['user']                    = $merchantCustomerInfo->id;
        $validateData['payment_method']          = $paymentGateway->id;
        $validateData['payment_currency']        = $acceptCurrency->symbol;
        $validateData['deposit_amount']          = $merchantPaymentUrl->amount;
        $validateData['deposit_comments']        = null;
        $validateData['ipAddress']               = $request->ip();
        $validateData['txn_type']                = PaymentRequestEnum::MERCHANT->value;
        $validateData['fees_type']               = FeeSettingLevelEnum::MERCHANT->value;
        $validateData['coinPayment_callback']    = route('customer.payment.coinpayment.ipn');
        $validateData['stripe_success_callback'] = route('customer.payment.stripe.success');
        $validateData['stripe_cancel_callback']  = route('customer.payment.stripe.cancel');

        $depositData = $this->depositService->makeDeposit($validateData);


        if ($depositData->status != "success") {
            error_message($depositData->message);
            return redirect()->back();
        }

        $merchantPaymentTransaction = $this->merchantPaymentTransactionService->create([
            'payment_gateway_id' => $paymentGateway->id,
            'transaction_hash'   => $depositData->data['txn_id'], // Transaction hash comes form payment gateway
            'amount'             => $merchantPaymentUrl->amount,
            'data'               => $depositData->data,
        ]);

        if ($merchantPaymentTransaction->status == "success") {

            $merchantPaymentInfo = $this->merchantPaymentInfoService->create([
                'merchant_account_id'             => $merchantPaymentUrl->merchant_account_id,
                'merchant_customer_info_id'       => $merchantCustomerInfo->id,
                'merchant_accepted_coin_id'       => $merchantPaymentUrl->merchantAcceptedCoin->id,
                'payment_gateway_id'              => $paymentGateway->id,
                'merchant_payment_transaction_id' => $merchantPaymentTransaction->data->id,
                'amount'                          => $merchantPaymentUrl->amount,
                'received_amount'                 => 0,
            ]);
        }

        if ($depositData->redirect) {
            return redirect()->away($depositData->data['redirect_url']);
        } else {

            if (session()->has('deposit')) {
                session()->forget(['deposit', 'depositData']);
            }

            $objDepositData           = (object) $depositData->data;
            $objDepositData->currency = $validateData['payment_currency'];
            session()->put([
                'deposit'     => 1,
                'depositData' => $objDepositData,
            ]);

            return redirect()->route('customer.payment.deposit.process', ['payment_url' => $merchant_payment_uu_id]);
        }

    }

    /**
     * Payment Deposit Process
     *
     * @param string $payment_uu_id
     * @return view|RedirectResponse
     */
    public function paymentDepositProcess(string $payment_uu_id): view | RedirectResponse
    {

        if (!session()->has('deposit')) {
            return redirect()->route('payment.index', ['payment_url' => $payment_uu_id])->with('error', 'There was an error with your deposit.');
        }

        cs_set('theme', [
            'title'       => localize('Payment Deposit Process'),
            'description' => localize('Payment Deposit Process'),
        ]);

        $depositData = session('depositData');

        $merchantPaymentUrl = $this->merchantPaymentUrlService->findByUuidWithCurrency($payment_uu_id);
        $paymentRequest     = $this->paymentRequestService->findByAttributes(['txn_token' => $depositData->txn_id]);

        $expired_time = Carbon::parse($paymentRequest->created_at)->addSeconds($depositData->timeout)->format('d M Y H:i:s T');
        $timezone     = config('app.timezone');

        return view('merchant::payment.deposit-process', compact('depositData', 'merchantPaymentUrl', 'paymentRequest', 'expired_time', 'timezone'));

    }

    /**
     *  Payment Deposit Confirm
     * @param int $int
     * @return View
     */
    public function paymentDepositConfirm(string $uu_id): View
    {
        cs_set('theme', [
            'title'       => localize('Payment Confirm'),
            'description' => localize('Payment Confirm'),
        ]);

        $merchantPaymentUrl = $this->merchantPaymentUrlService->findByUuidWithCurrency($uu_id);


        return view('merchant::payment.deposit-confirm', compact('merchantPaymentUrl'));
    }

}
