<?php

namespace App\Http\Controllers\CallBack;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Services\PaymentRequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Modules\Finance\App\Services\DepositService;

class DepositPaymentCallBackController extends Controller
{
    public function __construct(
        private DepositService $depositService,
        private PaymentRequestService $paymentRequestService
    ) {

    }

    /**
     * Payment call stripe payment success
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stripeConfirm(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'session_id' => 'required|max:255|string|' . Rule::exists(PaymentRequest::class, 'txn_token'),
        ]);

        $sessionId = $validatedData['session_id'];

        $depositResult = $this->depositService->verifyTransaction($sessionId);

        if ($depositResult->status != "success") {

            return redirect()->route('customer.deposit.create')->with('exception', $depositResult->message);
        }

        $depositResult->data['usd_amount'] = $depositResult->data['txn_amount'];
        $depositResult->data['method']     = 'Stripe';

        $systemDepositData = $this->depositService->makeSystemDeposit((object) $depositResult->data);

        if ($systemDepositData->status == "success") {
            return redirect()->route('customer.deposit.create')->with('success', localize('Deposited Successfully'));
        } else {
            return redirect()->route('customer.deposit.create')->with('exception', $systemDepositData->message);
        }

    }

    /**
     * Payment call back stripe cancel
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stripeCancel(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'session_id' => 'required|max:255|string|' . Rule::exists(PaymentRequest::class, 'txn_token'),
        ]);

        $sessionId = $validatedData['session_id'];

        $depositResult = $this->depositService->paymentCancel($sessionId);

        if ($depositResult) {
            return redirect()->route('customer.deposit.create')->with('exception', localize('Deposited Cancelled Successfully'));
        } else {
            return redirect()->route('customer.deposit.create')->with('exception', localize('Something went wrong'));
        }

    }

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

            $systemDepositData = $this->depositService->makeSystemDeposit((object) $depositResult->data);

            return response()->json($systemDepositData);

        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => localize('Validation failed'),
                'errors'  => $e->validator->errors()->all(),
            ]);
        }

    }

}
