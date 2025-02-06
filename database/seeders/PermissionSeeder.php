<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Schema::disableForeignKeyConstraints();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        // Define your dataset
        $permissions = [
            [
                'guard_name' => 'admin',
                'name'       => 'dashboard.read',
                'group'      => 'dashboard',
            ],
            [
                'guard_name' => 'admin',
                'name'       => 'customer.read',
                'group'      => 'customer',
            ],
            [
                'guard_name' => 'admin',
                'name'       => 'customer.create',
                'group'      => 'customer',
            ],
            [
                'guard_name' => 'admin',
                'name'       => 'customer.update',
                'group'      => 'customer',
            ],
        ];

// Create permissions if they do not exist
        foreach ($permissions as $permissionData) {
            Permission::firstOrCreate(
                ['name' => $permissionData['name'], 'guard_name' => $permissionData['guard_name']],
                ['group' => $permissionData['group']]
            );
        }

        // Find the user by email
        $user = User::where('email', 'admin@demo.com')->first();

        if ($user) {
            // Extract the permission names to assign to the user
            $permissionNames = array_column($permissions, 'name');
            // Assign all permissions to the user
            $user->givePermissionTo($permissionNames);
        } else {
            echo "User with email admin@gmail.com not found.";
        }

    }

}
