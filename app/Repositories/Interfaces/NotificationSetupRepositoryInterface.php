<?php

namespace App\Repositories\Interfaces;

use App\Enums\NotificationSetupGroupEnum;
use App\Repositories\Interfaces\BaseRepositoryInterface;

interface NotificationSetupRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get group wise Notification setup
     *
     * @param string $groupName
     * @return object
     */
    public function getGroupWiseNotifications(string $groupName): object;

    /**
     * Update by group notification setup
     *
     * @param string $group
     * @param array $attributes
     * @return boolean
     */
    public function updateByGroup($group, array $attributes): bool;

    /**
     * Update by group and id notification setup
     *
     * @param string $group
     * @param int $notificationSetupId
     * @param array $attributes
     * @return boolean
     */
    public function updateByGroupAndId($group, int $notificationSetupId, array $attributes): bool;
}
