<?php

namespace Modules\B2xloan\App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Services\PaymentRequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Modules\B2xloan\App\Services\RepaymentService;

class RepaymentCallBackController extends Controller
{
    public function __construct(
        private PaymentRequestService $paymentRequestService,
        private RepaymentService $repaymentService,
    ) {
    }

    /**
     * Payment call stripe payment success
     * @param Request $request
     * @return RedirectResponse
     */
    public function stripeConfirm(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'session_id' => 'required|max:255|string|' . Rule::exists(PaymentRequest::class, 'txn_token'),
        ]);

        $sessionId = $validatedData['session_id'];

        $depositResult = $this->repaymentService->verifyTransaction($sessionId);

        if ($depositResult->status != "success") {
            $loanId = Session::get('loan_id');

            return redirect()->route('customer.repayment.show', [$loanId])->with('exception', $depositResult->message);
        }

        $depositResult->data['usd_amount'] = $depositResult->data['txn_amount'];
        $depositResult->data['method']     = 'Stripe';

        $systemDepositData = $this->repaymentService->makeSystemDeposit((object)$depositResult->data);

        Session::forget('loan_id');

        if ($systemDepositData->status == "success") {
            return redirect()->route('customer.repayment.index')->with(
                'success',
                localize('Payment Successfully Done')
            );
        } else {
            return redirect()->route('customer.b2x_loan_list')->with('exception', $systemDepositData->message);
        }
    }

    /**
     * Payment call back stripe cancel
     * @param Request $request
     * @return RedirectResponse
     */
    public function stripeCancel(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'session_id' => 'required|max:255|string|' . Rule::exists(PaymentRequest::class, 'txn_token'),
        ]);

        $sessionId = $validatedData['session_id'];
        $loanId    = Session::get('loan_id');

        $depositResult = $this->repaymentService->paymentCancel($sessionId);

        Session::forget('loan_id');

        if ($depositResult) {
            return redirect()->route('customer.repayment.show', [$loanId])->with(
                'exception',
                localize('Payment Cancelled Successfully')
            );
        } else {
            return redirect()->route('customer.repayment.show', [$loanId])->with(
                'exception',
                localize('Something went wrong')
            );
        }
    }

    public function coinPaymentConfirm(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'txn_id' => 'required|max:255|string|' . Rule::exists(PaymentRequest::class, 'txn_token'),
            ]);

            $txnID         = $validatedData['txn_id'];
            $depositResult = $this->repaymentService->verifyTransaction($txnID, $request);

            if ($depositResult->status != "success") {
                return response()->json($depositResult);
            }

            $systemDepositData = $this->repaymentService->makeSystemDeposit((object)$depositResult->data);

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
