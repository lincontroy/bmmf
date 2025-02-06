<?php

namespace Modules\Finance\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Services\CustomerWithdrawAccountService;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Finance\App\DataTables\PendingWithdrawDataTable;
use Modules\Finance\App\Services\WithdrawService;

class PendingWithdrawController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    public function __construct(
        private WithdrawService $withdrawService,
        private CustomerWithdrawAccountService $customerWithdrawAccountService,
        private CustomerRepositoryInterface $customerRepository,
    ) {
        $this->mapActionPermission = [
            'index'    => PermissionMenuEnum::FINANCE_PENDING_WITHDRAW->value . '.' . PermissionActionEnum::READ->value,
            'userInfo' => PermissionMenuEnum::FINANCE_PENDING_WITHDRAW->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PendingWithdrawDataTable $pendingWithdrawDataTable)
    {
        return $pendingWithdrawDataTable->render('finance::withdraw.pending_withdraw');
    }

    /**
     * Display a listing of the resource.
     */
    public function userInfo(Request $request): JsonResponse
    {
        $id = $request['id'];

        $withdraw = $this->withdrawService->findById($id);

        if ($withdraw) {

            $attributes['customer_id']        = $withdraw->customer_id;
            $attributes['payment_gateway_id'] = $withdraw->payment_gateway_id;
            $user                             = $this->customerRepository->firstWhere('id', $withdraw->customer_id);
            $user->withdrawMethod             = $this->customerWithdrawAccountService->userWithdrawAccount($attributes);
        }

        return response()->json([
            'success' => true,
            'message' => $user ? "Your user is (" . $user->first_name . " " . $user->last_name . ")" : "User not found!",
            'title'   => "Add Credit",
            'data'    => $user ?? null,
        ]);
    }

}
