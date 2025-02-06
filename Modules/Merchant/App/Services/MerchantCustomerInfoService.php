<?php

namespace Modules\Merchant\App\Services;

use App\Enums\AuthGuardEnum;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Merchant\App\Repositories\Interfaces\MerchantCustomerInfoRepositoryInterface;

class MerchantCustomerInfoService
{
    /**
     * MerchantCustomerInfoService constructor.
     *
     * @param  MerchantCustomerInfoRepositoryInterface $merchantCustomerInfoRepository
     */
    public function __construct(
        private MerchantCustomerInfoRepositoryInterface $merchantCustomerInfoRepository,
    ) {
    }

    /**
     * Find Merchant Customer Info or throw 404
     *
     * @param  int  $id
     * @return object
     */
    public function findOrFail(int $id): object
    {
        return $this->merchantCustomerInfoRepository->findOrFail($id);
    }

    /**
     * Create Merchant Customer Info
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): ?object
    {
        $merchantAccount = auth(AuthGuardEnum::CUSTOMER->value)->user()->approvedMerchantAccount;

        /**
         * Check merchant account
         */

        if (!$merchantAccount) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Merchant Customer Error"),
                'title'   => localize("Merchant Customer Not Approved yet"),
            ], 422));
        }

        $attributes['merchant_account_id'] = $merchantAccount->id;

         try {
            DB::beginTransaction();

            $merchantAccount = $this->merchantCustomerInfoRepository->create($attributes);

            DB::commit();

            return $merchantAccount;

        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Merchant Account create error"),
                'title'   => localize("Merchant Account"),
                'errors'  => $exception,
            ], 422));
        }

    }

     /**
     * Create from customer Merchant Customer Info
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function createFromCustomer(array $attributes): ?object
    {

         try {
            DB::beginTransaction();

            $merchantAccount = $this->merchantCustomerInfoRepository->create($attributes);

            DB::commit();

            return $merchantAccount;

        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Merchant Account create error"),
                'title'   => localize("Merchant Account"),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update Merchant Customer Info
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $merchantCustomerId = $attributes['id'];

        $merchantAccount = auth(AuthGuardEnum::CUSTOMER->value)->user()->approvedMerchantAccount;

        /**
         * Check merchant account
         */

        if (!$merchantAccount) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Merchant Customer Error"),
                'title'   => localize("Merchant Customer Not Approved yet"),
            ], 422));
        }

        $attributes['merchant_account_id'] = $merchantAccount->id;

        try {
            DB::beginTransaction();

            $this->merchantCustomerInfoRepository->updateById($merchantCustomerId, $attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Merchant Account update error"),
                'title'   => localize("Merchant Account"),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Delete Merchant Customer Info
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes): bool
    {
        $merchantCustomerId = $attributes['id'];

        try {
            DB::beginTransaction();

            $this->merchantCustomerInfoRepository->destroyById($merchantCustomerId);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Merchant Account delete error"),
                'title'   => localize("Merchant Account"),
                // 'errors'  => $exception->getMessage(),
            ], 422));
        }

    }

    /**
     * Find by attributes Merchant Customer Info with currency or throw 404
     *
     * @param  array $attributes
     * @return object|null
     */
    public function findByAttributes(array $attributes): ?object
    {
        return $this->merchantCustomerInfoRepository->findByAttributes($attributes);
    }

    /**
     * Find by uuid Merchant Customer Information with currency or throw 404
     *
     * @param  string  $uu_id
     * @return object
     */
    public function findByUuid(string $uu_id): object
    {
        return $this->merchantCustomerInfoRepository->findByUuid($uu_id);
    }


    /**
     * Find by uuid Merchant Customer Information with currency or throw 404
     *
     * @param  string  $uu_id
     * @return object
     */
    public function findByUuidWithMerchantAccount(string $uu_id): object
    {
        return $this->merchantCustomerInfoRepository->findByUuidWithMerchantAccount($uu_id);
    }

}
