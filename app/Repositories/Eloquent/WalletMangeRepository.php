<?php

namespace App\Repositories\Eloquent;

use App\Models\AcceptCurrency;
use App\Models\WalletManage;
use App\Repositories\Interfaces\WalletManageRepositoryInterface;

class WalletMangeRepository extends BaseRepository implements WalletManageRepositoryInterface
{
    /**
     * @param WalletManage $walletManage
     */
    public function __construct(WalletManage $walletManage)
    {
        parent::__construct($walletManage);
    }

    /**
     * @return object|null
     */
    public function topInvestors(): ?object
    {
        return $this->model->with('customerInfo')->orderBy("investment", "desc")->limit(50)->get();
    }

    /**
     * @param array $attributes
     * @return object|null
     */
    public function getBalance(array $attributes = []): float
    {
        // Fetch exchange rates from the accept_currencies table
        $exchangeRates = AcceptCurrency::pluck('rate', 'id');

        // Fetch all balances
        $balances = WalletManage::all()->where('user_id', $attributes['user_id']);

        // Convert each balance to USD
        $totalBalanceUSD = $balances->reduce(function ($total, $balance) use ($exchangeRates) {
            $coin = $balance->accept_currency_id;
            $balanceUSD = $balance->balance * $exchangeRates[$coin];
            return $total + $balanceUSD;
        }, 0);

        return $totalBalanceUSD;
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public function updateByUserId(string $userId, array $attributes): bool
    {
        $currencyId = $attributes['accept_currency_id'];

        return $this->model->where('user_id', $userId)->where('accept_currency_id', $currencyId)->update($attributes);
    }

}
