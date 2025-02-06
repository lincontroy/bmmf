<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::truncate();
        Setting::create([
            "title"       => "Nishue - Crypto Investment Platform",
            "description" => "Nishue - CryptoCurrency Buy Sell Exchange and Lending with MLM System | Crypto Investment Platform",
            "email"       => "info@bdtask.com",
            "phone"       => "+880-185-767-5727",
            "language_id" => 1,
        ]);
    }
}
