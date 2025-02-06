<?php

namespace Modules\Merchant\App\Http\Controllers\Customer\Callback;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Services\PaymentRequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Modules\Finance\App\Services\DepositService;
use Modules\Merchant\App\Services\MerchantPaymentInfoService;
use Modules\Merchant\App\Services\MerchantPaymentTransactionService;
use Modules\Merchant\App\Services\MerchantPaymentUrlService;
use Modules\Merchant\App\Services\PaymentDepositCallBackService;

class PaymentDepositCallBackController extends Controller
{
    /**
     * PaymentDepositCallBackController of construct
     *
     * @param DepositService $depositService
     * @param PaymentRequestService $paymentRequestService
     * @param MerchantPaymentTransactionService $merchantPaymentTransactionService
     * @param MerchantPaymentInfoService $merchantPaymentInfoService
     * @param PaymentDepositCallBackService $paymentDepositCallBackService
     */
    public function __construct(
        private DepositService $depositService,
        private PaymentRequestService $paymentRequestService,
        protected MerchantPaymentTransactionService $merchantPaymentTransactionService,
        protected MerchantPaymentInfoService $merchantPaymentInfoService,
        protected PaymentDepositCallBackService $paymentDepositCallBackService,
        protected MerchantPaymentUrlService $merchantPaymentUrlService,
    ) {

    }

    /**
     * Strip Confirm
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stripeConfirm(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'session_id' => 'required|max:255|string|' . Rule::exists(PaymentRequest::class, 'txn_token'),
        ]);

        $sessionId = $validatedData['session_id'];

        $depositResult      = $this->depositService->verifyTransaction($sessionId);
        $merchantPaymentUrl = $this->merchantPaymentUrlService->findByUuidWithCurrency($depositResult->data->txn_id);

        if ($depositResult->status != "success") {
            success_message($depositResult->message);
            return redirect()->route('payment.index', ['payment_url' => $merchantPaymentUrl->uu_id]);
        }

        $depositResult->data['usd_amount'] = $depositResult->data['txn_amount'];
        $depositResult->data['method']     = 'Stripe';

        $checkPaymentComplete = $this->paymentDepositCallBackService->updateStatusByPaymentComplete($depositResult->data);

        if ($checkPaymentComplete) {
            success_message(localize('Payment Successfully'));
            return redirect()->route('customer.payment.deposit.confirm', ['payment_url' => $merchantPaymentUrl->uu_id]);
        } else {
            warning_message(localize('Customer Payment Failed'));
            return redirect()->route('customer.payment.deposit.confirm', ['payment_url' => $merchantPaymentUrl->uu_id]);
        }

    }

    /**
     * Stripe Cancel
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stripeCancel(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'session_id' => 'required|max:255|string|' . Rule::exists(PaymentRequest::class, 'txn_token'),
        ]);

        $sessionId = $validatedData['session_id'];

        $paymentRequest     = $this->paymentRequestService->findByAttributes(['txn_token' => $sessionId]);
        $depositResult      = $this->depositService->paymentCancel($sessionId);
        $merchantPaymentUrl = $this->merchantPaymentUrlService->findByUuidWithCurrency($paymentRequest->txn_id);

        if ($depositResult) {
            $this->paymentDepositCallBackService->updateStatusByPaymentCancel($sessionId);
            warning_message(localize('Deposited Cancelled Successfully'));
            return redirect()->route('customer.payment.deposit.confirm', ['payment_url' => $merchantPaymentUrl->uu_id]);

        } else {
            warning_message(localize('Something went wrong'));
            return redirect()->route('customer.payment.deposit.confirm', ['payment_url' => $merchantPaymentUrl->uu_id]);
        }

    }

    /**
     * Coin Payment Confirm
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function coinPaymentConfirm(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'txn_id' => 'required|max:255|string|' . Rule::exists(PaymentRequest::class, 'txn_token'),
            ]);

            $txnID         = $validatedData['txn_id'];
            $depositResult = $this->depositService->verifyTransaction($txnID, $request);

            if ($depositResult->status != "success") {
                return response()->json($depositResult);
            }

            $checkPaymentComplete = $this->paymentDepositCallBackService->updateStatusByPaymentComplete($depositResult->data);

            return response()->json($checkPaymentComplete);

        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $e->validator->errors()->all(),
            ]);
        }

    }

}
