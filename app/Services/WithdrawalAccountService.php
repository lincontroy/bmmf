<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Repositories\Interfaces\WithdrawAccountCredentialRepositoryInterface;
use App\Repositories\Interfaces\WithdrawAccountRepositoryInterface;
use App\Services\AcceptCurrencyService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WithdrawalAccountService
{
    public function __construct(
        private WithdrawAccountRepositoryInterface $withdrawAccountRepository,
        private WithdrawAccountCredentialRepositoryInterface $withdrawCredentialRepository,
        private AcceptCurrencyService $acceptCurrencyService,
    ) {

    }

    public function create(array $attributes): ?object
    {
        $currencyInfo = $this->acceptCurrencyService->findCurrencyBySymbol($attributes['payment_currency']);

        if (!$currencyInfo) {
            return (object) ['status' => 'error', 'message' => 'Invalid Currency'];
        }

        $checkExists = $this->withdrawAccountRepository->findAccount([
            'customer_id'        => auth()->user()->id,
            'payment_gateway_id' => $attributes['payment_method'],
            'accept_currency_id' => $currencyInfo->id,
        ]);

        if ($checkExists) {
            return (object) ['status' => 'error', 'message' => 'Withdrawal account already exist'];
        }

        try {
            DB::beginTransaction();

            $withdrawalAccount = $this->withdrawAccountRepository->create([
                'customer_id'        => auth()->user()->id,
                'payment_gateway_id' => $attributes['payment_method'],
                'accept_currency_id' => $currencyInfo->id,
                'status'             => StatusEnum::ACTIVE->value,
            ]);

            if ($withdrawalAccount) {

                foreach ($attributes['account_label'] as $key => $value) {
                    $type = Str::lower($value);
                    $type = Str::replace(' ', '_', $type);
                    $this->withdrawCredentialRepository->create([
                        "withdrawal_account_id" => $withdrawalAccount->id,
                        "type"                  => $type,
                        "name"                  => $value,
                        "credential"            => $attributes['account_value'][$key],
                    ]);
                }

            }

            DB::commit();

            return (object) ['status' => 'success', 'data' => $withdrawalAccount];

        } catch (\Exception $exception) {
            DB::rollBack();
            return (object) ['status' => 'error', 'message' => $exception->getMessage()];
        }

    }

    /**
     * Find withdrawal account
     * @param array $attributes
     * @return object|null
     */
    public function findWithdrawalAccount(array $attributes): ?object
    {
        $currencyInfo = $this->acceptCurrencyService->findCurrencyBySymbol($attributes['payment_currency']);

        if (!$currencyInfo) {
            return null;
        }

        return $this->withdrawAccountRepository->findAccount([
            'customer_id'        => auth()->user()->id,
            'payment_gateway_id' => $attributes['payment_method'],
            'accept_currency_id' => $currencyInfo->id,
        ]);
    }

    /**
     * Destroy Withdrawal Account
     * @param array $attributes
     * @return bool
     */
    public function destroy(array $attributes): bool
    {
        return $this->withdrawAccountRepository->delete($attributes['account_id']);
    }

}
