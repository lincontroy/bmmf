<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Customer::truncate();
        Schema::enableForeignKeyConstraints();

        Customer::insert([
            "user_id"           => strtoupper(Str::random(8)),
            "first_name"        => "Customer",
            "last_name"         => "Last Name",
            "username"          => "customer",
            "email"             => 'customer@demo.com',
            "password"          => bcrypt('123456'),
            "phone"             => '+123456789',
        ]);
    }
}
