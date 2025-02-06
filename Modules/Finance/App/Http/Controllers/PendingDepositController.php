<?php

namespace Modules\Finance\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Finance\App\DataTables\PendingDepositsDataTable;
use App\Traits\ChecksPermissionTrait;
use App\Enums\PermissionMenuEnum;
use App\Enums\PermissionActionEnum;

class PendingDepositController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    public function __construct()
    {
        $this->mapActionPermission = [
            'index'       => PermissionMenuEnum::FINANCE_PENDING_DEPOSIT->value . '.' . PermissionActionEnum::READ->value,
            'store'       => PermissionMenuEnum::FINANCE_PENDING_DEPOSIT->value . '.' . PermissionActionEnum::READ->value,
            'create'      => PermissionMenuEnum::FINANCE_PENDING_DEPOSIT->value . '.' . PermissionActionEnum::READ->value,
            'show'        => PermissionMenuEnum::FINANCE_PENDING_DEPOSIT->value . '.' . PermissionActionEnum::READ->value,
            'edit'        => PermissionMenuEnum::FINANCE_PENDING_DEPOSIT->value . '.' . PermissionActionEnum::READ->value,
            'update'      => PermissionMenuEnum::FINANCE_PENDING_DEPOSIT->value . '.' . PermissionActionEnum::READ->value,
            'destroy'     => PermissionMenuEnum::FINANCE_PENDING_DEPOSIT->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PendingDepositsDataTable $pendingDepositsDataTable)
    {
        return $pendingDepositsDataTable->render('finance::pending_deposit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finance::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return true;
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
