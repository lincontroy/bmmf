<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SystemUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        User::insert([
            "first_name" => "Super",
            "last_name"  => "Admin",
            "email"      => "admin@demo.com",
            "password"   => Hash::make("12345678"),
        ]);
    }
}
