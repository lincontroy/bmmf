<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\Customer\CustomerVerifyDocDataTable;
use App\DataTables\Customer\VerifyCanceledCustomerDataTable;
use App\DataTables\Customer\VerifyCustomerDataTable;
use App\Enums\CustomerVerifyStatusEnum;
use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use App\Services\CustomerVerifyDocService;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerVerifyDocController extends Controller
{

    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * Summary of __construct
     * @param CustomerService $customerService
     * @param CustomerVerifyDocService $customerVerifyDocService
     */
    public function __construct(
        protected CustomerService $customerService,
        protected CustomerVerifyDocService $customerVerifyDocService,
    ) {
        $this->mapActionPermission = [
            'index'                    => PermissionMenuEnum::ACCOUNT_VERIFICATION->value . '.' . PermissionActionEnum::READ->value,
            'verifiedCustomer'         => PermissionMenuEnum::ACCOUNT_VERIFIED->value . '.' . PermissionActionEnum::READ->value,
            'verifiedCanceledCustomer' => PermissionMenuEnum::ACCOUNT_VERIFIED_CANCELED->value . '.' . PermissionActionEnum::READ->value,

            'edit'                     => PermissionMenuEnum::ACCOUNT_VERIFICATION->value . '.' . PermissionActionEnum::READ->value,
            'update'                   => PermissionMenuEnum::ACCOUNT_VERIFICATION->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CustomerVerifyDocDataTable $customerVerifyDocDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Verify Pending Customers'),
            'description' => localize('Customer'),
        ]);

        return $customerVerifyDocDataTable->render('backend.customer.verify_doc');
    }

    /**
     * Display a listing of the resource.
     */
    public function verifiedCustomer(VerifyCustomerDataTable $verifyCustomerDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Verified Customers'),
            'description' => localize('Customer'),
        ]);

        return $verifyCustomerDataTable->render('backend.customer.verified_customer');
    }

    /**
     * Display a listing of the resource.
     */
    public function verifiedCanceledCustomer(VerifyCanceledCustomerDataTable $verifyCanceledCustomerDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Verify Canceled Customers'),
            'description' => localize('Customer'),
        ]);

        return $verifyCanceledCustomerDataTable->render('backend.customer.verified_canceled_customer');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $customer = $this->customerService->findOrFail($id);

        return view('backend.customer.doc_edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $actionButton        = $request->input('action_button_name');
        $data['customer_id'] = $id;

        if ($actionButton == 'cancel') {
            $data['verified_status'] = CustomerVerifyStatusEnum::CANCELED->value;
        } else {
            $data['verified_status'] = CustomerVerifyStatusEnum::VERIFIED->value;
        }

        $user = $this->customerService->updateVerifyStatusById($data);

        return response()->json([
            'success' => true,
            'message' => localize("Customer verify updated successfully"),
            'title'   => localize("Customer"),
            'data'    => $user,
        ]);
    }

}
