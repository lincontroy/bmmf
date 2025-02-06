<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface InvestmentRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllInvestments(array $attributes): ?object;
    public function totalData(): float;
    public function sumCurrentMonthData(): float;
    public function sumPreviousMonthData(): float;
    public function sumYearlyChartData(): array;
    public function historyChartData(string $dataType): array;
    public function investmentHistoryData(): object;
    public function myPackages(array $attributes): object;
    public function investmentReport(array $attributes): object;
    public function investmentCount($sponsorId);
}
