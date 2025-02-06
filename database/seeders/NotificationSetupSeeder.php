<?php

namespace Database\Seeders;

use App\Enums\NotificationSetupGroupEnum;
use App\Models\NotificationSetup;
use Illuminate\Database\Seeder;

class NotificationSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NotificationSetup::truncate();

        $notifications = [
            NotificationSetupGroupEnum::EMAIL->value => [
                'Payout',
                'Commission',
                'Withdrew',
                'Transfer',
            ],
            NotificationSetupGroupEnum::SMS->value => [
                'Payout',
                'Commission',
                'Withdrew',
                'Transfer',
            ],
        ];

        $insertNotificationSetups = [];

        foreach ($notifications as $group => $groups) {

            foreach ($groups as $notification) {

                $notificationExists = NotificationSetup::query()
                    ->where('name', $notification)
                    ->where('group', $group)
                    ->exists();

                if (!$notificationExists) {
                    $insertNotificationSetups[] = [
                        'name'  => $notification,
                        'group' => $group,
                    ];
                }

            }

        }

        if (!empty($insertNotificationSetups)) {
            NotificationSetup::query()
                ->insert($insertNotificationSetups);
        }

    }

}
