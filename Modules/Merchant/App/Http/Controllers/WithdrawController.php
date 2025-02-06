<?php

namespace Modules\Merchant\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Merchant\App\DataTables\ConfirmWithdrawDataTable;
use Modules\Merchant\App\DataTables\PendingWithdrawDataTable;
use Modules\Merchant\App\DataTables\WithdrawDataTable;
use Modules\Merchant\App\Enums\MerchantWithdrawEnum;
use Modules\Merchant\App\Services\MerchantWithdrawService;

class WithdrawController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * WithdrawController of __construct
     *
     * @param MerchantWithdrawService $merchantWithdrawService
     */
    public function __construct(
        protected MerchantWithdrawService $merchantWithdrawService,

    ) {
        $this->mapActionPermission = [
            'index'           => PermissionMenuEnum::MERCHANT_WITHDRAW_LIST->value . '.' . PermissionActionEnum::READ->value,
            'pendingWithdraw' => PermissionMenuEnum::MERCHANT_PENDING_WITHDRAW->value . '.' . PermissionActionEnum::READ->value,
            'confirmWithdraw' => PermissionMenuEnum::MERCHANT_WITHDRAW_LIST->value . '.' . PermissionActionEnum::READ->value,
            'create'          => PermissionMenuEnum::MERCHANT_WITHDRAW_LIST->value . '.' . PermissionActionEnum::READ->value,
            'store'           => PermissionMenuEnum::MERCHANT_WITHDRAW_LIST->value . '.' . PermissionActionEnum::READ->value,
            'show'            => PermissionMenuEnum::MERCHANT_WITHDRAW_LIST->value . '.' . PermissionActionEnum::READ->value,
            'edit'            => PermissionMenuEnum::MERCHANT_WITHDRAW_LIST->value . '.' . PermissionActionEnum::READ->value,
            'update'          => PermissionMenuEnum::MERCHANT_WITHDRAW_LIST->value . '.' . PermissionActionEnum::READ->value,
            'destroy'         => PermissionMenuEnum::MERCHANT_WITHDRAW_LIST->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(WithdrawDataTable $withdrawDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Withdraw List'),
            'description' => localize('Withdraw List'),
        ]);

        return $withdrawDataTable->render('merchant::withdraw');
    }

    /**
     * Display a listing of the resource.
     */
    public function pendingWithdraw(PendingWithdrawDataTable $withdrawDataTable)
    {

        cs_set('theme', [
            'title'       => localize('Pending Withdraw'),
            'description' => localize('Pending Withdraw'),
        ]);
        return $withdrawDataTable->render('merchant::pending_withdraw');
    }

    /**
     * Display a listing of the resource.
     */
    public function confirmWithdraw(ConfirmWithdrawDataTable $withdrawDataTable)
    {
        return $withdrawDataTable->render('merchant::confirm_withdraw');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('merchant::create');
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
    public function update(Request $request, $id): JsonResponse
    {
        $withdrawStatus = $request['set_status'];

        if ($withdrawStatus == MerchantWithdrawEnum::CANCEL->value) {
            $withDrawResult = $this->merchantWithdrawService->withdrawCancel(['withdraw_id' => $id]);

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

        } elseif ($withdrawStatus == MerchantWithdrawEnum::CONFIRM->value) {
            $withDrawResult = $this->merchantWithdrawService->withdrawApprove(['withdraw_id' => $id]);

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
        //
    }

}
