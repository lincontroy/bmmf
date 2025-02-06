<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(AcceptCurrencySeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(ArticleDataSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(ArticleLangDataSeeder::class);
        $this->call(PlanTimeSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(PermissionGroup::class);
        $this->call(TeamMemberSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserLogsSeeder::class);
        $this->call(NotificationSetupSeeder::class);
        $this->call(CreatePermissionSeeder::class);
    }
}
