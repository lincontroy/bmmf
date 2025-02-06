<?php

namespace Modules\Merchant\App\Http\Controllers\Customer;

use App\Enums\AuthGuardEnum;
use App\Enums\CustomerMerchantVerifyStatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Merchant\App\Http\Requests\MerchantCustomerRequest;
use Modules\Merchant\App\Services\MerchantCustomerInfoService;
use Modules\Merchant\DataTables\MerchantCustomerInfoTable;

class MerchantCustomerInfoController extends Controller
{
    /**
     * MerchantCustomerInfoController of construct
     *
     * @param MerchantCustomerInfoService $merchantCustomerInfoService
     */
    public function __construct(
        protected MerchantCustomerInfoService $merchantCustomerInfoService,
    ) {

    }

    /**
     * Display Merchant Customer
     *
     * @param MerchantCustomerInfoTable $dataTable
     * @return mixed
     */
    public function index(MerchantCustomerInfoTable $dataTable): mixed
    {

        /**
         * Check Customer Verification Check
         */

        if (auth(AuthGuardEnum::CUSTOMER->value)->user()->merchant_verified_status !== CustomerMerchantVerifyStatusEnum::VERIFIED) {
            error_message(localize("Merchant Account Request not verified"));
            return redirect()->route('customer.merchant.account-request.create');
        }

        cs_set('theme', [
            'title'       => localize('Merchant Customer'),
            'description' => localize('Merchant Customer'),
        ]);

        return $dataTable->render('merchant::customer.customer');
    }

    /**
     * Create Merchant Customer
     *
     * @param MerchantCustomerRequest $request
     * @return JsonResponse
     */
    public function store(MerchantCustomerRequest $request): JsonResponse
    {
        $data                 = $request->validated();
        $merchantCustomerInfo = $this->merchantCustomerInfoService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Merchant Customer create successfully"),
            'title'   => localize("Merchant Customer"),
            'data'    => $merchantCustomerInfo,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     * @throws Exception
     */
    public function edit(int $id): JsonResponse
    {
        $merchantCustomerInfo = $this->merchantCustomerInfoService->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => localize("Merchant Customer Info Data"),
            'title'   => localize("Merchant Customer Info"),
            'data'    => $merchantCustomerInfo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MerchantCustomerRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(MerchantCustomerRequest $request, int $id): JsonResponse
    {
        $data       = $request->validated();
        $data['id'] = $id;

        $merchantCustomerInfo = $this->merchantCustomerInfoService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Merchant Customer Info update successfully"),
            'title'   => localize("Merchant Customer Info"),
            'data'    => $merchantCustomerInfo,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->merchantCustomerInfoService->destroy(['id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Merchant Customer Info delete successfully"),
            'title'   => localize("Merchant Customer Info"),
        ]);

    }

}
