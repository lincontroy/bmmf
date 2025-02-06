<?php

namespace Modules\B2xloan\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\CustomerRepository;
use App\Traits\ChecksPermissionTrait;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\B2xloan\App\DataTables\B2xLoanWithdrawDataTable;
use Modules\B2xloan\App\Services\B2xLoanService;

class B2xLoanPendingWithdrawController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * B2xloanController constructor
     *
     */
    public function __construct(
        private B2xLoanService $b2xLoanService,
        private CustomerRepository $customerRepository,
    ) {
        $this->mapActionPermission = [
            'index'             => PermissionMenuEnum::B2X_LOAN_WITHDRAWAL_PENDING->value . '.' . PermissionActionEnum::READ->value,
            'show'              => PermissionMenuEnum::B2X_LOAN_WITHDRAWAL_PENDING->value . '.' . PermissionActionEnum::READ->value,
            'getUser'           => PermissionMenuEnum::B2X_LOAN_WITHDRAWAL_PENDING->value . '.' . PermissionActionEnum::READ->value,
            'userLoanPayoutDoc' => PermissionMenuEnum::B2X_LOAN_WITHDRAWAL_PENDING->value . '.' . PermissionActionEnum::READ->value,
            'update'            => PermissionMenuEnum::B2X_LOAN_WITHDRAWAL_PENDING->value . '.' . PermissionActionEnum::READ->value,
            'destroy'           => PermissionMenuEnum::B2X_LOAN_WITHDRAWAL_PENDING->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(B2xLoanWithdrawDataTable $b2xLoanDataTable)
    {
        cs_set('theme', [
            'title'       => localize('B2x Loan Withdraw'),
            'description' => localize('B2x Loan Withdraw'),
        ]);

        return $b2xLoanDataTable->render('b2xloan::loan_pending_withdraw');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('b2xloan::show');
    }

    /**
     * Display a listing of the resource.
     */
    public function getUser(Request $request): JsonResponse
    {
        $userId = (string) $request['user_id'];
        $loanId = $request['loanId'];
        $user   = $this->customerRepository->firstWhere('id', $userId);

        $loan = $this->userLoanPayoutDoc($loanId);

        return response()->json([
            'success' => true,
            'message' => $user ? "Your user is (" . $user->first_name . " " . $user->last_name . ")" : "User not found!",
            'title'   => localize("Add Credit"),
            'data'    => $user ?? null,
        ]);
    }

    /**
     * Display a user loan payout doc resource.
     */
    private function userLoanPayoutDoc($loanId)
    {
        return $this->b2xLoanService->findById($loanId);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $data['loan_id']      = $id;
        $data['set_status']   = $request['set_status'];
        $data['checker_note'] = $request['checker_note'];
        $loan                 = $this->b2xLoanService->withdrawUpdate($data);

        return response()->json([
            'success' => true,
            'message' => localize("Loan update successfully"),
            'title'   => localize("B2xloan"),
            'segment' => "withdraw",
            'data'    => $loan,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @var int $id
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->b2xLoanService->destroy(['package_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Package delete successfully"),
            'title'   => localize("Package"),
        ]);

    }
}
