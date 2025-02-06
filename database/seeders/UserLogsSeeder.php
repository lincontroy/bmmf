<?php

namespace Database\Seeders;

use App\Enums\UserLogTypeEnum;
use App\Models\UserLog;
use Carbon\Carbon;
use Faker\Provider\UserAgent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        UserLog::truncate();
        Schema::enableForeignKeyConstraints();

        UserLog::insert([
            [
                "user_id" => "EZGQEC7C",
                "type" => UserLogTypeEnum::LOGIN->value,
                "access_time" => Carbon::now(),
                "user_agent" =>request()->header('User-Agent'),
                "user_ip" => request()->ip(),
                "created_at" => Carbon::now(),
            ],
            [
                "user_id" => "DZH0AWDZ",
                "type" => UserLogTypeEnum::LOGOUT->value,
                "access_time" => Carbon::now(),
                "user_agent" =>request()->header('User-Agent'),
                "user_ip" => request()->ip(),
                "created_at" => Carbon::now(),
            ]
        ]);
    }
}
