<?php

namespace Modules\Stake\App\Services;

use App\Enums\AssetsFolderEnum;
use App\Enums\AuthGuardEnum;
use App\Enums\StatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Enums\WalletManageLogEnum;
use App\Helpers\ImageHelper;
use App\Services\AcceptCurrencyService;
use App\Services\NotificationService;
use App\Services\WalletManageService;
use App\Services\WalletTransactionLogService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Stake\App\Repositories\Interfaces\StakePlanRepositoryInterface;
use Modules\Stake\App\Repositories\Interfaces\StakeRateRepositoryInterface;
use Modules\Stake\App\resources\StakePlanResource;

class StakePlanService
{
    /**
     * StakePlanService constructor.
     * @param StakePlanRepositoryInterface $stakePlanRepository
     * @param StakeRateRepositoryInterface $rateRepository
     */
    public function __construct(
        private StakePlanRepositoryInterface $stakePlanRepository,
        private StakeRateRepositoryInterface $rateRepository,
        private WalletManageService $walletManageService,
        private StakeInterestService $interestService,
        private WalletTransactionLogService $walletTransactionLogService,
        private NotificationService $notificationService,
        private AcceptCurrencyService $acceptCurrencyService
    ) {
    }

    public function findStakePlans(int $pageNo): ?object
    {
        $stakePlans = $this->stakePlanRepository->orderPaginate([
            "orderByColumn"     => "id",
            "order"             => "asc",
            "searchColumn"      => "status",
            "searchColumnValue" => StatusEnum::ACTIVE->value,
            "perPage"           => 6,
            "page"              => $pageNo,
        ]);

        if ($stakePlans) {
            return StakePlanResource::collection($stakePlans);
        }

        return (object) [];
    }

