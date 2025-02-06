<?php

namespace Modules\Merchant\App\Services;

use App\Enums\CustomerMerchantVerifyStatusEnum;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Merchant\App\Enums\MerchantApplicationStatusEnum;
use Modules\Merchant\App\Repositories\Interfaces\MerchantAccountRepositoryInterface;

class MerchantAccountService
{
    /**
     * MerchantAccountService constructor.
     *
     * @param MerchantAccountRepositoryInterface $merchantAccountRepository
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        private MerchantAccountRepositoryInterface $merchantAccountRepository,
        private CustomerRepositoryInterface $customerRepository,
    ) {
    }

    /**
     * get data by id
     * @param mixed $id
     * @return object
     */
    public function findById($id): object
    {
        return $this->merchantAccountRepository->find($id);

    }

    /**
     * get data by id
     * @param mixed $id
     * @return object
     */
    public function creditDetails($id): object
    {
        return $this->merchantAccountRepository->creditDetails($id);

    }

    /**
     * Update Merchant
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $merchantId         = $attributes['merchant_id'];
        $data['status']     = $attributes['set_status'];
        $data['checked_by'] = $attributes['checked_by'];

        $merchantAccount = $this->merchantAccountRepository->findByIdWithCustomer($merchantId);

        try {
            DB::beginTransaction();

            $this->merchantAccountRepository->updateById($merchantId, $data);

            $customerStatus = CustomerMerchantVerifyStatusEnum::CANCELED->value;

            if ($data['status'] == MerchantApplicationStatusEnum::APPROVED->value) {
                $customerStatus = CustomerMerchantVerifyStatusEnum::VERIFIED->value;
            }

            $this->customerRepository->updateMerchantVerifiedStatus($merchantAccount->customerInfo->id, $customerStatus);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Merchant update error"),
                'title'   => localize('Merchant'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Find Merchant Account
     * @param array $attributes
     * @return object|null
     */
    public function findMerchantAccount(string $userId): ?object
    {
        return $this->merchantAccountRepository->findDoubleWhereFirst(
            'user_id',
            $userId,
            'status',
            MerchantApplicationStatusEnum::APPROVED->value
        );
    }

}
