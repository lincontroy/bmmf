<?php

namespace Modules\Merchant\App\Services;

use App\Enums\AuthGuardEnum;
use Modules\Merchant\App\Repositories\Interfaces\MerchantBalanceRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\MerchantCustomerInfoRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\MerchantPaymentTransactionRepositoryInterface;

class MerchantDashboardService
{
    /**
     * MerchantDashboardService constructor.
     *
     * @param  MerchantCustomerInfoRepositoryInterface $merchantCustomerInfoRepository
     * @param  MerchantPaymentTransactionRepositoryInterface $merchantPaymentTransactionRepository
     */
    public function __construct(
        private MerchantCustomerInfoRepositoryInterface $merchantCustomerInfoRepository,
        private MerchantBalanceRepositoryInterface $merchantBalanceRepository,
        private MerchantPaymentTransactionRepositoryInterface $merchantPaymentTransactionRepository,
    ) {
    }

    /**
     * Dashboard Data
     *
     * @return array
     */
    public function dashboardData(): array
    {
        $totalCustomer = $this->merchantCustomerInfoRepository->merchantCustomerCount([
            'user_id' => auth(AuthGuardEnum::CUSTOMER->value)->user()->user_id,
        ]);

        $totalTransaction = $this->merchantPaymentTransactionRepository->merchantPaymentTransactionCount([
            'user_id' => auth(AuthGuardEnum::CUSTOMER->value)->user()->user_id,
        ]);

        $merchantBalances = $this->merchantBalanceRepository->getByAttributes([
            'user_id' => auth(AuthGuardEnum::CUSTOMER->value)->user()->user_id,
        ], ['acceptCurrency']);

        $recentTransactions = $this->merchantPaymentTransactionRepository->takeLatestTransactionByAttributes([
            'user_id' => auth(AuthGuardEnum::CUSTOMER->value)->user()->user_id,
        ]);

        return compact('totalCustomer', 'totalTransaction', 'merchantBalances', 'recentTransactions');

    }
}