    /**
     * Delete stake plan data
     * @param array $attributes
     * @return bool
     */
    public function destroy(array $attributes): bool
    {
        $stakeId = $attributes['stake_id'];
        try {
            DB::beginTransaction();

            $this->stakePlanRepository->delete($stakeId);
            $this->rateRepository->deleteWhere('stake_plan_id', $stakeId);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }

    /**
     * get all Active data
     * @param array $attributes
     * @return object
     */
    public function allActive(array $attributes = []): object
    {
        $attributes['status'] = StatusEnum::ACTIVE->value;

        return $this->stakePlanRepository->allActive($attributes);
    }

    /**
     * Summary of find
     * @param array $attributes
     * @return object
     */
    public function find(array $attributes): object
    {
        return $this->stakePlanRepository->findOrFail($attributes['id'], ['stakeRateInfo']);
    }

    public function update(array $attributes, int $stakeId): bool
    {
        try {
            DB::beginTransaction();

            $stakeUpdateData = [
                'accept_currency_id' => $attributes['accept_currency'],
                'stake_name'         => $attributes['stake_title'],
                'status'             => $attributes['status'],
                'updated_by'         => auth(AuthGuardEnum::ADMIN->value)->user()->id,
            ];

            if (isset($attributes['image'])) {
                $stakeUpdateData['image'] = ImageHelper::upload($attributes['image'], AssetsFolderEnum::STAKE->value);
            }

            $stake = $this->stakePlanRepository->updateById($stakeId, $stakeUpdateData);

            if ($stake) {
                $this->rateRepository->deleteWhere('stake_plan_id', $stakeId);

                foreach ($attributes['duration'] as $key => $value) {
                    $interestPerDay = $attributes['interest_rate'][$key] / $value;
                    $annualRate     = $interestPerDay * 365;
                    $this->rateRepository->create([
                        "stake_plan_id" => $stakeId,
                        "duration"      => $value,
                        "rate"          => $attributes['interest_rate'][$key],
                        "annual_rate"   => $annualRate,
                        "min_amount"    => $attributes['min_value'][$key],
                        "max_amount"    => $attributes['max_value'][$key],
                    ]);
                }

            }

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }

    /**
     * Create Stake Plan
     * @param array $attributes
     * @return object
     */
    public function create(array $attributes): object
    {
        try {
            DB::beginTransaction();

            $stakePlanData = [
                'accept_currency_id' => $attributes['accept_currency'],
                'stake_name'         => $attributes['stake_title'],
                'created_by'         => auth(AuthGuardEnum::ADMIN->value)->user()->id,
            ];

            if (isset($attributes['image'])) {
                $stakePlanData['image'] = ImageHelper::upload($attributes['image'], AssetsFolderEnum::STAKE->value);
            }

            $stake = $this->stakePlanRepository->create($stakePlanData);

            if ($stake) {

                foreach ($attributes['duration'] as $key => $value) {
                    $interestPerDay = $attributes['interest_rate'][$key] / $value;
                    $annualRate     = $interestPerDay * 365;
                    $this->rateRepository->create([
                        "stake_plan_id" => $stake->id,
                        "duration"      => $value,
                        "rate"          => $attributes['interest_rate'][$key],
                        "annual_rate"   => $annualRate,
                        "min_amount"    => $attributes['min_value'][$key],
                        "max_amount"    => $attributes['max_value'][$key],
                    ]);
                }

            }

            DB::commit();

            return $stake;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }

    /**
     * Find plan by ID
     * @param int $id
     * @return object|null
     */
    public function findPlan(int $id): ?object
    {
        return $this->stakePlanRepository->find($id);
    }

    /**
     * Verify Stake for Order
     * @param array $attributes
     * @return void
     */
    public function verifyOrder(array $attributes): ?object
    {
        $lockedAmount    = $attributes['locked_amount'];
        $stakePlanId     = $attributes['stake_plan_id'];
        $stakePlanRateId = $attributes['stake_plan_rate_id'];

        $stakePlan = $this->findPlan($stakePlanId);

        if (!$stakePlan) {
            return (object) ['status' => 'error', 'message' => 'Invalid stake plan'];
        }

        $stakeRateInfo = $stakePlan->stakeRateInfo()->where('id', $stakePlanRateId)->first();

        if (!$stakeRateInfo) {
            return (object) ['status' => 'error', 'message' => 'Invalid stake plan rate'];
        }

        if ($lockedAmount < $stakeRateInfo->min_amount) {
            return (object) [
                'status'  => 'error',
                'message' => 'Minimum locked amount is ' . number_format($stakeRateInfo->min_amount, 6, '.', '') . ' '
                . $stakePlan->acceptCurrency->symbol,
            ];
        }

        if ($lockedAmount > $stakeRateInfo->max_amount) {
            return (object) [
                'status'  => 'error',
                'message' => 'Maximum locked amount is ' . number_format($stakeRateInfo->max_amount, 6, '.', '') . ' '
                . $stakePlan->acceptCurrency->symbol,
            ];
        }

        $walletBalanceInfo = $this->walletManageService->walletBalance([
            'currency_id' => $stakePlan->accept_currency_id,
            'user_id'     => auth()->user()->user_id,
        ]);

        if (!$walletBalanceInfo || $walletBalanceInfo->balance < $lockedAmount) {
            return (object) [
                'status'  => 'error',
                'message' => 'Insufficient Balance',
            ];
        }

        return (object) [
            'status' => 'success',
            'data'   => [
                'stake_plan_id'      => $stakePlan->id,
                'locked_amount'      => $lockedAmount,
                'accept_currency_id' => $stakePlan->accept_currency_id,
                'currency_symbol'    => $stakePlan->acceptCurrency->symbol,
                'stake_rate_info'    => $stakeRateInfo,
                'wallet_id'          => $walletBalanceInfo->id,
            ],
        ];
    }

    public function makeOrder(array $attributes): ?object
    {
        $stakePlanId      = $attributes['stake_plan_id'];
        $lockedAmount     = $attributes['locked_amount'];
        $acceptCurrencyId = $attributes['accept_currency_id'];
        $stakeRateInfo    = $attributes['stake_rate_info'];

        $currentDateTime = Carbon::now();
        $newDateTime     = $currentDateTime->addDays($stakeRateInfo->duration);
        $redeemedAt      = $newDateTime->toDateTimeString();

        $userId = auth()->user()->user_id;

        try {

            DB::beginTransaction();

            $customerStake = $this->interestService->create([
                'stake_plan_id'      => $stakePlanId,
                'accept_currency_id' => $acceptCurrencyId,
                'user_id'            => $userId,
                'locked_amount'      => $lockedAmount,
                'duration'           => $stakeRateInfo->duration,
                'interest_rate'      => $stakeRateInfo->rate,
                'annual_rate'        => $stakeRateInfo->annual_rate,
                'redemption_at'      => $redeemedAt,
            ]);

            if ($customerStake) {
                $this->interestService->createInterest([
                    'user_id'            => $userId,
                    'customer_id'        => auth()->user()->id,
                    'customer_stake_id'  => $customerStake->id,
                    'currency_symbol'    => $attributes['currency_symbol'],
                    'accept_currency_id' => $acceptCurrencyId,
                    'locked_amount'      => $lockedAmount,
                    'interest_amount'    => $lockedAmount * ($stakeRateInfo->rate / 100),
                    'redemption_at'      => $redeemedAt,
                ]);
            }

            $this->walletManageService->balanceDeduct([
                'freeze_balance' => $lockedAmount,
                'balance'        => $lockedAmount,
            ], $attributes['wallet_id']);

            $this->walletTransactionLogService->create([
                'user_id'            => $userId,
                'accept_currency_id' => $acceptCurrencyId,
                'transaction'        => WalletManageLogEnum::STAKE->value,
                'transaction_type'   => TransactionTypeEnum::DEBIT->value,
                'amount'             => $lockedAmount,
            ]);

            $this->notificationService->create([
                'customer_id'       => auth()->user()->id,
                'notification_type' => 'transfer',
                'subject'           => 'Transfer',
                'details'           => 'Your staked of ' . $lockedAmount . ' '
                . $attributes['currency_symbol'] . ' has been successfully processed.',
            ]);

            DB::commit();

            return (object) ['status' => 'success', 'message' => 'Staked successfully'];

        } catch (\Throwable $th) {
            DB::rollBack();

            return (object) ['status' => 'error', 'message' => $th->getMessage()];
        }

    }

}
