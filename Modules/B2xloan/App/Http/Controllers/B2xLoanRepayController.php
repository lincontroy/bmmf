<?php

namespace Modules\B2xloan\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Traits\ChecksPermissionTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\B2xloan\App\DataTables\B2xLoanRepayDataTable;

class B2xLoanRepayController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    public function __construct()
    {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::B2X_LOAN_THE_MONTHS_REPAYMENTS->value . '.' . PermissionActionEnum::READ->value,
            'create'  => PermissionMenuEnum::B2X_LOAN_ALL_LOAN_REPAYMENTS->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(B2xLoanRepayDataTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize("Current Month's Loan Repay"),
            'description' => localize("Current Month's Loan Repay"),
        ]);

        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;

        return $dataTable->with(['currentMonth' => $currentMonth, 'currentYear' => $currentYear])->render('b2xloan::repayments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(B2xLoanRepayDataTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize("All Loan Repayments"),
            'description' => localize("All Loan Repayments"),
        ]);

        return $dataTable->render('b2xloan::repayments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('b2xloan::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('b2xloan::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
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
