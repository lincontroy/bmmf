<?php

namespace Modules\Merchant\App\Services;

use App\Helpers\ImageHelper;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Merchant\App\Repositories\Interfaces\MerchantAccountRepositoryInterface;
use App\Enums\CustomerMerchantVerifyStatusEnum;

class MerchantAccountRequestService
{
    /**
     * MerchantAccountRequestService constructor.
     *
     * @param  MerchantAccountRepositoryInterface $merchantAccountRepository
     * @param  CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        private MerchantAccountRepositoryInterface $merchantAccountRepository,
        private CustomerRepositoryInterface $customerRepository,
    ) {
    }

    /**
     * Create
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): ?object
    {

        $attributes['logo'] = ImageHelper::upload($attributes['logo'] ?? null, 'merchant-account');
        $user_id            = $attributes['user_id'];
        $customer_id        = $attributes['customer_id'];

        try {
            DB::beginTransaction();

            $merchantAccount = $this->merchantAccountRepository->create($attributes);
            $this->customerRepository->updateMerchantVerifiedStatus($customer_id, CustomerMerchantVerifyStatusEnum::PROCESSING->value);

            DB::commit();

            return $merchantAccount;

        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Merchant Account Request create error"),
                'title'   => localize("Merchant Account Request"),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Delete
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes): bool
    {
        $merchantAccountId = $attributes['id'];

        try {
            DB::beginTransaction();
            $this->merchantAccountRepository->destroyById($merchantAccountId);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Merchant Account Request delete error"),
                'title'   => localize("Merchant Account Request"),
            ], 422));
        }

    }
}
