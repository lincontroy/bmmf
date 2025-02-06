<?php

namespace Modules\Finance\App\Http\Controllers\Customer;

use App\Enums\OtpVerifyTypeEnum;
use App\Http\Controllers\Controller;
use App\Services\AcceptCurrencyService;
use App\Services\CurrencyConvertService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Finance\App\DataTables\Customer\TransferDataTable;
use Modules\Finance\App\Http\Requests\TransferRequest;
use Modules\Finance\App\Services\TransferService;

class TransferController extends Controller
{

    public function __construct(
        private AcceptCurrencyService $acceptCurrencyService,
        private TransferService $transferService,
        private CurrencyConvertService $currencyConvertService
    ) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(TransferDataTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Transfer List'),
            'description' => localize('Transfer List'),
        ]);

        return $dataTable->render('finance::customer.transfer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        cs_set('theme', [
            'title'       => localize('Transfer'),
            'description' => localize('Transfer'),
        ]);

        $data['currencyData'] = $this->acceptCurrencyService->activeAll();

        return view('finance::customer.transfer.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransferRequest $request): RedirectResponse
    {
        $validateData = $request->validated();

        $verifyTransfer = $this->transferService->transferVerify($validateData);

        if ($verifyTransfer->status != "success") {
            return back()->withInput()->withErrors($verifyTransfer->message);
        }

        $transferResult = $this->transferService->makeTransfer($verifyTransfer->data);

        if ($transferResult->status != "success") {
            return back()->withInput()->withErrors($transferResult->message);
        }

        if (session()->has('otp_verify')) {
            session()->forget(['otp_verify', 'wrong_limit', 'otp_data']);
        }

        session()->put([
            'otp_verify'  => true,
            'wrong_limit' => 3,
            'otp_data'    => [
                'verify_type' => OtpVerifyTypeEnum::TRANSFER->value,
                'callback'    => 'customer.transfer.callback',
            ],
        ]);

        return redirect()->route('otp.verify');
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

    public function transferConfirm(): RedirectResponse
    {

        if (!session()->has('otp_verified')) {
            return redirect()->route('customer.transfer.create')->with('exception', 'Access Denied');
        }

        cs_set('theme', [
            'title'       => 'Transfer Confirm',
            'description' => 'Transfer Confirm',
        ]);

        $verifyId = session('verify_id');
        session()->forget(['otp_verified', 'verify_id']);

        $systemTransferResult = $this->transferService->confirmTransfer($verifyId);

        if ($systemTransferResult->status == "success") {
            return redirect()->route('customer.transfer.create')->with('success', localize('Transfer successfully'));
        } else {
            return redirect()->route('customer.transfer.create')->with('exception', $systemTransferResult->message);
        }

    }

}
