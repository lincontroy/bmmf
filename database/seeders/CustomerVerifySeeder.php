<?php

namespace Modules\Customer\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerVerifySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'customer_id' => 1,
                'user_id'     => 'EZGQEC7C',
                'verify_type' => 'nid',
                'first_name'  => 'Mehedi',
                'last_name'   => 'Hassan',
                'gender'      => 1, // 1 for male, 0 for female
                'id_number'   => '123456789',
                'document1'   => 'noimage.jpg',
                'document2'   => 'noimage.jpg',
            ],
            [
                'customer_id' => 4,
                'user_id'     => 'DZH0AWDZ',
                'verify_type' => 'passport',
                'first_name'  => 'Taiba',
                'last_name'   => 'Islam',
                'gender'      => 0, // 1 for male, 0 for female
                'id_number'   => '987654321',
                'document1'   => 'noimage.jpg',
                'document2'   => 'noimage.jpg',
            ],
            // Add more sample data as needed
        ];

        DB::table('customer_verify_docs')->truncate();
        // Insert data into the dbt_user_verify_doc table
        DB::table('customer_verify_docs')->insert($data);
    }
}
