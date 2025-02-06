<?php

namespace Modules\Merchant\App\Services;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Merchant\App\Repositories\Interfaces\MerchantAccountRepositoryInterface;

class MerchantTransactionService
{
    /**
     * MerchantService constructor.
     *
     * @param MerchantAccountRepositoryInterface $merchantAccountRepository
     */
    public function __construct(
        private MerchantAccountRepositoryInterface $merchantAccountRepository,
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
     * Create credit
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        return true;
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

        try {
            DB::beginTransaction();

            $this->merchantAccountRepository->updateById($merchantId, $data);

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

}
