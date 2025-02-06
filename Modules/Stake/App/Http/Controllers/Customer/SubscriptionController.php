<?php

namespace Modules\Stake\App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Stake\App\DataTables\Customer\StakeSubscriptionDataTable;
use Modules\Stake\App\Enums\CustomerStakeEnum;
use Modules\Stake\App\Repositories\Interfaces\CustomerStakeRepositoryInterface;

class SubscriptionController extends Controller
{

    public function __construct(
        private CustomerStakeRepositoryInterface $customerStakeRepository
    ) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(StakeSubscriptionDataTable $stakeSubscriptionDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Stake Subscription'),
            'description' => localize('Stake Subscription'),
        ]);

        $userId = Auth::user()->user_id;

        $holding  = $this->customerStakeRepository->doubleWhereCount('status', CustomerStakeEnum::REDEEMED_ENABLE->value, 'user_id', $userId);
        $redeemed = $this->customerStakeRepository->doubleWhereCount('status', CustomerStakeEnum::REDEEMED->value, 'user_id', $userId);
        $pending  = $this->customerStakeRepository->doubleWhereCount('status', CustomerStakeEnum::RUNNING->value, 'user_id', $userId);

        return $stakeSubscriptionDataTable->with('tab', request()->input('tab', 'all'))->render('stake::customer.subscription', compact('holding', 'redeemed', 'pending'));
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
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('stake::show');
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
