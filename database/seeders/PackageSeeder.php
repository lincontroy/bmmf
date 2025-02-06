<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Package\App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::disableForeignKeyConstraints();
        Package::truncate();
        Schema::enableForeignKeyConstraints();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Package::insert([
            [
                "plan_time_id"  => 1,
                "name"          => "Gold",
                "invest_type"   => '1',
                "min_price"     => 100.000,
                "max_price"     => 500.000,
                "interest_type" => '1',
                "interest"      => 10,
                "return_type"   => '2',
                "repeat_time"   => 10,
                "capital_back"  => '1',
                "status"        => '1',
            ],
            [
                "plan_time_id"  => 2,
                "name"          => "Silver",
                "invest_type"   => '2',
                "min_price"     => 100.000,
                "max_price"     => 500.000,
                "interest_type" => '2',
                "interest"      => 50,
                "return_type"   => '1',
                "repeat_time"   => 1,
                "capital_back"  => '0',
                "status"        => '1',
            ],
        ]);
    }
}