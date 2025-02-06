<?php

namespace Modules\Merchant\App\Http\Controllers\Customer;

use App\Enums\AuthGuardEnum;
use App\Enums\CustomerMerchantVerifyStatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Merchant\App\Http\Requests\MerchantPaymentUlrRequest;
use Modules\Merchant\App\Services\MerchantPaymentUrlService;
use Modules\Merchant\DataTables\MerchantPaymentUrlTable;

class MerchantPaymentUrlController extends Controller
{
    /**
     * MerchantPaymentUrlController of construct
     *
     * @param MerchantPaymentUrlService $merchantPaymentUrlService
     */
    public function __construct(
        protected MerchantPaymentUrlService $merchantPaymentUrlService,
    ) {

    }

    /**
     * Display Merchant Payment Url
     *
     * @param MerchantPaymentUrlTable $dataTable
     * @return mixed
     */
    public function index(MerchantPaymentUrlTable $dataTable)
    {

        $this->merchantPaymentUrlService->updateByCurrentTime();

        /**
         * Check Customer Verification Check
         */

        if (auth(AuthGuardEnum::CUSTOMER->value)->user()->merchant_verified_status !== CustomerMerchantVerifyStatusEnum::VERIFIED) {
            error_message(localize("Merchant Account Request not verified"));
            return redirect()->route('customer.merchant.account-request.create');
        }

        cs_set('theme', [
            'title'       => localize('Merchant Payment Url'),
            'description' => localize('Merchant Payment Url'),
        ]);

        $data = $this->merchantPaymentUrlService->formData();

        return $dataTable->render('merchant::customer.payment-url.index', $data);
    }

    /**
     * Create Merchant Payment Url
     *
     * @param MerchantPaymentUlrRequest $request
     * @return JsonResponse
     */
    public function store(MerchantPaymentUlrRequest $request): JsonResponse
    {
        $data = $request->validated();

        $merchantAccount = $this->merchantPaymentUrlService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Merchant Payment Url create successfully"),
            'title'   => localize("Merchant Payment Url"),
            'data'    => $merchantAccount,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     * @throws Exception
     */
    public function viewPaymentLink(int $id): JsonResponse
    {
        $merchantPaymentUrl         = $this->merchantPaymentUrlService->findOrFail($id);
        $data['qr_image']           = qr_code_simple_in_base_64(route('payment.index', ['payment_url' => $merchantPaymentUrl->uu_id]), 200);
        $data['merchantPaymentUrl'] = $merchantPaymentUrl;
        $merchantCustomerInfo       = view('merchant::customer.payment-url.payment-link', $data)->render();

        return response()->json([
            'success' => true,
            'message' => localize("Payment Link"),
            'title'   => localize("Payment Link"),
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
        $merchantCustomerInfo = $this->merchantPaymentUrlService->findWithCurrency($id);

        return response()->json([
            'success' => true,
            'message' => localize("Merchant Payment Url Info Data"),
            'title'   => localize("Merchant Payment Url Info"),
            'data'    => $merchantCustomerInfo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MerchantPaymentUlrRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(MerchantPaymentUlrRequest $request, int $id): JsonResponse
    {
        $data       = $request->validated();
        $data['id'] = $id;

        $article = $this->merchantPaymentUrlService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Merchant Payment Url Info update successfully"),
            'title'   => localize("Merchant Payment Url Info"),
            'data'    => $article,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->merchantPaymentUrlService->destroy(['id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Merchant Payment Url delete successfully"),
            'title'   => localize("Merchant Payment Url"),
        ]);

    }

}
