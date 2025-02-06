<?php

namespace Database\Seeders;

use App\Models\FiatCurrency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FiatCurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::disableForeignKeyConstraints();
        FiatCurrency::truncate();
        Schema::enableForeignKeyConstraints();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        FiatCurrency::insert([
            [
                "name"   => "United States Dollar",
                "symbol" => "USD",
            ],
            [
                "name"   => "Euro",
                "symbol" => "EUR",
            ],
            [
                "name"   => "British Pound Sterling",
                "symbol" => "GBP",
            ],
            [
                "name"   => "Japanese Yen",
                "symbol" => "JPY",
            ],
            [
                "name"   => "Swiss Franc",
                "symbol" => "CHF",
            ],
            [
                "name"   => "Canadian Dollar",
                "symbol" => "CAD",
            ],
            [
                "name"   => "Australian Dollar",
                "symbol" => "AUD",
            ],
            [
                "name"   => "Chinese Yuan",
                "symbol" => "CNY",
            ],
            [
                "name"   => "Indian Rupee",
                "symbol" => "INR",
            ],
            [
                "name"   => "Russian Ruble",
                "symbol" => "RUB",
            ],
        ]);
    }
}
