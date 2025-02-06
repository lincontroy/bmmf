<?php

namespace Modules\Merchant\App\Services;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Merchant\App\Models\MerchantFee;
use Modules\Merchant\App\Repositories\Interfaces\MerchantFeeRepositoryInterface;

class MerchantFeeService
{
    /**
     * MerchantFeeService constructor.
     *
     * @param MerchantFeeRepositoryInterface $merchantFeeRepository
     */
    public function __construct(
        private MerchantFeeRepositoryInterface $merchantFeeRepository,
    ) {
    }

    /**
     * Merchant fee create
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): ?object
    {
        MerchantFee::truncate();

        $currencyIds = $attributes['accept_currency_id'];
        $percents    = $attributes['percent'];

        try {
            DB::beginTransaction();

            foreach ($currencyIds as $key => $item) {

                $this->merchantFeeRepository->create([
                    'accept_currency_id' => $item,
                    'percent'            => $percents[$key],
                ]);
            }

            DB::commit();

            return (object) [];

        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Merchant fee update error"),
                'title'   => localize('Merchant'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Find Fees by Accept Currency Id
     * @return void
     */
    public function findFeesByAcceptCurrency(int $acceptCurrencyId): ?object
    {
        return $this->merchantFeeRepository->firstWhere('accept_currency_id', $acceptCurrencyId);
    }

}
