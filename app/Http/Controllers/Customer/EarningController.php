<?php

namespace App\Http\Controllers\Customer;

use App\DataTables\Customer\earning\CapitalReturnDataTable;
use App\DataTables\Customer\earning\InvestInterestDataTable;
use App\DataTables\Customer\earning\InvestInterestFutureDataTable;
use App\DataTables\Customer\earning\ReferralCommissionDataTable;
use App\DataTables\Customer\earning\TeamBonusDataTable;
use App\Http\Controllers\Controller;
use App\Services\InvestmentEarningService;
use App\Services\MyGenerationService;
use Illuminate\Support\Facades\Auth;
use Modules\Customer\App\Http\Requests\CustomerRequest;

class EarningController extends Controller
{
    /**
     * EarningController of __construct
     *
     * @param InvestmentEarningService $investmentEarningService
     */
    public function __construct(
        protected InvestmentEarningService $investmentEarningService,
        protected MyGenerationService $myGenerationService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(InvestInterestDataTable $investInterestDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Invest Interest'),
            'description' => localize('Invest Interest'),
        ]);

        return $investInterestDataTable->render('customer.earning.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function interestFuture(InvestInterestFutureDataTable $interestFutureDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Invest Interest Future'),
            'description' => localize('Invest Interest Future'),
        ]);

        return $interestFutureDataTable->render('customer.earning.future');
    }

    /**
     * Display a listing of the resource.
     */
    public function capitalReturn(CapitalReturnDataTable $capitalReturnDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Capital Return'),
            'description' => localize('Capital Return'),
        ]);

        return $capitalReturnDataTable->render('customer.earning.capital_return');
    }

    /**
     * Display a listing of the resource.
     */
    public function referralCommission(ReferralCommissionDataTable $referralCommissionDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Referral Commission'),
            'description' => localize('Referral Commission'),
        ]);

        return $referralCommissionDataTable->render('customer.earning.referral_commission');
    }

    /**
     * Display a listing of the resource.
     */
    public function teamBonus(TeamBonusDataTable $teamBonusDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Team Bonus'),
            'description' => localize('Team Bonus'),
        ]);

        return $teamBonusDataTable->render('customer.earning.team_bonus');
    }

    /**
     * Display a listing of the resource.
     */
    public function myGeneration()
    {
        cs_set('theme', [
            'title'       => localize('My Generation'),
            'description' => localize('My Generation'),
        ]);


        $userId = Auth::user()->user_id;

        $generations = $this->myGenerationService->getGenerations($userId);

        return view('customer.earning.my_generation', compact('generations'));
    }
}
