<?php

namespace Modules\Finance\App\Http\Controllers\Customer;

use App\Enums\FeeSettingLevelEnum;
use App\Enums\PaymentRequestEnum;
use App\Http\Controllers\Controller;
use App\Services\AcceptCurrencyService;
use App\Services\PaymentGatewayService;
use App\Services\PaymentRequestService;
use App\Traits\ResponseTrait;
use Auth;
use Modules\Finance\App\Models\Deposit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Finance\App\DataTables\Customer\DepositsDataTable;
use Modules\Finance\App\Http\Requests\DepositRequest;
use Modules\Finance\App\Services\DepositService;

class DepositController extends Controller
{

    use ResponseTrait;

    public function __construct(
        private PaymentGatewayService $paymentGatewayService,
        private AcceptCurrencyService $acceptCurrencyService,
        private PaymentRequestService $paymentRequestService,
        private DepositService $depositService
    ) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(DepositsDataTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Deposit List'),
            'description' => localize('Deposit List'),
        ]);

        return $dataTable->render('finance::customer.deposit.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // exit;
        cs_set('theme', [
            'title'       => localize('Deposit'),
            'description' => localize('Deposit'),
        ]);

        $data['gatewayData'] = $this->paymentGatewayService->findGateway();

        return view('finance::customer.deposit.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepositRequest $request): RedirectResponse
    {

        // dd($request);
        // exit;
        $validateData                            = $request->validated();
        $validateData['ipAddress']               = $request->ip();
        $validateData['txn_type']                = PaymentRequestEnum::DEPOSIT->value;
        $validateData['fees_type']               = FeeSettingLevelEnum::DEPOSIT->value;
        $validateData['coinPayment_callback']    = route('coinpayment.ipn');
        $validateData['stripe_success_callback'] = route('stripe.success');
        $validateData['stripe_cancel_callback']  = route('stripe.cancel');





        $deposit = Deposit::create([
            'customer_id'        => Auth::user()->id,
            'accept_currency_id' => $request->payment_currency,
            'user_id'            => Auth::user()->id,
            'date'               => now(),
            'method'             => $request->payment_method,
            'amount'             => $request->deposit_amount,
            'fees'               => 0,
            'stripe_session_id'  => "",
            'comments'           => $request->deposit_comments,
            'deposit_ip'         => $request->ip(), // Auto-capturing user IP
            'updated_by'         => Auth::user()->id, // Assigning the currently authenticated user
            'status'             => 0,
            'created_at'         => now(),
        ]);

        if($deposit){
            return redirect()->route('customer.deposit.process');
        }else{

        }

        // $depositData = $this->depositService->makeDeposit($validateData);

        // dd($depositData);

        // if ($depositData->status == "success") {
        //     return back()->withInput()->withErrors($depositData->message);
        // }

        // if ($depositData->redirect) {
        //     return redirect()->away($depositData->data['redirect_url']);
        // } else {

        //     if (session()->has('deposit')) {
        //         session()->forget(['deposit', 'depositData']);
        //     }

        //     return redirect()->route('customer.deposit.process');
        //     $objDepositData           = (object) $depositData->data;
        //     $objDepositData->currency = $validateData['payment_currency'];
        //     session()->put([
        //         'deposit'     => 1,
        //         'depositData' => $objDepositData,
        //     ]);

        //     return redirect()->route('customer.deposit.process');
        // }

    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('finance::show');
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
            return redirect()->route('customer.deposit.index')->with('error', localize('There was an error with your deposit.'));
        }

        cs_set('theme', [
            'title'       => localize('Deposit Payment Process'),
            'description' => localize('Deposit Payment Process'),
        ]);

        $data['depositData'] = session('depositData');

        return view('finance::customer.deposit.process', $data);
    }

}
