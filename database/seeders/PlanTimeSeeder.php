<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Package\App\Models\PlanTime;

class PlanTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::disableForeignKeyConstraints();
        PlanTime::truncate();
        Schema::enableForeignKeyConstraints();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        PlanTime::insert([
            [
                "name_"  => "Weekly Time",
                "hours_" => 168,
            ],
            [
                "name_"  => "Monthly Time",
                "hours_" => 720,
            ],
        ]);
    }
}