<?php

namespace Modules\Stake\App\Services;

use App\Enums\TransactionTypeEnum;
use App\Enums\WalletManageLogEnum;
use App\Services\NotificationService;
use App\Services\WalletManageService;
use App\Services\WalletTransactionLogService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Stake\App\Enums\CustomerStakeEnum;
use Modules\Stake\App\Enums\CustomerStakeInterestEnum;
use Modules\Stake\App\Repositories\Interfaces\CustomerStakeInterestRepositoryInterface;
use Modules\Stake\App\Repositories\Interfaces\CustomerStakeRepositoryInterface;

class StakeInterestService
{
    public function __construct(
        private CustomerStakeRepositoryInterface $customerStakeRepository,
        private CustomerStakeInterestRepositoryInterface $customerInterestRepository,
        private WalletManageService $walletManageService,
        private WalletTransactionLogService $walletTransactionLogService,
        private NotificationService $notificationService,
    ) {

    }

    /**
     * Create stake
     * @param array $attributes
     * @return object
     */
    public function create(array $attributes): ?object
    {
        return $this->customerStakeRepository->create($attributes);
    }

    /**
     * Create stake interest
     * @param array $attributes
     * @return object
     */
    public function createInterest(array $attributes): ?object
    {
        return $this->customerInterestRepository->create($attributes);
    }

    /**
     * Find Redeemed stake data for send interest
     * @return void
     */
    public function findRedeemedStake(): ?object
    {
        return $this->customerInterestRepository->findRedeemedStake();
    }

    /**
     * Send stake interest and make redeemed
     * @param object $value
     * @return bool
     */
    public function sendInterest(object $value): bool
    {
        $userID           = $value->user_id;
        $acceptCurrencyId = $value->accept_currency_id;
        $interestAmount   = $value->interest_amount;
        $lockedAmount     = $value->locked_amount;

        try {

            DB::beginTransaction();

            $this->customerStakeRepository->updateById($value->customer_stake_id, [
                'status' => CustomerStakeEnum::REDEEMED->value,
            ]);

            $this->customerInterestRepository->updateById($value->id, [
                'status' => CustomerStakeInterestEnum::RECEIVED->value,
            ]);

            $this->walletManageService->create([
                'user_id'            => $userID,
                'accept_currency_id' => $acceptCurrencyId,
                'stake_earn'         => $interestAmount,
                'balance'            => $interestAmount,
            ]);

            $this->walletTransactionLogService->create([
                'user_id'            => $userID,
                'accept_currency_id' => $acceptCurrencyId,
                'transaction'        => WalletManageLogEnum::STAKE_INTEREST->value,
                'transaction_type'   => TransactionTypeEnum::CREDIT->value,
                'amount'             => $interestAmount,
            ]);

            $this->notificationService->create([
                'customer_id'       => $value->customer_id,
                'notification_type' => 'redeemed',
                'subject'           => 'Stake Interest',
                'details'           => 'You have received an Stake Interest payment of ' . $interestAmount .
                ' ' . $value->currency_symbol . ' for Stake ID ' . $value->customer_stake_id,
            ]);

            $this->walletManageService->reverseTxn([
                'user_id'            => $userID,
                'accept_currency_id' => $acceptCurrencyId,
                'freeze_balance'     => $lockedAmount,
                'balance'            => $lockedAmount,
            ]);

            $this->walletTransactionLogService->create([
                'user_id'            => $userID,
                'accept_currency_id' => $acceptCurrencyId,
                'transaction'        => WalletManageLogEnum::REDEEMED->value,
                'transaction_type'   => TransactionTypeEnum::CREDIT->value,
                'amount'             => $lockedAmount,
            ]);

            $this->notificationService->create([
                'customer_id'       => $value->customer_id,
                'notification_type' => 'redeemed',
                'subject'           => 'Stake Interest',
                'details'           => 'You have redeemed a stake with an amount of ' . $lockedAmount .
                ' ' . $value->currency_symbol,
            ]);

            DB::commit();

            return true;

        } catch (\Throwable $th) {

            DB::rollBack();

            Log::info('Stake Send' . $th->getMessage());

            return false;
        }
    }
}
