<?php

namespace Modules\Finance\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Finance\App\DataTables\WithdrawDataTable;
use Modules\Finance\App\Enums\WithdrawStatusEnum;
use Modules\Finance\App\Http\Requests\CreditRequest;
use Modules\Finance\App\Services\WithdrawService;
use App\Traits\ChecksPermissionTrait;
use App\Enums\PermissionMenuEnum;
use App\Enums\PermissionActionEnum;

class WithdrawController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * Summary of __construct
     * @param WithdrawService $withdrawService
     */
    public function __construct(
        protected WithdrawService $withdrawService,
    ) {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::FINANCE_WITHDRAW_LIST->value  . '.' . PermissionActionEnum::READ->value,
            'create'  => PermissionMenuEnum::FINANCE_WITHDRAW_LIST->value  . '.' . PermissionActionEnum::READ->value,
            'store'   => PermissionMenuEnum::FINANCE_WITHDRAW_LIST->value  . '.' . PermissionActionEnum::READ->value,
            'edit'    => PermissionMenuEnum::FINANCE_WITHDRAW_LIST->value  . '.' . PermissionActionEnum::READ->value,
            'update'  => PermissionMenuEnum::FINANCE_WITHDRAW_LIST->value  . '.' . PermissionActionEnum::READ->value,
            'destroy' => PermissionMenuEnum::FINANCE_WITHDRAW_LIST->value  . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(WithdrawDataTable $withdrawDataTable)
    {
        return $withdrawDataTable->render('finance::withdraw.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(CreditRequest $request): bool
    {
        return true;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finance::create');
    }

    /**
     * Show the specified resource.
     */
    public function show(int $id): bool
    {
        return true;
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
    public function update(Request $request, $id): JsonResponse
    {
        $withdrawStatus = $request['set_status'];

        if ($withdrawStatus == WithdrawStatusEnum::CANCEL->value) {
            $withDrawResult = $this->withdrawService->withdrawCancel(['withdraw_id' => $id]);

            if ($withDrawResult->status == "success") {
                return response()->json([
                    'success' => true,
                    'message' => localize("Cancelled successfully"),
                    'title'   => localize("Withdraw"),
                    'data'    => $withDrawResult->data,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $withDrawResult->message,
                    'title'   => localize("Withdraw"),
                    'data'    => [],
                ]);
            }

        } elseif ($withdrawStatus == WithdrawStatusEnum::SUCCESS->value) {
            $withDrawResult = $this->withdrawService->withdrawApprove(['withdraw_id' => $id]);

            if ($withDrawResult->status == "success") {
                return response()->json([
                    'success' => true,
                    'message' => localize("Approved successfully"),
                    'title'   => localize("Withdraw"),
                    'data'    => $withDrawResult->data,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $withDrawResult->message,
                    'title'   => localize("Withdraw"),
                    'data'    => [],
                ]);
            }

        } else {
            return response()->json([
                'success' => false,
                'message' => localize("Something went wrong"),
                'title'   => localize("Withdraw"),
                'data'    => [],
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return false;
    }

}
