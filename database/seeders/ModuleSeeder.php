<?php

namespace Database\Seeders;

use App\Enums\ModuleEnum;
use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Module::truncate();
        Module::insert([
            [
                "module_name" => "Package",
                "status"      => ModuleEnum::ACTIVE->value,
            ],
            [
                "module_name" => "Stake",
                "status"      => ModuleEnum::ACTIVE->value,
            ],
            [
                "module_name" => "Loan",
                "status"      => ModuleEnum::ACTIVE->value,
            ],
            [
                "module_name" => "Merchant",
                "status"      => ModuleEnum::ACTIVE->value,
            ],
            [
                "module_name" => "QuickExchange",
                "status"      => ModuleEnum::ACTIVE->value,
            ],
        ]);
    }
}