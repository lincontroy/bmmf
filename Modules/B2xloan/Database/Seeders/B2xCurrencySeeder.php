<?php

namespace Modules\B2xloan\Database\Seeders;

use App\Repositories\Interfaces\AcceptCurrencyRepositoryInterface;
use Illuminate\Database\Seeder;
use Modules\B2xloan\App\Models\B2xCurrency;

class B2xCurrencySeeder extends Seeder
{
    /**
     * B2xLoanApiService constructor.
     *
     */
    public function __construct(
        private AcceptCurrencyRepositoryInterface $acceptCurrencyRepository,

    ) {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $btcRate = $this->acceptCurrencyRepository->firstWhere('symbol', 'BTC');

        B2xCurrency::truncate();
        B2xCurrency::insert([
            [
                "accept_currency_id" => $btcRate->id,
                "price"              => 65000.00,
            ],
        ]);
    }
}
