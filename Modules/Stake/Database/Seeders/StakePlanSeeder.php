<?php

namespace Modules\Stake\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Stake\App\Models\StakePlan;

class StakePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::disableForeignKeyConstraints();
        StakePlan::truncate();
        Schema::enableForeignKeyConstraints();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        StakePlan::insert([
            [
                "accept_currency_id" => 2,
                "stake_name"         => "Bitcoin",
            ],
            [
                "accept_currency_id" => 3,
                "stake_name"         => "Ethereum",
            ],
        ]);
    }
}
