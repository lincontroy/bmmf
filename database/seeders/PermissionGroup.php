<?php

namespace Database\Seeders;

use App\Models\PermissionGroup as PermissionGroupModels;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PermissionGroup extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PermissionGroupModels::truncate();

        $group = [
            'User',
            'Roles',
        ];

        foreach ($group as $key => $value) {
            PermissionGroupModels::create([
                "name"       => $value,
                "created_at" => Carbon::now(),
            ]);
        }

    }

}
