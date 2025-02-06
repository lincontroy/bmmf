<?php

namespace Modules\Merchant\App\Services;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Merchant\App\Enums\MerchantPaymentTransactionStatusEnum;
use Modules\Merchant\App\Repositories\Interfaces\MerchantPaymentTransactionRepositoryInterface;

class MerchantPaymentTransactionService
{
    /**
     * MerchantPaymentTransactionService constructor.
     *
     * @param  MerchantPaymentTransactionRepositoryInterface $merchantPaymentTransactionRepository
     */
    public function __construct(
        private MerchantPaymentTransactionRepositoryInterface $merchantPaymentTransactionRepository,
    ) {
    }

    /**
     * Find Merchant Payment Transaction or throw 404
     *
     * @param  int  $id
     * @return object|null
     */
    public function findOrFail(int $id): ?object
    {
        return $this->merchantPaymentTransactionRepository->findOrFail($id);
    }

    /**
     * Create Merchant Payment Transaction
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): ?object
    {

        if (!isset($attributes['status'])) {
            $attributes['status'] = MerchantPaymentTransactionStatusEnum::PENDING->value;
        }

        try {
            DB::beginTransaction();

            $merchantPaymentTransaction = $this->merchantPaymentTransactionRepository->create($attributes);

            DB::commit();

            return (object) ['status' => 'success', 'data' => $merchantPaymentTransaction];

        } catch (Exception $exception) {

            DB::rollBack();

            return (object) ['status' => 'error', 'message' => $exception->getMessage()];
        }

    }

    /**
     * Update Merchant Payment Transaction Status
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function updateStatusByTransactionHash($transactionHas, $status): bool
    {
        try {
            DB::beginTransaction();

            $merchantPaymentTransaction = $this->merchantPaymentTransactionRepository->updateStatusByTransactionHash($transactionHas, $status);

            DB::commit();

            return $merchantPaymentTransaction;

        } catch (Exception $exception) {

            DB::rollBack();
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Merchant Payment Transaction update status error"),
                'title'   => localize("Merchant Payment Transaction"),
                'errors'  => $exception,
            ], 422));
        }

    }

}
