<?php

namespace Modules\Merchant\App\Http\Controllers\Customer;

use App\Enums\AuthGuardEnum;
use App\Enums\CustomerMerchantVerifyStatusEnum;
use App\Http\Controllers\Controller;
use Modules\Merchant\App\Services\MerchantAccountRequestService;
use Modules\Merchant\DataTables\TransactionTable;

class TransactionRequestController extends Controller
{
    /**
     * TransactionRequestController of construct
     *
     * @param MerchantAccountRequestService $merchantFeeService
     */
    public function __construct(
    ) {

    }

    /**
     * Display a listing of the resource.
     * @param TransactionTable $dataTable
     * @return mix
     */
    public function index(TransactionTable $dataTable)
    {
        /**
         * Check Customer Verification Check
         */

         if (auth(AuthGuardEnum::CUSTOMER->value)->user()->merchant_verified_status !== CustomerMerchantVerifyStatusEnum::VERIFIED) {
            error_message(localize("Merchant Account Request not verified"));
            return redirect()->route('customer.merchant.account-request.create');
        }

        cs_set('theme', [
            'title'       => localize('Merchant Transaction'),
            'description' => localize('Merchant Transaction'),
        ]);


        $customer = auth(AuthGuardEnum::CUSTOMER->value)->user();

        return $dataTable->render('merchant::customer.transaction.index', compact('customer'));
    }

}
