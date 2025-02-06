<?php

namespace Modules\Merchant\App\Services;

use App\Enums\AuthGuardEnum;
use App\Enums\CommonStatusEnum;
use App\Enums\StatusEnum;
use App\Repositories\Interfaces\AcceptCurrencyRepositoryInterface;
use App\Repositories\Interfaces\FiatCurrencyRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Merchant\App\Enums\MerchantPaymentUlrPaymentTypeEnum;
use Modules\Merchant\App\Enums\MerchantPaymentUlrStatusEnum;
use Modules\Merchant\App\Repositories\Interfaces\MerchantAcceptCoinRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\MerchantPaymentUrlRepositoryInterface;

class MerchantPaymentUrlService
{
    /**
     * MerchantPaymentUrlService constructor.
     *
     * @param  MerchantPaymentUrlRepositoryInterface $merchantPaymentUrlRepository
     * @param  MerchantAcceptCoinRepositoryInterface $merchantAcceptCoinRepository
     * @param  FiatCurrencyRepositoryInterface $fiatCurrencyRepository
     * @param  AcceptCurrencyRepositoryInterface $acceptCurrencyRepository
     */
    public function __construct(
        private MerchantPaymentUrlRepositoryInterface $merchantPaymentUrlRepository,
        private MerchantAcceptCoinRepositoryInterface $merchantAcceptCoinRepository,
        private FiatCurrencyRepositoryInterface $fiatCurrencyRepository,
        private AcceptCurrencyRepositoryInterface $acceptCurrencyRepository,
    ) {
    }

    /**
     * Find Merchant Payment Url or throw 404
     *
     * @param  int  $id
     * @return object
     */
    public function findOrFail(int $id): object
    {
        return $this->merchantPaymentUrlRepository->findOrFail($id);
    }

    /**
     * Find Merchant Payment Url with currency or throw 404
     *
     * @param  int  $id
     * @return object
     */
    public function findWithCurrency(int $id): object
    {
        return $this->merchantPaymentUrlRepository->findWithCurrency($id);
    }

    /**
     * Find by uu_id Merchant Payment Url with currency or throw 404
     *
     * @param  string  $uu_id
     * @return object|null
     */
    public function findByUuidWithCurrency(string $uu_id): ?object
    {
        return $this->merchantPaymentUrlRepository->findByUuidWithCurrency($uu_id);
    }

    /**
     * Find by uu_id Merchant Payment Url with Merchant Accept Coin or throw 404
     *
     * @param  string  $uu_id
     * @return object|null
     */
    public function findByUuidWithMerchantAcceptCoin(string $uu_id, ?int $accept_currency_id): ?object
    {
        return $this->merchantPaymentUrlRepository->findByUuidWithMerchantAcceptCoin($uu_id, $accept_currency_id);
    }

    /**
     * Find Merchant Payment Url or throw 404
     *
     * @param  int  $id
     * @return object
     */
    public function formData(): array
    {
        $merchantPaymentUlrPaymentTypes = MerchantPaymentUlrPaymentTypeEnum::values();
        $fiatCurrencies                 = $this->fiatCurrencyRepository->all(['status' => CommonStatusEnum::ACTIVE]);
        $acceptCurrencies               = $this->acceptCurrencyRepository->all(['status' => StatusEnum::ACTIVE->value]);

        return compact('merchantPaymentUlrPaymentTypes', 'fiatCurrencies', 'acceptCurrencies');
    }

    /**
     * Create Merchant Payment Url
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

        if (!isset($attributes['duration'])) {
            $attributes['duration'] = Carbon::now()->addDays(5)->format('Y-m-d H:i:s');
        }

        $attributes['merchant_account_id'] = $merchantAccount->id;
        $attributes['status']              = MerchantPaymentUlrStatusEnum::ACTIVE->value;

        try {
            DB::beginTransaction();

            $merchantPaymentUrl = $this->merchantPaymentUrlRepository->create($attributes);

            if ($merchantPaymentUrl && isset($attributes['accept_currency_id'])) {

                foreach ($attributes['accept_currency_id'] as $accept_currency_id) {
                    $this->merchantAcceptCoinRepository->create([
                        'accept_currency_id'      => $accept_currency_id,
                        'merchant_payment_url_id' => $merchantPaymentUrl->id,
                    ]);
                }

            }

            DB::commit();

            return $merchantAccount;

        } catch (Exception $exception) {

            DB::rollBack();
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Merchant Payment Url create error"),
                'title'   => localize("Merchant Payment Url"),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update Merchant Payment Url
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $merchantPaymentUrlId = $attributes['id'];

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
        $attributes['status']              = MerchantPaymentUlrStatusEnum::ACTIVE->value;

        try {
            DB::beginTransaction();

            $merchantPaymentUrlUpdate = $this->merchantPaymentUrlRepository->updateById($merchantPaymentUrlId, $attributes);

            $this->merchantAcceptCoinRepository->destroyByMerchantPaymentUrlId($merchantPaymentUrlId);

            if ($merchantPaymentUrlUpdate && isset($attributes['accept_currency_id'])) {

                foreach ($attributes['accept_currency_id'] as $accept_currency_id) {
                    $this->merchantAcceptCoinRepository->create([
                        'accept_currency_id'      => $accept_currency_id,
                        'merchant_payment_url_id' => $merchantPaymentUrlId,
                    ]);
                }

            }

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Merchant Payment Url update error"),
                'title'   => localize("Merchant Payment Url"),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Delete Merchant Payment Url
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes): bool
    {
        $merchantPaymentUrlId = $attributes['id'];

        try {
            DB::beginTransaction();

            $this->merchantAcceptCoinRepository->destroyByMerchantPaymentUrlId($merchantPaymentUrlId);
            $this->merchantPaymentUrlRepository->destroyById($merchantPaymentUrlId);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Merchant Payment Url delete error"),
                'title'   => localize("Merchant Payment Url"),
                // 'errors'  => $exception->getMessage(),
            ], 422));
        }

    }

    /**
     * Update Current Time
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function updateByCurrentTime(): bool
    {

        try {
            DB::beginTransaction();

            $this->merchantPaymentUrlRepository->updateByCurrentTime();

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            return false;
        }

    }

}
