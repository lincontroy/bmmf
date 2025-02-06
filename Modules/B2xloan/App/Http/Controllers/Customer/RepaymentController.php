<?php

namespace Modules\B2xloan\App\Http\Controllers\Customer;

use App\Enums\FeeSettingLevelEnum;
use App\Enums\PaymentRequestEnum;
use App\Http\Controllers\Controller;
use App\Services\AcceptCurrencyService;
use App\Services\PaymentGatewayService;
use App\Services\PaymentRequestService;
use App\Traits\ResponseTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\B2xloan\App\DataTables\Customer\LoansRepaymentDataTable;
use Modules\B2xloan\App\Http\Requests\RepaymentRequest;
use Modules\B2xloan\App\Services\B2xLoanService;
use Modules\Finance\App\Services\DepositService;

class RepaymentController extends Controller
{

    use ResponseTrait;

    public function __construct(
        private PaymentGatewayService $paymentGatewayService,
        private AcceptCurrencyService $acceptCurrencyService,
        private PaymentRequestService $paymentRequestService,
        private DepositService $depositService,
        private B2xLoanService $b2xLoanService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(LoansRepaymentDataTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Repayment List'),
            'description' => localize('Repayment List'),
        ]);

        return $dataTable->render('b2xloan::customer.repayment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        cs_set('theme', [
            'title'       => 'Deposit',
            'description' => 'Deposit',
        ]);

        $data['gatewayData'] = $this->paymentGatewayService->findGateway();

        return view('b2xloan::customer.repayment.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RepaymentRequest $request): RedirectResponse
    {
        $attributes['loan_id']     = Session::get('loan_id');
        $attributes['customer_id'] = Auth::id();
        $loan                      = $this->b2xLoanService->checkLoan($attributes);

        $validateData                    = $request->validated();
        $data['ipAddress']               = $request->ip();
        $data['payment_method']          = $validateData['payment_method'];
        $data['payment_currency']        = $validateData['payment_currency'];
        $data['deposit_amount']          = $loan->installment_amount;
        $data['deposit_comments']        = $validateData['deposit_comments'];
        $data['txn_type']                = PaymentRequestEnum::REPAYMENT->value;
        $data['fees_type']               = FeeSettingLevelEnum::MERCHANT->value;
        $data['txn_id']                  = Session::get('loan_id');
        $data['coinPayment_callback']    = route('customer.repayment.coinpayment.ipn');
        $data['stripe_success_callback'] = route('customer.repayment_stripe_success');
        $data['stripe_cancel_callback']  = route('customer.repayment_stripe_cancel');

        $repaymentData = $this->depositService->makeDeposit($data);

        if ($repaymentData->status != "success") {
            return back()->withInput()->withErrors($repaymentData->message);
        }

        if ($repaymentData->redirect) {
            return redirect()->away($repaymentData->data['redirect_url']);
        } else {
            if (session()->has('deposit')) {
                session()->forget(['deposit', 'depositData']);
            }

            $objDepositData           = (object)$repaymentData->data;
            $objDepositData->currency = $data['payment_currency'];
            session()->put([
                'deposit'     => 1,
                'depositData' => $objDepositData,
            ]);

            return redirect()->route('customer.repayment.process');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(int $id)
    {
        cs_set('theme', [
            'title'       => localize('repayment'),
            'description' => localize('repayment'),
        ]);

        $attributes['loan_id']     = $id;
        $attributes['customer_id'] = Auth::id();

        session()->put([
            'loan_id' => $id,
        ]);

        $gatewayData = $this->paymentGatewayService->findGateway();
        $loan        = $this->b2xLoanService->checkLoan($attributes);

        if (!$loan) {
            return redirect()->route('customer.b2x_loan_list')->with(
                'exception',
                localize('Something went wrong, please try again!')
            );
        }

        return view('b2xloan::customer.repayment.create', compact('gatewayData', 'loan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('finance::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function payment()
    {
        if (!session()->has('deposit')) {
            return redirect()->route('customer.b2x_loan_list')->with('error', localize('There was an error with your deposit.'));
        }

        cs_set('theme', [
            'title'       => localize('Repayment Process'),
            'description' => localize('Repayment Process'),
        ]);

        $data['depositData'] = session('depositData');

        return view('b2xloan::customer.repayment.process', $data);
    }

}