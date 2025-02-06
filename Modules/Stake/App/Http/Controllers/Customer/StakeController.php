<?php

namespace Modules\Stake\App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\WalletManageService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Stake\App\Http\Requests\StakeOrderRequest;
use Modules\Stake\App\Services\StakePlanService;

class StakeController extends Controller
{
    public function __construct(
        private StakePlanService $stakePlanService,
        private WalletManageService $walletManageService
    ) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        cs_set('theme', [
            'title'       => localize('Stake Plan'),
            'description' => localize('Stake Plan'),
        ]);

        $data['stakes'] = $this->stakePlanService->allActive();

        return view('stake::customer.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stake::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StakeOrderRequest $request): RedirectResponse
    {
        $validateData = $request->validated();

        $verifyData = $this->stakePlanService->verifyOrder($validateData);

        if ($verifyData->status != "success") {
            return redirect()->route('customer.stake.plan.index')->with("exception", $verifyData->message);
        }

        $orderData = $this->stakePlanService->makeOrder($verifyData->data);

        if ($orderData->status != "success") {
            return redirect()->route('customer.stake.plan.index')->with("exception", $orderData->message);
        } else {
            return redirect()->route("customer.stake.plan.index")->with("success", "Staked successfully!");
        }

    }

    /**
     * Show the specified resource.
     */
    public function show(Request $request, $id): View
    {
        $data['stake'] = $stakePlan = $this->stakePlanService->findPlan($id);

        if (!$stakePlan) {
            return view('stake::customer.stake_modal_data', $data);
        }

        $data['stakeRateInfo'] = $stakeRateInfo = $stakePlan->stakeRateInfo()->where('id', $request->rate_id)->first();

        $currentDateTime = Carbon::now();
        $newDateTime     = $currentDateTime->addDays($stakeRateInfo->duration);

        $data['redemptionData'] = $newDateTime->toDateTimeString();

        $data['walletBalanceInfo'] = $this->walletManageService->walletBalance([
            'currency_id' => $stakePlan->accept_currency_id,
            'user_id'     => auth()->user()->user_id,
        ]);

        return view('stake::customer.stake_modal_data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('stake::edit');
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

}