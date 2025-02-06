<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface AcceptCurrencyRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get Currency
     *
     * @param array $attributes
     * @return object|null
     */
    public function getCurrency(array $attributes): ?object;

    /**
     * Currency Chart Symbol Data
     *
     * @param object $chartData
     * @return array
     */
    public function currencyChartSymbolData(object $chartData): array;
    public function updateCurrencyRate($attributes): bool;
    public function allWithBalance(array $attributes = []): ?object;
    public function allActive(array $attributes = []): ?object;
}
