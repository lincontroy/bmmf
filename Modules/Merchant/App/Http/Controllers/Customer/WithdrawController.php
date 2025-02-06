<?php

namespace Modules\Merchant\App\Http\Controllers\Customer;

use App\Enums\OtpVerifyTypeEnum;
use App\Http\Controllers\Controller;
use App\Services\PaymentGatewayService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Finance\App\Http\Requests\WithdrawalRequest;
use Modules\Merchant\App\DataTables\Customer\WithdrawDataTable;
use Modules\Merchant\App\Services\MerchantWithdrawService;

class WithdrawController extends Controller
{

    public function __construct(
        private PaymentGatewayService $paymentGatewayService,
        private MerchantWithdrawService $merchantWithdrawService
    ) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(WithdrawDataTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Withdrawal List'),
            'description' => localize('Withdrawal List'),
        ]);

        return $dataTable->render('merchant::customer.withdraw.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        cs_set('theme', [
            'title'       => localize('Merchant Withdraw'),
            'description' => localize('Merchant Withdraw'),
        ]);

        $data['gatewayData'] = $this->paymentGatewayService->findGateway();

        return view('merchant::customer.withdraw.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WithdrawalRequest $request): RedirectResponse
    {
        $validateData = $request->validated();

        $verifyWithdraw = $this->merchantWithdrawService->withdrawVerify($validateData);

        if ($verifyWithdraw->status != "success") {
            return back()->withInput()->withErrors($verifyWithdraw->message);
        }

        $withdrawResult = $this->merchantWithdrawService->makeWithdraw($verifyWithdraw->data);

        if ($withdrawResult->status != "success") {
            return back()->withInput()->withErrors($withdrawResult->message);
        }

        if (session()->has('otp_verify')) {
            session()->forget(['otp_verify', 'wrong_limit', 'otp_data']);
        }

        session()->put([
            'otp_verify'  => true,
            'wrong_limit' => 3,
            'otp_data'    => [
                'verify_type' => OtpVerifyTypeEnum::WITHDRAW->value,
                'callback'    => 'customer.merchant.withdraw.callback',
            ],
        ]);

        return redirect()->route('otp.verify');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('merchant::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('merchant::edit');
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

    /**
     * Make system withdrawal confirm
     * @return \Illuminate\Http\RedirectResponse
     */
    public function withdrawConfirm(): RedirectResponse
    {

        if (!session()->has('otp_verified')) {
            return redirect()->route('customer.merchant.withdraw.create')->with('exception', 'Access Denied');
        }

        cs_set('theme', [
            'title'       => localize('Withdrawal Confirm'),
            'description' => localize('Withdrawal Confirm'),
        ]);

        $verifyId = session('verify_id');
        session()->forget(['otp_verified', 'verify_id']);

        $systemWithdrawalResult = $this->merchantWithdrawService->confirmWithdraw($verifyId);

        if ($systemWithdrawalResult->status == "success") {

            return redirect()->route('customer.merchant.withdraw.create')->with('success', localize('Withdrawal successfully'));

        } else {

            return redirect()->route('customer.merchant.withdraw.create')->with('exception', $systemWithdrawalResult->message);
        }

    }

}
