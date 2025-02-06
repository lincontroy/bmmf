<?php

namespace Modules\Finance\App\Http\Controllers\Customer;

use App\Enums\OtpVerifyTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\WithdrawalAccount;
use Auth;
use App\Models\Withdrawal;
use App\Models\WalletManage;
use App\Models\TxnReport;
use App\Models\Customer;
use App\Services\PaymentGatewayService;
use App\Services\WithdrawalAccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Modules\Finance\App\DataTables\Customer\WithdrawAccountDataTable;
use Modules\Finance\App\DataTables\Customer\WithdrawDataTable;
use Modules\Finance\App\Http\Requests\WithdrawalAccountRequest;
use Modules\Finance\App\Http\Requests\WithdrawalRequest;
use Modules\Finance\App\Services\WithdrawService;

class WithdrawController extends Controller
{

    public function __construct(
        private PaymentGatewayService $paymentGatewayService,
        private WithdrawalAccountService $withdrawalAccountService,
        private WithdrawService $withdrawService

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

        return $dataTable->render('finance::customer.withdraw.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        cs_set('theme', [
            'title'       => localize('Withdraw'),
            'description' => localize('Withdraw'),
        ]);

        $data['gatewayData'] = $this->paymentGatewayService->findGateway();

        return view('finance::customer.withdraw.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WithdrawalRequest $request): RedirectResponse
    {

        // dd($request);
        $validateData = $request->validated();

        $customer_id=Auth::user()->id;

        $customer=Customer::where('id',$customer_id)->first();

        // dd($user_id);

        $user_id=$customer->user_id;

        // dd($customer);

        $wallet_info=WalletManage::where('user_id',$user_id)->first();

        $wallet_balance=$wallet_info->balance;

    //    dd($wallet_info);

        if($wallet_balance>=$request->withdraw_amount){
            //proceed with the withdrawal

            $newbalance=$wallet_balance-$request->withdraw_amount;
            $wallet_info->update(['balance'=>$newbalance]);

            // dd($request)
            

            //create a record on the transaction and withdrawals table

            $withdrawal=Withdrawal::create([
                'customer_id'=>$customer_id,
                'payment_gateway_id'=>$request->payment_method,
                'accept_currency_id'=>1,
                'fees'=>0,
                // 'withdrawal_account_id'=>1,
                'amount'=>$request->withdraw_amount,
                'status'=>2

            ]);

            $trx_report=TxnReport::create([
                'customer_id'=>$customer_id,
                'accept_currency_id'=>1,
                'txn_type'=>2,
                'amount'=>$request->withdraw_amount,
                'usd_value'=>$request->withdraw_amount
                
            ]);

            return back()->with("success", localize("Withdrawal created!"));

            

        }else{
            //redirect with error
            return back()->withInput()->withErrors("Insufficient balance");
        }



        
        // $verifyWithdraw = $this->withdrawService->withdrawVerify($validateData);

        // if ($verifyWithdraw->status != "success") {
        //     return back()->withInput()->withErrors($verifyWithdraw->message);
        // }

        // $withdrawResult = $this->withdrawService->makeWithdraw($verifyWithdraw->data);

        // if ($withdrawResult->status != "success") {
        //     return back()->withInput()->withErrors($withdrawResult->message);
        // }

        // if (session()->has('otp_verify')) {
        //     session()->forget(['otp_verify', 'wrong_limit', 'otp_data']);
        // }

        // session()->put([
        //     'otp_verify'  => true,
        //     'wrong_limit' => 3,
        //     'otp_data'    => [
        //         'verify_type' => OtpVerifyTypeEnum::WITHDRAW->value,
        //         'callback'    => 'customer.withdraw.callback',
        //     ],
        // ]);

        // return redirect()->route('otp.verify');
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

    public function accountList(WithdrawAccountDataTable $withdrawAccountDataTable)
    {
        return $withdrawAccountDataTable->render('finance::customer.withdraw.account_list');
    }

    public function withdrawalAccount(): View
    {
        cs_set('theme', [
            'title'       => localize('Withdrawal Account'),
            'description' => localize('Withdraw Account'),
        ]);

        $data['gatewayData'] = $this->paymentGatewayService->findGateway();

        return view('finance::customer.withdraw.account', $data);
    }

    public function withdrawalAccountStore(WithdrawalAccountRequest $request): RedirectResponse
    {
        $validateData = $request->validated();

        $saveResult = $this->withdrawalAccountService->create($validateData);

        if ($saveResult->status != "success") {
            return back()->with("exception", $saveResult->message);
        } else {
            return back()->with("success", localize("Withdrawal Account Created Successfully!"));
        }

    }

    public function withdrawConfirm(): RedirectResponse
    {

        if (!session()->has('otp_verified')) {
            return redirect()->route('customer.withdraw.create')->with('exception', 'Access Denied');
        }

        cs_set('theme', [
            'title'       => localize('Withdrawal Confirm'),
            'description' => localize('Withdrawal Confirm'),
        ]);

        $verifyId = session('verify_id');
        session()->forget(['otp_verified', 'verify_id']);

        $systemWithdrawalResult = $this->withdrawService->confirmWithdraw($verifyId);

        if ($systemWithdrawalResult->status == "success") {
            return redirect()->route('customer.withdraw.create')->with('success', localize('Withdrawal successfully'));
        } else {
            return redirect()->route('customer.withdraw.create')->with('exception', $systemWithdrawalResult->message);
        }

    }

    public function withdrawalAccountDestroy(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'account_id' => ["required", "integer", Rule::exists(WithdrawalAccount::class, 'id')],
        ]);

        $this->withdrawalAccountService->destroy($validatedData);

        return response()->json([
            'success' => true,
            'message' => localize("Deleted successfully"),
            'title'   => localize("Withdrawal Account"),
        ]);

    }

}
