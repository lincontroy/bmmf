<?php

namespace Modules\Merchant\App\Http\Controllers\Customer;

use App\Enums\AuthGuardEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Merchant\App\Http\Requests\AccountRequestApplicationRequest;
use Modules\Merchant\App\Services\MerchantAccountRequestService;
use Modules\Merchant\DataTables\MerchantAccountTable;
use App\Enums\CustomerMerchantVerifyStatusEnum;

class MerchantAccountRequestController extends Controller
{
    /**
     * MerchantAccountRequestController of construct
     *
     * @param MerchantAccountRequestService $merchantFeeService
     */
    public function __construct(
        protected MerchantAccountRequestService $merchantAccountRequestService,
    ) {

    }

    /**
     * Display a listing of the resource.
     * @param MerchantAccountTable $dataTable
     * @return mix
     */
    public function index(MerchantAccountTable $dataTable)
    {
        cs_set('theme', [
            'title'       => localize('Merchant Request Application'),
            'description' => localize('Merchant Request Application'),
        ]);

        $customer = auth(AuthGuardEnum::CUSTOMER->value)->user();

        return $dataTable->render('merchant::customer.account-request.index', compact('customer'));
    }

    /**
     * Display create of the resource.
     * @param Request $request
     * @return view
     */
    public function create(Request $request)
    {
        if (in_array(auth(AuthGuardEnum::CUSTOMER->value)->user()->merchant_verified_status, [CustomerMerchantVerifyStatusEnum::VERIFIED, CustomerMerchantVerifyStatusEnum::PROCESSING])) {
            error_message(localize("Merchant Account Request Create Failed"));
            return redirect()->route('customer.merchant.account-request.index');
        }

        cs_set('theme', [
            'title'       => localize('Merchant Request Application'),
            'description' => localize('Merchant Request Application'),
        ]);

        return view('merchant::customer.account-request.create');
    }

    /**
     * Store of the resource
     *
     * @param AccountRequestApplicationRequest $request
     * @return RedirectResponse
     */
    public function store(AccountRequestApplicationRequest $request): RedirectResponse
    {
        $data                = $request->validated();
        $data['customer_id'] = auth(AuthGuardEnum::CUSTOMER->value)->user()->id;
        $data['user_id']     = auth(AuthGuardEnum::CUSTOMER->value)->user()->user_id;

        $this->merchantAccountRequestService->create($data);
        success_message(localize("Merchant Account Request create successfully"));

        return redirect()->route('customer.merchant.account-request.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->merchantAccountRequestService->destroy(['id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Merchant Account Request delete successfully"),
            'title'   => localize("Merchant Account Request"),
        ]);

    }
}
