<?php

namespace App\Services;

use App\Enums\NotificationSetupGroupEnum;
use App\Enums\StatusEnum;
use App\Repositories\Interfaces\NotificationSetupRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class NotificationSetupService
{
    /**
     * NotificationSetupService constructor.
     *
     * @param NotificationSetupRepositoryInterface $notificationSetupRepository
     */
    public function __construct(
        private NotificationSetupRepositoryInterface $notificationSetupRepository,
    ) {
    }

    /**
     * Form data of notification setup
     *
     * @return array
     */
    public function formData(): array
    {
        $emailNotificationSetups = $this->notificationSetupRepository->getGroupWiseNotifications(NotificationSetupGroupEnum::EMAIL->value);
        $smsNotificationSetups   = $this->notificationSetupRepository->getGroupWiseNotifications(NotificationSetupGroupEnum::SMS->value);

        return compact('emailNotificationSetups', 'smsNotificationSetups');
    }

    public function getGroupWiseNotifications($group): object
    {
        return $this->notificationSetupRepository->getGroupWiseNotifications($group->value);
    }

    /**
     * Update notification setup
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $group               = $attributes['group'];
        $notification_setups = $attributes['notification_setup'] ?? [];

        try {
            DB::beginTransaction();

            $this->notificationSetupRepository->updateByGroup($group->value, ['status' => StatusEnum::INACTIVE->value]);

            foreach ($notification_setups as $notificationSetupId) {

                $this->notificationSetupRepository->updateByGroupAndId($group->value, $notificationSetupId, ['status' => StatusEnum::ACTIVE->value]);
            }

            DB::commit();

            return true;

        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Notification setup update error"),
                'title'   => localize("Notification setup"),
                'errors'  => $exception,
            ], 422));
        }

    }

}
