<?php

namespace Modules\Stake\Database\Seeders;

use Illuminate\Database\Seeder;

class StakeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            StakePlanSeeder::class,
            StakeRateInfoSeeder::class,
        ]);
    }
}
