<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\InvestmentEarningRepositoryInterface;
use App\Repositories\Interfaces\TxnReportRepositoryInterface;
use App\Repositories\Interfaces\WalletManageRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Finance\App\Repositories\Interfaces\DepositRepositoryInterface;
use Modules\Finance\App\Repositories\Interfaces\WithdrawRepositoryInterface;
use Modules\Package\App\Enums\CapitalBackEnum;
use Modules\Package\App\Enums\InterestTypeEnum;
use Modules\Package\App\Enums\InvestTypeEnum;
use Modules\Package\App\Enums\ReturnTypeEnum;
use Modules\Package\App\Repositories\Interfaces\PackageRepositoryInterface;

class CustomerDashboardService
{
    /**
     * CustomerDashboardService constructor.
     * @param DepositRepositoryInterface $depositRepository
     * @param WithdrawRepositoryInterface $withdrawRepository
     * @param InvestmentEarningRepositoryInterface $investmentEarningRepository
     * @param WalletManageRepositoryInterface $walletManageRepository
     * @param PackageRepositoryInterface $packageRepository
     */
    public function __construct(
        private DepositRepositoryInterface $depositRepository,
        private WithdrawRepositoryInterface $withdrawRepository,
        private InvestmentEarningRepositoryInterface $investmentEarningRepository,
        private WalletManageRepositoryInterface $walletManageRepository,
        private PackageRepositoryInterface $packageRepository,
        private TxnReportRepositoryInterface $txnReportRepository,
        private CustomerRepositoryInterface $customerRepository,
    ) {
    }

    /**
     * get recent investment data
     *
     * @return object
     */
    public function recentInvestment(): object
    {
        $user                      = Auth::user();
        $limit                     = 10;
        $attributes['limit']       = $limit;
        $attributes['status']      = StatusEnum::ACTIVE->value;
        $attributes['customer_id'] = $user->id;
        $attributes['user_id']     = $user->user_id;

        return $this->investmentEarningRepository->recentData($attributes);
    }

    public function chartData($attributes = []): object
    {
        $attributes['customer_id'] = Auth::user()->id;

        return $this->customerRepository->countYearlyCustomer();
    }

    /**
     * get customer balance
     *
     * @return float
     */
    public function getBalance(): float
    {
        $user                  = Auth::user();
        $attributes['user_id'] = $user->user_id;

        return $this->walletManageRepository->getBalance($attributes);
    }

    public function latestTxnData(): array
    {
        $user                      = Auth::user();
        $attributes['customer_id'] = $user->id;

        return $this->txnReportRepository->customerRecentData($attributes);
    }

    /**
     * Required data to populate form
     *
     * @return array
     */
    public function formData(): array
    {
        $investmentType = InvestTypeEnum::toArray();
        $interestType   = InterestTypeEnum::toArray();
        $returnType     = ReturnTypeEnum::toArray();
        $capitalBack    = CapitalBackEnum::toArray();

        return compact('investmentType', 'interestType', 'returnType', 'capitalBack');
    }

    /**
     * get data by id
     * @param mixed $id
     * @return object
     */
    public function findById($id): object
    {
        $package = $this->packageRepository->find($id);

        return $package;
    }

    /**
     * Update package
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $packageId = $attributes['package_id'];

        try {
            DB::beginTransaction();

            $this->packageRepository->updateById($packageId, $attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => "Package update error",
                    'title'   => 'Package',
                    'errors'  => $exception,
                ], 422)
            );
        }
    }

    /**
     * Create Package
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        try {
            DB::beginTransaction();
            $package = $this->packageRepository->create($attributes);
            DB::commit();

            return $package;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * Delete expense
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes): bool
    {
        $packageId = $attributes['package_id'];

        try {
            DB::beginTransaction();

            $this->packageRepository->destroyById($packageId);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => "Package delete error",
                    'title'   => 'Package delete error',
                    'errors'  => $exception,
                ], 422)
            );
        }
    }

}
