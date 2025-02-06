<?php

namespace App\Services;

use App\Enums\AuthGuardEnum;
use App\Repositories\Interfaces\FiatCurrencyRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FiatCurrencyService
{
    /**
     * FiatCurrencyService of construct
     *
     * @param FiatCurrencyRepositoryInterface $fiatCurrencyRepository
     */
    public function __construct(
        private FiatCurrencyRepositoryInterface $fiatCurrencyRepository,
    ) {
    }

    /**
     * Find or fail data
     * @param int $id
     * @return object
     * @throws Exception
     *
     */
    public function findOrFail(int $id): object
    {
        return $this->fiatCurrencyRepository->findOrFail($id);
    }

    /**
     * Create Data
     * @param array $attributes
     * @return object
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        $attributes['created_by'] = auth(AuthGuardEnum::ADMIN->value)->user()->id;


        try {
            DB::beginTransaction();

            $fiatCurrency = $this->fiatCurrencyRepository->create($attributes);

            DB::commit();

            return $fiatCurrency;
        } catch (\Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Fiat Currency create error"),
                'title'   => localize('Fiat Currency'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update Data
     * @param array $attributes
     * @param string $id
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes, string $id): bool
    {
        $attributes['updated_by'] = auth(AuthGuardEnum::ADMIN->value)->user()->id;

        try {
            DB::beginTransaction();

            $this->fiatCurrencyRepository->updateById($id, $attributes);

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Fiat Currency update error"),
                'title'   => localize('Fiat Currency'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Delete Data
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes): bool
    {
        $fiatCurrencyId = $attributes['fiat_currency_id'];
        try {
            DB::beginTransaction();

            $this->fiatCurrencyRepository->destroyById($fiatCurrencyId);

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Fiat Currency delete error"),
                'title'   => localize("Fiat Currency"),
                // 'errors'  => $exception->getMessage(),
            ], 422));
        }

    }

}
