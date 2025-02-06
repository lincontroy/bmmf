<?php

namespace Database\Seeders;

use App\Models\AcceptCurrency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AcceptCurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        AcceptCurrency::truncate();
        Schema::enableForeignKeyConstraints();

        AcceptCurrency::insert([
            [
                "name"   => "United States Dollar",
                "symbol" => "USD",
                "logo"   => "crypto/usd.svg",
            ],
            [
                "name"   => "Bitcoin",
                "symbol" => "BTC",
                "logo"   => "crypto/btc.svg",
            ],
            [
                "name"   => "Ethereum",
                "symbol" => "ETH",
                "logo"   => "crypto/eth.svg",
            ],
        ]);
    }
}