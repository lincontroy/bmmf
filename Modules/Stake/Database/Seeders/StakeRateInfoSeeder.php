<?php

namespace Modules\Stake\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Stake\App\Models\StakeRateInfo;

class StakeRateInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::disableForeignKeyConstraints();
        StakeRateInfo::truncate();
        Schema::enableForeignKeyConstraints();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        StakeRateInfo::insert([
            [
                "stake_plan_id" => 1,
                "duration"      => 60,
                "rate"          => 10,
                "annual_rate"   => 60,
                "min_amount"    => 1,
                "max_amount"    => 5,
            ],
            [
                "stake_plan_id" => 2,
                "duration"      => 90,
                "rate"          => 20,
                "annual_rate"   => 120,
                "min_amount"    => 2,
                "max_amount"    => 7,
            ],
        ]);
    }
}
