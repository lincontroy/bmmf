<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\Customer\CustomerDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerBackendRequest;
use App\Services\CustomerService;
use App\Services\InvestmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Finance\App\Services\DepositService;
use Modules\Finance\App\Services\TransferService;
use Modules\Finance\App\Services\WithdrawService;
use App\Traits\ChecksPermissionTrait;
use App\Enums\PermissionMenuEnum;
use App\Enums\PermissionActionEnum;

class CustomerController extends Controller
{

    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * Summary of __construct
     * @param CustomerService $customerService
     */
    public function __construct(
        protected CustomerService $customerService,
        protected DepositService $depositService,
        protected WithdrawService $withdrawService,
        protected TransferService $transferService,
        protected InvestmentService $investmentService,
    ) {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::CUSTOMER_CUSTOMERS->value  . '.' . PermissionActionEnum::READ->value,
            'create'  => PermissionMenuEnum::CUSTOMER_CUSTOMERS->value  . '.' . PermissionActionEnum::CREATE->value,
            'store'   => PermissionMenuEnum::CUSTOMER_CUSTOMERS->value  . '.' . PermissionActionEnum::CREATE->value,
            'edit'    => PermissionMenuEnum::CUSTOMER_CUSTOMERS->value  . '.' . PermissionActionEnum::UPDATE->value,
            'update'  => PermissionMenuEnum::CUSTOMER_CUSTOMERS->value  . '.' . PermissionActionEnum::UPDATE->value,
            'destroy' => PermissionMenuEnum::CUSTOMER_CUSTOMERS->value  . '.' . PermissionActionEnum::DELETE->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CustomerDataTable $customerDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Customer'),
            'description' => localize('Customer'),
        ]);

        return $customerDataTable->render('backend.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerBackendRequest $request): JsonResponse
    {
        $user = $this->customerService->customerCreate($request->all());

        return response()->json([
            'success' => true,
            'message' => localize("Customer create successfully"),
            'title'   => localize("Customer"),
            'data'    => $user,
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show(int $id)
    {
        $customer = $this->customerService->findOrFail($id);

        $attributes['customer_id'] = $id;
        $attributes['user_id']     = $customer['user_id'];

        $deposits    = $this->depositService->getAll($attributes);
        $withdraws   = $this->withdrawService->getAll($attributes);
        $transfers   = $this->transferService->getAllTransfer($attributes);
        $received    = $this->transferService->getAllReceived($attributes);
        $investments = $this->investmentService->getAllInvestments($attributes);

        return view('backend.customer.details', compact('deposits', 'withdraws', 'transfers', 'received', 'investments', 'customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $user = $this->customerService->findOrFail($id);

        return view('backend.customer.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     * @param CustomerBackendRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(CustomerBackendRequest $request, $id): JsonResponse
    {
        $data                = $request->validated();
        $data['customer_id'] = $id;
        $user                = $this->customerService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Customer update successfully"),
            'title'   => localize("Customer"),
            'data'    => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @var int $id
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->customerService->destroy(['customer_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Customer delete successfully"),
            'title'   => localize("Customer"),
        ]);
    }

}
