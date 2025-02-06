<?php

namespace Modules\Merchant\App\Services;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Merchant\App\Models\MerchantFee;
use Modules\Merchant\App\Repositories\Interfaces\MerchantCustomerInfoRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\MerchantFeeRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\MerchantPaymentUrlRepositoryInterface;

class PaymentProcessCustomerService
{
    /**
     * PaymentProcessCustomerService constructor.
     *
     * @param MerchantFeeRepositoryInterface $merchantFeeRepository
     */
    public function __construct(
        private MerchantFeeRepositoryInterface $merchantFeeRepository,
        private MerchantCustomerInfoRepositoryInterface $merchantCustomerInfoRepository,
        private MerchantPaymentUrlRepositoryInterface $merchantPaymentUrlRepository,
    ) {
    }

    /**
     * Check Merchant Customer
     *
     * @param array $attributes
     * @return object|null
     */
    public function checkMerchantCustomer(array $attributes): ?object
    {
        $email = $attributes['email'];
        $uu_id = $attributes['uu_id'];

        $merchantPaymentUrl = $this->merchantPaymentUrlRepository->findByAttributes(['uu_id' => $uu_id]);

        if (!$merchantPaymentUrl) {
            return null;
        }

        $merchantCustomerInfo = $this->merchantCustomerInfoRepository->findByAttributes([
            'email'               => $email,
            'merchant_account_id' => $merchantPaymentUrl->merchant_account_id,
        ]);

        return $merchantCustomerInfo;
    }

    /**
     * Merchant fee create
     *
     * @param array $attributes
     * @return object
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
     * @return object
     * @return void
     */
    public function findFeesByAcceptCurrency(int $acceptCurrencyId): ?object
    {
        return $this->merchantFeeRepository->firstWhere('accept_currency_id', $acceptCurrencyId);
    }

}
