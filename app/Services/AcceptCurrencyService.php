<?php

namespace App\Services;

use App\Enums\AssetsFolderEnum;
use App\Enums\AuthGuardEnum;
use App\Enums\StatusEnum;
use App\Http\Resources\CurrencyResource;
use App\Repositories\Interfaces\AcceptCurrencyGatewayRepositoryInterface;
use App\Repositories\Interfaces\AcceptCurrencyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AcceptCurrencyService
{
    /** AcceptCurrencyService constructor. */
    public function __construct(
        private AcceptCurrencyRepositoryInterface $currencyRepository,
        private AcceptCurrencyGatewayRepositoryInterface $currencyGateway
    ) {
    }

    /**
     * Create accept currency
     * @param array $attributes
     * @return object
     */
    public function create(array $attributes): object
    {
        try {
            DB::beginTransaction();
            $acceptCurrency = $this->currencyRepository->create([
                'name'       => $attributes['currency_name'],
                'symbol'     => $attributes['currency_symbol'],
                'logo'       => AssetsFolderEnum::COIN_LOGO_DIR->value . '/' . Str::lower($attributes['currency_symbol']) . '.svg',
                'status'     => $attributes['status'],
                'created_by' => auth(AuthGuardEnum::ADMIN->value)->user()->id,
            ]);

            if ($acceptCurrency) {

                foreach ($attributes['accept_payment_gateway'] as $key => $value) {
                    $this->currencyGateway->create([
                        "accept_currency_id" => $acceptCurrency->id,
                        "payment_gateway_id" => $value,
                    ]);
                }

            }

            DB::commit();

            return $acceptCurrency;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }

    /**
     * Delete stake plan data
     * @param array $attributes
     * @return bool
     */
    public function destroy(array $attributes): bool
    {
        $currencyId = $attributes['currency_id'];
        try {
            DB::beginTransaction();

            $this->currencyGateway->destroyCurrencyGateway($currencyId);
            $this->currencyRepository->delete($currencyId);

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }

    /**
     * Find Accept currency data
     * @param int $id
     * @return object|null
     */
    public function find(int $id): ?object
    {
        return $this->currencyRepository->find($id);
    }

    /**
     * Update Accept Currency Data
     * @param array $attributes
     * @param string $id
     * @return bool
     */
    public function update(array $attributes, string $id): bool
    {
        try {

            $updateData = [
                'name'       => $attributes['currency_name'],
                'symbol'     => $attributes['currency_symbol'],
                'logo'       => AssetsFolderEnum::COIN_LOGO_DIR->value . '/' . Str::lower($attributes['currency_symbol']) . '.svg',
                'status'     => $attributes['status'],
                'updated_by' => auth(AuthGuardEnum::ADMIN->value)->user()->id,
            ];

            DB::beginTransaction();

            $updateResult = $this->currencyRepository->updateById($id, $updateData);

            if ($updateResult) {

                $this->currencyGateway->destroyCurrencyGateway($id);

                foreach ($attributes['accept_payment_gateway'] as $key => $value) {
                    $this->currencyGateway->create([
                        "accept_currency_id" => $id,
                        "payment_gateway_id" => $value,
                    ]);
                }

            }

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }

    /**
     * Calculate currency chart data
     * @param mixed $chartData
     * @return array
     */
    public function currencySymbolData($chartData): array
    {

        if (!$chartData) {
            return [];
        }

        return $this->currencyRepository->currencyChartSymbolData($chartData);
    }

    /**
     * Find currency by payment gateway
     * @param int $gatewayId
     * @return object|null
     */
    public function findCurrency(int $gatewayId): ?object
    {
        $currencyData = $this->currencyGateway->findWhere('payment_gateway_id', $gatewayId);

        $filterCurrencyData = $currencyData->filter(function ($currency) {
            return isset($currency->currencyInfo->id);
        });

        return CurrencyResource::collection($filterCurrencyData);
    }

    /**
     * Find accept currency by currency symbol
     * @param string $symbol
     * @return object|null
     */
    public function findCurrencyBySymbol(string $symbol): ?object
    {
        return $this->currencyRepository->firstWhere('symbol', $symbol);
    }

    /**
     * Find all active currency
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function activeAll(array $attributes = []): Collection
    {
        return $this->currencyRepository->findWhere('status', StatusEnum::ACTIVE->value);
    }

    /**
     * Find all active currency
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allWithBalance(array $attributes = []): Collection
    {
        return $this->currencyRepository->allWithBalance($attributes);
    }

}